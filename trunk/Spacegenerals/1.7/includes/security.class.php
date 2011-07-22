<?php

class Security
{
	var $global_vars;
	var $ini;
	var $ini_gets;
	var $register_globals;
	var $auto_escaping;
	var $magic_quotes_runtime;
	var $fopen_url;
	var $php_version;
	var $long_arrays;
	var $create_super_globals;
	
	function init()
	{
		$this->ini = true;
		
		$this->get_phpversion(true, true);
		
		if( @ini_get('register_globals') || @ini_get('magic_quotes_runtime') )
		{
			$this->ini_gets = true;
			
			if(	@ini_get('register_globals') == 1 || strtolower(@ini_get('register_globals')) == 'on' )
			{
				$this->register_globals = true;
			}
			else if( @ini_get('register_globals') !== false && ( @ini_get('register_globals') == 0 || strtolower(@ini_get('register_globals')) == 'off' ) )
			{
				$this->register_globals = false;
			}
			else
			{
				$this->register_globals = true;
				/*
					Wir sagen lieber ja wie nein.. da ja sicherer ist wie nein..
				*/
			}
			
			if( @ini_get('magic_quotes_runtime') == 1 || strtolower(@ini_get('magic_quotes')) == 'on' )
			{
				$this->auto_escaping = true;
			}
			else if( @ini_get('magic_quotes_runtime') !== false && ( @ini_get('magic_quotes_runtime') == 0 || strtolower(@ini_get('magic_quotes_runtime')) == 'off' ) )
			{
				$this->auto_escaping = false;
			}
			else
			{
				$this->auto_escaping = true;
				/*
					Wir sagen lieber ja wie nein.. da ja sicherer ist wie nein..
				*/
			}
			
			if( @ini_get('allow_url_fopen') == 1 || strtolower(@ini_get('allow_url_fopen')) == 'on' )
			{
				$this->fopen_url = true;
			}
			else if( @ini_get('allow_url_fopen') !== false && ( @ini_get('allow_url_fopen') == 0 || strtolower(@ini_get('allow_url_fopen')) == 'off' ) )
			{
				$this->fopen_url = false;
			}
			else
			{
				$this->fopen_url = true;
				/*
					Wir sagen lieber ja wie nein.. da ja sicherer ist wie nein..
				*/
			}
			
			if( $this->php_version['major'] == 5 )
			{
				if( @ini_get('register_long_arrays') == 1 || strtolower(@ini_get('register_long_arrays')) == 'on' )
				{
					$this->long_arrays = true;
				}
				else
				{
					$this->long_arrays = false;
				}
			}
			else
			{
				if( $this->php_version['major'] == 3 || ( $this->php_version['major'] == 4 && $this->php_version['minor'] < 1 ) )
				{
					$this->create_super_globals = true;
				}
				else
				{
					$this->create_super_globals = false;
					$this->long_arrays = true;
				}
			}	
		}
		else
		{
			$this->ini_gets = false;
			
			if( isset($HTTP_POST_VARS) || isset($HTTP_GET_VARS) || isset($HTTP_COOKIE_VARS) || isset($HTTP_SERVER_VARS) )
			{
				$this->long_arrays = true;
			}
			else
			{
				$this->long_arrays = false;
			}
			
			if( $this->long_arrays == true && ( !isset($_GET) && !isset($_POST) && !isset($_COOKIE) && !isset($_SERVER) ) )
			{
				$this->create_super_globals = true;
			}
			else
			{
				$this->create_super_globals = false;
			}
		}
		return true;
	}
	
	function get_phpversion( $prepare = false, $write_class_var = false )
	{
		$version = ( @phpversion() ) ? phpversion() : 0;
		
		if( $version == 0 )
		{
			$version = '4.3.10'; // Meist genutzte alte PHP-Version, zur Sicherheit gehen wir von der aus, falls keine definiert - warum auch immer!
		}
		
		$version = ( strstr($version, '-') ) ? substr($version, 0, strpos($version, '-')) : $version;
		
		if( $prepare == true )
		{
			$exploded = explode(".", $version);
			
			$version = array();
			
			$version['major'] = $exploded[0];
			$version['minor'] = $exploded[1];
			$version['patch'] = $exploded[2];
		}
		
		if( $write_class_var == true )
		{
			$this->php_version = $version;
		}
		
		return $version;
	}
	
	function disable_magic_quotes()
	{
		if( $this->auto_escaping == true )
		{
			if( @set_magic_quotes_runtime(0) )
			{
				$this->magic_quotes_runtime = false;
			}
			else if( @ini_set('magic_quotes_runtime', 0) )
			{
				$this->magic_quotes_runtime = false;
			}
			else
			{
				$this->magic_quotes_runtime = true;
			}
		}
		else
		{
			$this->magic_quotes_runtime = false;
		}
	}
	
	function escaping_vars()
	{
		if( $this->magic_quotes_runtime == true )
		{
			foreach($_POST as $k => $v)
			{
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						$_POST[$k][$k2] = stripslashes($v2);
					}
				}
				else
				{
					$_POST[$k] = stripslashes($v);
				}
			}
			
			foreach($_GET as $k => $v)
			{
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						$_GET[$k][$k2] = stripslashes($v2);
					}
				}
				else
				{
					$_GET[$k] = stripslashes($v);
				}
			}		
			
			foreach($_COOKIE as $k => $v)
			{
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						$_COOKIE[$k][$k2] = stripslashes($v2);
					}
				}
				else
				{
					$_COOKIE[$k] = stripslashes($v);
				}
			}				
			
			foreach($_SERVER as $k => $v)
			{
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						$_SERVER[$k][$k2] = stripslashes($v2);
					}
				}
				else
				{
					$_SERVER[$k] = stripslashes($v);
				}
			}
			
			foreach($_FILES as $k => $v)
			{
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						$_FILES[$k][$k2] = stripslashes($v2);
					}
				}
				else
				{
					$_FILES[$k] = stripslashes($v);
				}
			}
		}
		
		/* 
			Und nun beginnen wir mit dem escaping.. und ja wir addslashen jetzt fleißig (ausser $_FILES).
			Das sieht zwar unlogisch weil wir ja ein Block darüber stripslashen.. 
			Aber das hat schon seinen Sinn ;) Und stellt euch vor was hier addslashen
			wird woanders wieder gestripslashed :D
		*/	
		
		foreach($_POST as $k => $v)
		{
			if( is_array($v) )
			{
				foreach( $v as $k2 => $v2 )
				{
					if( is_array($v2) )
					{
						die("Hacking attempt! Unallowed subarrays of globals");
					}
					$_POST[$k][$k2] = addslashes($v2);
				}
			}
			else
			{
				$_POST[$k] = addslashes($v);
			}
		}
		
		foreach($_GET as $k => $v)
		{
			if( is_array($v) )
			{
				foreach( $v as $k2 => $v2 )
				{
					if( is_array($v2) )
					{
						die("Hacking attempt! Unallowed subarrays of globals");
					}
					$_GET[$k][$k2] = addslashes($v2);
				}
			}
			else
			{
				$_GET[$k] = addslashes($v);
			}
		}		
		
		foreach($_COOKIE as $k => $v)
		{
			if( is_array($v) )
			{
				foreach( $v as $k2 => $v2 )
				{
					if( is_array($v2) )
					{
						die("Hacking attempt! Unallowed subarrays of globals");
					}
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
			}
			else
			{
				$_COOKIE[$k] = addslashes($v);
			}
		}				
		
		foreach($_SERVER as $k => $v)
		{
			if( is_array($v) )
			{
				foreach( $v as $k2 => $v2 )
				{
					if( is_array($v2) )
					{
						die("Hacking attempt! Unallowed subarrays of globals");
					}
					$_SERVER[$k][$k2] = addslashes($v2);
				}
			}
			else
			{
				$_SERVER[$k] = addslashes($v);
			}
		}
		
		return true;
	}
	
	function unset_globals()
	{
		if( $this->register_globals == true )
		{
			$master_array = array_merge($_POST, $_GET, $_COOKIE, $_SERVER, $_FILES);
			
			foreach( $master_array as $k => $v )
			{
	
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						
						global $$k[$$k2];
						
						unset($$k[$$k2]);
					}
				}
				else
				{
					global $$k;
					
					unset($$k);
				}
			}
			
			return true;
		}
		else
		{
			return true;
		}
	}
	
	function create_super_global()
	{
		if( $this->create_super_globals == true )
		{
			global $_POST, $_GET, $_COOKIE, $_FILES, $_SERVER, $_REQUEST;
			
			$_POST = $HTTP_POST_VARS;
			$_GET = $HTTP_GET_VARS;
			$_COOKIE = $HTTP_COOKIE_VARS;
			$_FILES = ( isset($HTTP_POST_FILES) ) ? $HTTP_POST_FILES : $HTTP_FILES_VARS;
			$_SERVER = $HTTP_SERVER_VARS;
			$_REQUEST = array_merge($_POST, $_GET, $_COOKIE);
			
			return true;
		}
		else
		{
			return true;
		}
	}
	
	function injections()
	{
		$scanner = array_merge($_POST, $_GET, $_COOKIE);
		
		$detect = array(
			'SELECT ',
			'INSERT INTO',
			'DROP ',
			'DELETE FROM',
			'SELECT FROM',
			'/*',
			'UNION '
		);
		
		foreach( $scanner as $k => $v )
		{
			if( is_array($v) )
			{
				foreach( $v as $k2 => $v2 )
				{
					if( is_array($v2) )
					{
						die("Hacking attempt! Unallowed subarrays of globals");
					}
					foreach( $detect as $s => $f )
					{
						if( stristr($v2, $f) )
						{
							die("Hacking attempt! - SQL Injection");
						}
					}
				}
			}
			else
			{
				foreach( $detect as $s => $f )
				{
					if( stristr($v, $f) )
					{
						die("Hacking attempt - SQL Injection");
					}
				}
			}
		}
		
		$uri = $_SERVER['REQUEST_URI'];
		
		foreach( $detect as $s => $f )
		{
			if( stristr($uri, $f) )
			{
				die("Hacking attempt - SQL Injection");
			}
		}
	}
	
	function remote_code()
	{
		if( $this->fopen_url == true )
		{
			$detect = array(
				'http://',
				'ftp://',
				'data://',
				'php://',
				'www.',
				'www2.',
				'./../',
				'../'
			);
			
			foreach( $_GET as $k => $v )
			{
				if( is_array($v) )
				{
					foreach( $v as $k2 => $v2 )
					{
						if( is_array($v2) )
						{	
							die("Hacking attempt! Unallowed subarrays of globals");
						}
						
						foreach( $detect as $s => $f )
						{
							if( stristr($v2, $f) )
							{
								die("Hacking attempt - Remote Code");
							}
						}
					}
				}
				else
				{
					foreach( $detect as $s => $f )
					{
						if( stristr($v, $f) )
						{
							die("Hacking attempt! - Remote Code");
						}
					}
				}
			}
			
			$uri = $_SERVER['REQUEST_URI'];
			
			foreach( $detect as $s => $f )
			{
				if( stristr($uri, $f) )
				{
					die("Hacking attempt - Remote Code");
				}
			}			
			
			$clear_fields = array(
				'text',
				'web',
				'image',
				'avatar'
			);
			
			if( !defined("IN_ADMIN") )
			{
				foreach( $_POST as $k => $v )
				{
					if( !in_array($v, $clear_fields) )
					{
						if( is_array($v) )
						{
							foreach( $v as $k2 => $v2 )
							{
								if( is_array($v2) )
								{	
									die("Hacking attempt! Unallowed subarrays of globals");
								}
								
								foreach( $detect as $s => $f )
								{
									if( stristr($v2, $f) )
									{
										die("Hacking attempt - Remote Code");
									}
								}
							}
						}
						else
						{
							foreach( $detect as $s => $f )
							{
								if( stristr($v, $f) )
								{
									die("Hacking attempt! - Remote Code");
								}
							}
						}
					}
				}
			}			
			return true;
		}
		else
		{
			return true;
		}
	}
	
	function prepare_sql($sql)
	{
		global $db;
		
		$sql = str_replace('\\\'', "<ohhochkomma>", $sql);
		preg_match_all("/'([^']+)'/s", $sql, $results);
		$results = $results[1];
		foreach( $results as $id => $value )
		{
			$sql = str_replace($value, $db->sql_escape(stripslashes($value)), $sql);
		}
		$sql = str_replace("<ohhochkomma>", '\\\'', $sql);
		
		return $sql;	
	}
	
	function start()
	{
		$this->init();
		$this->create_super_global();
		$this->disable_magic_quotes();
		$this->escaping_vars();
		$this->unset_globals();
		$this->injections();
		$this->remote_code();
		
		return true;
	}
}

?>