<?php
//version 1.1

class Update_version{

    var $error;
    var $archivo_update="./includes/version.php";
    var $time_update="604800"; //Tiempo entre cada actualiaciones 60*60*24*7dias
    var $pages=array("./","includes/","includes/pages/","includes/pages/admin/","includes/functions/","includes/functions/classes/");
    var $archivo_origen="http://xnova-svn.org/version2.php";
    var $version=array();
    var $errors=0;
    /*
     * Esta funcion comprueba cuando fue modificado por ultima vez el archivo
     * $archivo_update
     */
    function check_ult_modificacion(){
        $time_ult_update=filemtime($this->archivo_update);
        $time=time()-$time_ult_update;
        if($time>$this->time_update){
            $this->mensajeversion.="La última modificación de $this->archivo_update fue: " .date ("d/m/Y H:i:s.", $time_ult_update)." necesita comprobarse de nuevo<br>";
            $this->mensajeversion.="El archivo '$this->archivo_update' va a ser actualizado";
            $this->update_archivo_version();
        }else{
            if($_GET[check_version]==1){
                $this->update_archivo_version();
            }
        }

    }
    /*
     * Esta funcion modifica el archivo $archivo_update con las versiones de tu codigo
     *
     *
     *
     */
    function update_archivo_version(){

        foreach($this->pages as $var){
            $gd =opendir($var);
            if ($gd) {
                while(($archivo = readdir($gd)) !== false) {
                    $partes_ruta = pathinfo($archivo);
                    if($archivo != "." && $archivo != ".." && $archivo !=".htaccess" && !is_dir($var."/".$archivo) && $partes_ruta['extension']=="php"){
                       $array[$var][] = "{$archivo}";
                    }
                    unset($partes_ruta);
                }
                closedir($gd);
            }
        }
        $file_guardar=fopen($this->archivo_update, 'w+');
        fwrite($file_guardar,"<?php\n");
        foreach($array as $dir => $files_dir){
            foreach($files_dir as $files ){
                $archivo = file($dir.$files);
                foreach ($archivo as $num_línea => $linea) {
                    if(preg_match("/\/\/\bversion\b/i", htmlspecialchars($linea))){
                        $linea_archivo=preg_replace('/\//', '', htmlspecialchars($linea));
                        $lineas=explode(" ",$linea_archivo);
                        $archivos[$dir][$files]=$lineas[1];
                        fwrite($file_guardar,'$archivos["'.$dir.'"]["'.$files.'"]="'.trim($lineas[1]).'";');
                        fwrite($file_guardar,"\n");
                        unset($archivo);
                        break;
                    }
                }
            }
            unset($array[$dir]);
        }
        fwrite($file_guardar,"?>");
        fclose($file_guardar);


    }



    /*
     * Esta funcion lee el archivo que contiene las ultimas actualizaciones de los archivos
     *
     *
     *
     */
    function check_version_url(){
        global $lang;
        //$prueba=@file_get_contents("http://xnova-svn.org/version2.php");
        $prueba=@file_get_contents($this->archivo_origen);

        if($prueba){
            $prueba1 = explode(";;",$prueba);
            $numvar=count($prueba1);
            $valoresvariable=array("game",".","includes","includes/pages","includes/pages/admin","includes/functions","includes/functions/classes");

                $i=0;
                foreach($prueba1 as $a ){
                    if($a!=''){
                        $prueba2 = explode("==>",$a);
                        $key=array_search(trim($prueba2[0]), $valoresvariable);
                        $prueba3[$valoresvariable[$key]]=$prueba2[1];
                        $i++;
                    }
                }

                $cd=0;
                foreach($prueba3 as $key => $b ){
                    $valor[$cd]=explode(";",$b);
                    $valores[$key]=$valor[$cd];
                    $cd++;
                }

                for($a=0;$a<count($valoresvariable);$a++){
                    if(is_array($valores[$valoresvariable[$a]])){
                        foreach($valores[$valoresvariable[$a]] as $b ){
                            $version1[$cd]=explode(",",$b);
                            $this->version[$valoresvariable[$a]."/"][trim($version1[$cd][0])]=$version1[$cd][1];
                            $cd++;
                        }
                    }
                }

            }else{
                $this->errors++;
                $versionerror=$lang['cv_error_file'];
            }
    }
     /*
     * Esta funcion comprueba las versiones de los archivos
     *
     *
     *
     */
    function check_version(){
        global $users,$lang;

        include($this->archivo_update);
        $this->check_version_url();
        $versionerror="<br>".$lang['cv_update']."<br> \n";
        $versionerror.="<form method='post' action='http://xnova-svn.org/descargas/descarga.php'>\n";
        $versionerror.="<input name='web' type='hidden' value='{$_SERVER['HTTP_HOST']}'>
            <input name='user' type='hidden' value='{$users->user["username"]}'>
            <input name='email' type='hidden' value='{$users->user["email"]}'><br>";
        foreach($archivos as $a => $b){
            foreach($b as $c => $d){
                if($a!="creditos"){
                    if($archivos[$a][$c]<$this->version[$a][$c]){
                        $versionerror.=$a.$c." de ".$d." a ".$this->version[$a][$c]."<br>\n";
                        if($c=="version"){
                            $versionerrorpage.=$c.",".$this->version[$a][$c].";";
                        }else{
                            $versionerrorpage.=$c.";";
                        }
                        $this->errors++;
                    }
                }else{
                    if($c=="proyect_leader"){
                        if($archivos["creditos"][$c]!=$this->version["game"][$c]){
                           $this->versioncreditos=$lang['cv_credit'];
                           $this->errors++;
                        }
                    }
                }
            }
        }
        $versionerror.="<input type='hidden' name='archivos' value='{$versionerrorpage}'>";
        $versionerror.="<br><input type='submit'></form>";
        if($versionerrorpage!=''){
            $this->mensajeversion.=$versionerror;
        }
        
    }

}



?>