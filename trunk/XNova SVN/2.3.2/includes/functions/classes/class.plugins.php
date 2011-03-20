<?php
//version 1.2
class plugins extends editor_core {
    private $folder_plugins             = 'includes/pages/plugins/' ;
    var     $folder_template_plugins    = 'plugins/'                    ;
    //private $page_plugins;
    //private $check_install_array;
    private $check_install;
    private $check_plugins;
    private $config_plugins = array();
    private $root;
    private $class_new;

    private $check=array();
    private $errors=array();
    private $error=array();
    function __construct(){
        global $db;

        $configs  = $db->query('SELECT * FROM {{table}}', 'plugins');
        while($plugin = mysql_fetch_array($configs)){
            $this->config_plugins[$plugin['name_plugins']] = array('id'=>$plugin['id_plugins'],
                'acti'=>$plugin['activate_plugins'],
                'menu'=>$plugin['menu_plugins'],
                'page'=>$plugin["page_plugins"],
                'pos'=>$plugin["pos_plugins"]);
        }
        Console::log($this->config_plugins);
        
        foreach($GLOBALS as $a => $b){
            if(preg_match("/_root/i",$a)){
                $this->root=$b;break;
            }
        }

    }


    public function is_plugins($page){
        
        $ADMIN=preg_match("/admin.php/i",$_SERVER["SCRIPT_FILENAME"])?true:false;


        $page=ucfirst(strtolower($page));
        $this->folder_plugins=($this->root.$this->folder_plugins);
        $PluginsFolder = opendir($this->folder_plugins);

        while (($PluginsFolders = readdir($PluginsFolder)) !== false){
            $plugin_info = pathinfo($this->folder_plugins . $PluginsFolders);
            
            if($plugin_info["extension"]=="php" 
                    && $plugin_info["filename"]!= "index"
                    && !preg_match("/_lang/i",$plugin_info["filename"]) )
            {
                    $name_plug=explode(".",$plugin_info["filename"]);
                    if($name_plug[1]==$page){
                        $this->check_plugins($name_plug[1]);
                        if(file_exists($this->folder_plugins.$PluginsFolders)
                                && $this->check_install
                                && $this->check_plugins   ){
                                include($this->folder_plugins.$PluginsFolders);

                                $this->class_new = new $name_plug[1]();
                                $this->class_new->show();
                                return true;
                          }
                    }
            }
        }
        closedir($PluginsFolder);
    }

    private function check_plugins($page){
        $this->check_install = (isset($this->config_plugins[$page]) &&
                                is_array($this->config_plugins[$page]) ) ? true : false;
        $this->check_plugins = ($this->config_plugins[$page]['acti']!=0)  ? true : false;
    }
    public function lang_plugin($archivo,$lenguage){
        $path=$this->root .$this->folder_plugins.'/' . $archivo . '_lang.php';
        if(file_exists($path)){
            include($path);
            return $lang[$lenguage];
        }
    }
    private function query_install($name,$type,$pos){
        global $db;
        $db->query("INSERT INTO `{{table}}plugins` (
            `name_plugins` ,
            `menu_plugins`,
            `activate_plugins`,
            `page_plugins`,
            `pos_plugins`
            )
            VALUES (
            '{$name}','{$name}', '0','{$type}', '{$pos}');",'');
    }
    function edit_install(){
            foreach ($this->class_new->instalacion as $archivo => $funcion) {
                if(!$_GET["check"]){

                    $this->open_file($archivo,"backup/".date("d-m-Y",time())."/");
                    foreach($funcion as $funcions => $parametros){
                        $functions=explode(":",$funcions);
                            $this->error[$archivo][]=$this->$functions[0]($parametros[0],$parametros[1],$parametros[2])?1:0;;
                            $this->close_edit();
                    }
                    $this->close_file($archivo);

                }else{
                        $this->open_file($archivo,"backup/".date("d-m-Y",time())."/");
                        foreach($funcion as $funcions => $parametros){
                            $functions=explode(":",$funcions);                          
                                $this->check[$archivo][]=$this->find($parametros[0])?1:0;
                                $this->close_edit();
                               
                        }
                }

            }
            foreach($this->error as $archivo => $a){
                foreach($a as $b){
                    if($b==0){
                        $this->errors[$archivo]+=1;
                    }else{
                        $this->errors[$archivo]+=0;
                    }
                }
             }
    }

    public function admin_page_plugin(){
        global $displays,$db,$lang;
        if($_POST["submit"]){
            unset($_POST["submit"]);
                   foreach($_POST as $key => $value){
                        if(preg_match("/_/i", $key)){
                            include($this->folder_plugins."plugins.".$value.".php");
                            if(class_exists($value)){
                                unset($_GET["check"]);
                                $this->class_new = new $value();
                                $this->class_new->install();
                                if(isset($this->class_new->instalacion)){
                                    $this->edit_install();
                                }
                                $i=0;
                                $error="<br>En el Script ".$value."<br>";
                                foreach($this->errors as $archivo => $a){
                                   if($a>0){
                                        $error.="Error en la modificacaión del archivo :".$archivo."</br>";
                                        $i++;
                                    }else{
                                        $error.="Modificado Correctamente :".$archivo."</br>";
                                    }
                                 }
                                 if($i==0){
                                        $this->query_install($this->class_new->name,$this->class_new->type,$this->class_new->pos);
                                 }
                            }
                        }
                   } 
                   
                   foreach($this->config_plugins as $name => $array){
                           $_POST[$name]=isset($_POST[$name])?"1":"0";

                           if($_POST[$name]!= $array["acti"]){
                               $query[] =" `activate_plugins` = '". $_POST[$name]."' ";
                           }
                           if(($_POST["pos:".$array['id']]!=$array['pos']) 
                                   && $array['pos']!=10 &&
                                   is_numeric($_POST["pos:".$array['id']])){
                               $and=isset($query[0])?"AND":"";
                               $query[] =$and." `pos_plugins`='".$_POST["pos:".$array['id']]."'";
                           }
                           if(is_array($query)){
                                $db->query("UPDATE `{{table}}` SET ".$query[0].$query[1]."
                                    WHERE `name_plugins` ='".$name."';","plugins");
                                 unset($query);
                           }

                   }
                   
                   $displays->message("Los cambios se han realizado con exito ".$error, false,false,true);
        }
        $displays->assignContent("adm/plugins");

        $PluginsFolder = opendir($this->folder_plugins);
	while (($PluginsFolders = readdir($PluginsFolder)) !== false){
            $plugin_info = pathinfo($this->folder_plugins . $PluginsFolders);
            if($plugin_info["extension"]=="php" 
                    && $plugin_info["filename"]!= "index"
                    && !preg_match("/_lang/i",$plugin_info["filename"]) ){
                        $name_plug=explode(".",$plugin_info["filename"]);
                        
                        $displays->newblock("plugins_list");
                        $name_plug=explode(".",$plugin_info["filename"]);
                        $this->check_plugins($name_plug[1]);

                        if( $_GET["name"]==$name_plug[1] && !$this->check_install){
                                include($this->folder_plugins.$PluginsFolders);

                                if(class_exists($name_plug[1])){
                                    $this->class_new = new $name_plug[1]();
                                    $this->class_new->install();
                                    if(isset($this->class_new->instalacion)){
                                        $this->edit_install();
                                    }
                                     if(!empty ($this->check)){
                                         $displays->newblock("check");
                                             $prueba="<ul>";

                                        foreach($this->check as $archivo => $a){
                                            $prueba.="<li>{$archivo}";
                                            $i=0;
                                            foreach($a as $b){
                                                if($b==0){
                                                    $i++;
                                                }
                                            }
                                            $prueba.=($i>0)?" Error":" Correcto";
                                            $prueba.="</li>";
                                        }
                                     $prueba.="</ul>";
                                    $displays->assign("prueba", $prueba);
                                    $displays->gotoBlock("plugins_list");
                                    }
                                }else{
                                    $displays->newblock("check");
                                    $displays->assign("prueba", "-No existe la class");
                                    $displays->gotoBlock("plugins_list");
                                }
                        }
                       
                        $install= $this->check_install? "Instalado" : "No instalado";
                        $ins    = $this->check_install? "" : "_install";
                        $check_link=!$this->check_install?"<a href=\"?page=plugins&name={$name_plug[1]}&check=1\">Comprobar Instalación</a>":"";
                        $displays->assign("name_plugin",$name_plug[1]);
                        $displays->assign("check_link",$check_link);
                        $displays->assign("name_2_plugin",$name_plug[1].$ins);
                        $return_check=$this->check_plugins? "CHECKED" : "";
                        $displays->assign("check",$return_check);
                        
                        $return_check=$this->check_plugins || ($this->config_plugins[$name_plug[1]] && $this->config_plugins[$name_plug[1]]['page']==0) ? " Activado" : " Desactivado";
                        $displays->assign("install",$install.$return_check);

                        $ins2   = $this->check_install? "value=1" : "value='".$name_plug[1]."'";
                        $displays->assign("value",$ins2);
                        if($this->config_plugins[$name_plug[1]]['pos']!=10 &&
                                $this->config_plugins[$name_plug[1]] &&
                                $this->config_plugins[$name_plug[1]]['page']!=0){

                                $displays->newblock("posicion");
                                $displays->assign("id",$this->config_plugins[$name_plug[1]]['id']);
                                $displays->assign("selected_".$this->config_plugins[$name_plug[1]]['pos'],"selected");
                        }
                }
        }
        $displays->display();
    }
    


    public function plugin_menu(){
        $pos = array();
        $pos[1] = 'lm_defenses';
        $pos[2] = 'lm_search';
        $pos[3] = 'lm_options';
        $pos[10]= 'mu_connected';

        foreach($this->config_plugins as $name => $array) {
               if($array['acti']==1 && $array['page']==1){
                   if($array['pos']==10){
                        $end_hack = "</a></th></tr>";
                        $start_hack = '<tr><th>
                                       <a href="?page='.strtolower($name).'">'.ucfirst(strtolower($array['menu']));
                        $parse[$pos[$array['pos']]] .= $end_hack . $start_hack;
                   }else{
                        // Pagina de usuario
                        $end_hack = "</a></font></div></td></tr>";
                        $start_hack = '<tr><td><div align="center"><font color="#FFFFFF">
                                       <a href="?page='.strtolower($name).'">'.ucfirst(strtolower($array['menu']));
                        $parse[$pos[$array['pos']]] .= $end_hack . $start_hack;
                    }
               }

         }
        return  $parse;
    }

}

class editor_core
{

	var $file_contents = '';
	var $open_filename = '';
	var $write_method = 0;
	var $start_index = 0;
	var $last_string_offset = 0;
	var $last_inline_ary_offset = 0;
	var $install_time = 0;
	var $template_id = 0;
	var $last_action = array();
	var $curr_action = array();



	/**
	* Make all line endings the same - UNIX
	*/
	function normalize($string)
	{
		$string = str_replace(array("\r\n", "\r"), "\n", $string);
		return $string;
	}

	/**
	* Open a file with IO, for processing
	*
	* @param string $filename - relative path from phpBB Root to the file to open
	* 		e.g. viewtopic.php, styles/prosilver/templates/index_body.html
	*/
	function open_file($filename, $backup_path)
	{
            
		$this->file_contents = @file($filename);


		$this->file_contents = $this->normalize($this->file_contents);

		// Check for file contents in the database if this is a template file
		// this will overwrite the @file call if it exists in the DB.
		if (strpos($filename, 'template/') !== false)
		{
			// grab template name and filename
			preg_match('#styles/([a-z0-9_]+)/template/([a-z0-9_]+.[a-z]+)#i', $filename, $match);


				$this->file_contents = explode("\n", $this->normalize($row['template_data']));

				// emulate the behavior of file()
				$lines = sizeof($this->file_contents);
				for ($i = 0; $i < $lines; $i++)
				{
					$this->file_contents[$i] .= "\n";
				}

				$this->template_id = $row['template_id'];

		}

		/*
		* If the file does not exist, or is empty, die.
		* Non existant files cannot be edited, and empty files will have no
		* finds
		*/
		if (!sizeof($this->file_contents))
		{
			global $lang, $svn_root;
			trigger_error(sprintf($lang['MOD_OPEN_FILE_FAIL'], "$svn_root$filename"), E_USER_WARNING);
		}else{

                    $this->start_index = 0;
                    $this->open_filename = $filename;

                    // Make a backup of this file
                    $this->backup_file($backup_path);
                }
	}



        function backup_file($backup_dir)
	{
		return $this->close_file($backup_dir . $this->open_filename);
	}


	/**
	* Checks if a find is present
	* Keep in mind partial finds and multi-line finds
	*
	* @param string $find - string to find
	* @return mixed : array with position information if $find is found; false otherwise
	*/
	function find($find)
	{
		$find_success = 0;

		$find = $this->normalize($find);
		$find_ary = explode("\n", $find);

		$total_lines = sizeof($this->file_contents);
		$find_lines = sizeof($find_ary);

		$mode = array('', 'trim');

		foreach ($mode as $function)
		{
			// we process the file sequentially ... so we keep track of indices
			for ($i = $this->start_index; $i < $total_lines; $i++)
			{
				for ($j = 0; $j < $find_lines; $j++)
				{
					if ($function)
					{
						$find_ary[$j] = $function($find_ary[$j]);
					}
                                        // if we've reached the EOF, the find failed.
					if (!isset($this->file_contents[$i + $j]))
					{
						return false;
					}

					if (!trim($find_ary[$j]))
					{
						// line is blank.  Assume we can find a blank line, and continue on
						$find_success += 1;
					}
					// using $this->file_contents[$i + $j] to keep the array pointer where I want it
					// if the first line of the find (index 0) is being looked at, $i + $j = $i.
					// if $j is > 0, we look at the next line of the file being inspected
					// hopefully, this is a decent performer.
					else if (strpos($this->file_contents[$i + $j], $find_ary[$j]) !== false)
					{
						// we found this part of the find
						$find_success += 1;
					}
					// we might have an increment operator, which requires a regular expression match
					else if (strpos($find_ary[$j], '{%:') !== false)
					{
						$regex = preg_replace('#{%:(\d+)}#', '(\d+)', $find_ary[$j]);

						if (preg_match('#' . $regex . '#is', $this->file_contents[$i + $j]))
						{
							$find_success += 1;
						}
						else
						{
							$find_success = 0;
						}
					}
					else
					{
						// the find failed.  Reset $find_success
						$find_success = 0;

						// skip to next iteration of outer loop, that is, skip to the next line
						break;
					}

					if ($find_success == $find_lines)
					{
						// we found the proper number of lines
						$this->start_index = $i;

						// return our array offsets
						return array(
							'start' => $i,
							'end' => $i + $j,
						);
					}

				}
			}
		}

		// if return has not been previously invoked, the find failed.
		return false;
	}

	/**
	* This function is used to determine when an edit has ended, so we know that
	* the current line will not be looked at again.  This fixes some former bugs.
	*/
	function close_edit()
	{
		$this->start_index++;
		$this->last_action = array();
		$this->last_string_offset = 0;
	}

	/*
	* In-line analog to close_edit(), above.
	* Advance the pointer one character
	*/
	function close_inline_edit()
	{
		$this->last_string_offset++;
	}

	/**
	* Find a string within a given line
	*
	* @param string $find Complete find - narrows the scope of the inline search
	* @param string $inline_find - the substring to find
	* @param int $start_offset - the line number where $find starts
	* @param int $end_offset - the line number where $find ends
	*
	* @return mixed array on success or false on failure of find
	*/
	function inline_find($find, $inline_find, $start_offset = false, $end_offset = false)
	{
		$find = $this->normalize($find);

                if ($start_offset === false || $end_offset === false)
		{
			$offsets = $this->find($find);
			if (!$offsets)
			{
				// the find failed, so no further action can occur.
                                return false;
			}

			$start_offset = $offsets['start'];
			$end_offset = $offsets['end'];

			unset($offsets);
		}

		// cast is required in case someone tries to find a number
		// Often done in colspan="7" type inline operations
		$inline_find = (string) $inline_find;

		// similar method to find().  Just much more limited scope
		for ($i = $start_offset; $i <= $end_offset; $i++)
		{
			if ($this->last_string_offset > 0 && ($this->last_inline_ary_offset == 0 || $this->last_inline_ary_offset == $i))
			{
				$string_offset = strpos(substr($this->file_contents[$i], $this->last_string_offset), $inline_find);

				if ($string_offset !== false)
				{
					$string_offset += $this->last_string_offset;
				}
			}
			else
			{
				$string_offset = strpos($this->file_contents[$i], $inline_find);
			}

			if ($string_offset !== false)
			{
				$this->last_string_offset = $string_offset;
				$this->last_inline_ary_offset = $i;

				// if we find something, return the line number, string offset, and find length
				return array(
					'array_offset'	=> $i,
					'string_offset'	=> $string_offset,
					'find_length'	=> strlen($inline_find),
				);
			}
		}

		// if the previous failed, trim() the find and try again
		for ($i = $start_offset; $i <= $end_offset; $i++)
		{
			$inline_find = trim($inline_find);
			if ($this->last_string_offset > 0 && ($this->last_inline_ary_offset == 0 || $this->last_inline_ary_offset == $i))
			{
				$string_offset = strpos(substr($this->file_contents[$i], $this->last_string_offset), $inline_find);

				if ($string_offset !== false)
				{
					$string_offset += $this->last_string_offset;
				}
			}
			else
			{
				$string_offset = strpos($this->file_contents[$i], $inline_find);
			}

			if ($string_offset !== false)
			{
				$this->last_string_offset = $string_offset;

				// if we find something, return the line number, string offset, and find length
				return array(
					'array_offset'	=> $i,
					'string_offset'	=> $string_offset,
					'find_length'	=> strlen($inline_find),
				);
			}
		}

		return false;
	}


	/**
	* Add a string to the file, BEFORE/AFTER the given find string
	* @param string $find - Complete find - narrows the scope of the inline search
	* @param string $add - The string to be added before or after $find
	* @param string $pos - BEFORE or AFTER
	* @param int $start_offset - First line in the FIND
	* @param int $end_offset - Last line in the FIND
	*
	* @return bool success or failure of add
	*/
	function add_string($find, $add, $pos, $start_offset = false, $end_offset = false)
	{
		// this seems pretty simple...throughly test
		$add = $this->normalize($add);

		if ($start_offset === false || $end_offset === false)
		{
			$offsets = $this->find($find);

			if (!$offsets)
			{
				// the find failed, so the add cannot occur.
				return false;
			}

			$start_offset = $offsets['start'];
			$end_offset = $offsets['end'];

			unset($offsets);
		}

		$full_find = array();
		for ($i = $start_offset; $i <= $end_offset; $i++)
		{
			$full_find[] = $this->file_contents[$i];
		}

		$full_find[0] = ltrim($full_find[0], "\n");
		$full_find[sizeof($full_find) - 1] = rtrim($full_find[sizeof($full_find) - 1], "\n");

		// make sure our new lines are correct
		$add = "\n" . trim($add, "\n") . "\n";

		if ($pos == 'AFTER')
		{
			$this->file_contents[$end_offset] = rtrim($this->file_contents[$end_offset], "\n") . $add;
		}

		if ($pos == 'BEFORE')
		{
			$this->file_contents[$start_offset] = $add . ltrim($this->file_contents[$start_offset], "\n");
		}

		$this->curr_action = func_get_args();
		//$this->build_uninstall(implode("", $full_find), NULL, strtolower($pos) . ' add', $add);

		return true;
	}




	/**
	* Replace a string - replaces the entirety of $find with $replace
	*
	* @param string $find - Complete find - contains $inline_find
	* @param string $replace - Will replace $find
	* @param int $start_offset - First line in the FIND
	* @param int $end_offset - Last line in the FIND
	*
	* @return bool
	*/
	function replace_string($find, $replace, $start_offset = false, $end_offset = false)
	{
		$replace = $this->normalize($replace);

		if ($start_offset === false || $end_offset === false)
		{
			$offsets = $this->find($find);

			if (!$offsets)
			{
				return false;
			}

			$start_offset = $offsets['start'];
			$end_offset = $offsets['end'];
			unset($offsets);
		}

		// remove each line from the file, but add it to $full_find
		$full_find = array();
		for ($i = $start_offset; $i <= $end_offset; $i++)
		{
			$full_find[] = $this->file_contents[$i];
			$this->file_contents[$i] = '';
		}

		$this->file_contents[$start_offset] = rtrim($replace) . "\n";

		$this->curr_action = func_get_args();
		//$this->build_uninstall(implode("", $full_find), NULL, 'replace-with', $replace);

		return true;
	}

	/*
	* Replace $inline_find with $inline_replace
	* Arguments are very similar to inline_add, below
	*/
	function inline_replace($find, $inline_find, $inline_replace, $array_offset = false, $string_offset = false, $length = false)
	{
		if ($string_offset === false || $length === false)
		{
			// look for the inline find
			$inline_offsets = $this->inline_find($find, $inline_find);
                        if (!$inline_offsets)
			{
				return false;
			}

			$array_offset = $inline_offsets['array_offset'];
			$string_offset = $inline_offsets['string_offset'];
			$length = $inline_offsets['find_length'];
			unset($inline_offsets);
		}

		$this->file_contents[$array_offset] = substr_replace($this->file_contents[$array_offset], $inline_replace, $string_offset, $length);

		$this->last_string_offset += strlen($inline_replace) - 1;

		$this->curr_action = func_get_args();

		// This isn't a full find, but it is the closest we can get
		//$this->build_uninstall($this->file_contents[$array_offset], $inline_find, 'in-line-replace', $inline_replace);

		return true;
	}

	/**
	* Adds a string inline before or after a given find
	*
	* @param string $find Complete find - narrows the scope of the inline search
	* @param string $inline_find - the string to add before or after
	* @param string $inline_add - added before or after $inline_find
	* @param string $pos - 'BEFORE' or 'AFTER'
	* @param int $array_offset - line number where $inline_find may be found (optional)
	* @param int $string_offset - location within the line where $inline_find begins (optional)
	* @param int $length - essentially strlen($inline_find) (optional)
	*
	* @return bool success or failure of action
	*/
	function inline_add($find, $inline_find, $inline_add, $pos, $array_offset = false, $string_offset = false, $length = false)
	{
		if ($string_offset === false || $length === false)
		{
			// look for the inline find
			$inline_offsets = $this->inline_find($find, $inline_find);

			if (!$inline_offsets)
			{
				return false;
			}

			$array_offset = $inline_offsets['array_offset'];
			$string_offset = $inline_offsets['string_offset'];
			$length = $inline_offsets['find_length'];
			unset($inline_offsets);
		}

		if ($string_offset + $length > strlen($this->file_contents[$array_offset]))
		{
			// we have an invalid string offset.  rats.
			return false;
		}

		if ($pos == 'AFTER')
		{
			$this->file_contents[$array_offset] = substr_replace($this->file_contents[$array_offset], $inline_add, $string_offset + $length, 0);
			$this->last_string_offset += strlen($inline_add) + $length - 1;
		}
		else if ($pos == 'BEFORE')
		{
			$this->file_contents[$array_offset] = substr_replace($this->file_contents[$array_offset], $inline_add, $string_offset, 0);
			$this->last_string_offset += $length;
		}

		$this->curr_action = func_get_args();

		return true;
	}
        function recursive_mkdir($path, $mode = false)
	{


		$dirs = explode('/', $path);
		$count = sizeof($dirs);
		$path = '.';
		for ($i = 0; $i < $count; $i++)
		{
			$path .= '/' . $dirs[$i];

			if (!is_dir($path))
			{
				@mkdir($path, 0666);
				@chmod($path, 0666);

				if (!is_dir($path))
				{
					return false;
				}
			}
		}
		return true;
	}

        function close_file($new_filename)
	{
                global $lang;

		if (!is_dir($new_filename) && !file_exists(dirname($new_filename)))
		{
			if ($this->recursive_mkdir(dirname($new_filename)) === false)
			{
				return sprintf($lang['MODS_MKDIR_FAILED'], dirname($new_filename));
			}
		}

		$file_contents = implode('', $this->file_contents);

		if (file_exists($new_filename) && !is_writable($new_filename))
		{
			return sprintf($lang['WRITE_DIRECT_FAIL'], $new_filename);
		}


		// If we are not looking at a file stored in the database, use local file functions
		$fr = @fopen($new_filename, 'wb');
		$length_written = @fwrite($fr, $file_contents);

		// This appears to be correct even with multibyte encodings.  strlen and
		// fwrite both return the number of bytes written, not the number of chars
		if ($length_written < strlen($file_contents))
		{
			return sprintf($lang['WRITE_DIRECT_TOO_SHORT'], $new_filename);
		}

		if (!@fclose($fr))
		{
			return sprintf($lang['WRITE_DIRECT_FAIL'], $new_filename);
		}

		return true;
	}


}
?>
