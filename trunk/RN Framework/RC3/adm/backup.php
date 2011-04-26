<?php
/**
 * backup.php
 *
 * @version 1.0
 * @copyright 2008 by jtsamper for XNova
 */


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

/* Nombre del fichero que se descargará. */

include($xgp_root . 'config.' . $phpEx);

if ($user['authlevel'] != 3) die(message ($lang['not_enough_permissions']));

if($_POST){
$nombre = "Backup_". date("d.m.y-h:i:s",time()) .".sql";
/* Determina si la tabla será vaciada (si existe) cuando  restauremos la tabla. */
$drop = false;

$tablas = false;

//LEE EL ARCHIVO SUBIDO Y LO EJECUTA
$nombre_archivo = $_FILES['file']['tmp_name'];
$gestor = @fopen($nombre_archivo, "r");
$contenido = @fread($gestor, @filesize($nombre_archivo));
$arr =  explode(";\n", preg_replace('/[\r\n]+/', ";\n", $contenido));
@fclose($gestor);
$num=count ($arr);
if($nombre_archivo){
for($i=0;$i<=$num;$i++){
mysql_query ($arr[$i]);
}
}

//FIN
/*
* Tipo de compresion.
* Puede ser "gz", "bz2", o false (sin comprimir)
*/
$compresion = $_POST["compre"];
/* Se busca las tablas en la base de datos */
if ( empty($tablas) ) {
    $consulta = "SHOW TABLES FROM {{table}};";
    $respuesta = doquery($consulta , $dbsettings["name"] , '' , true )
    or die("No se pudo ejecutar la consulta: ".mysql_error());
$prueba2=array ();
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {


      array_push($prueba2,$fila[0]);

    }
   $n1=count($prueba2);

   foreach ($prueba2 as $value) {
    $game=explode("_",$value);

   if(($game[0]."_")==$dbsettings["prefix"]){
   $tablas[]=$value;

   }
   }



}

ini_set("memory_limit","120M");

/* Se crea la cabecera del archivo */
$info['fecha'] = date("d.m.Y");
$info['hora'] = date("h:m:s");
$info['mysqlver'] = mysql_get_server_info();
$info['phpver'] = phpversion();
ob_start();
print_r($tablas);
$representacion = ob_get_contents();
ob_end_clean ();
preg_match_all('/(\[\d+\] => .*)\n/', $representacion, $matches);
$info['tablas'] = implode(";  ", $matches[1]);
$dump = "
-- +===========================================================================
-- |
-- | Generado el {$info['fecha']} a las {$info['hora']} por el usurio '$usurio'
-- | Server: {$_SERVER['HTTP_HOST']}
-- | MySQL Version: {$info['mysqlver']}
-- | PHP Version: {$info['phpver']}
-- | Datenbank: '$bd'
-- | Tabellen: {$info['tablas']}
-- |
-- +===========================================================================


SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


";
foreach ($tablas as $tabla) {
    $create_table_query = "";
    $insert_into_query = "";

    /* Se halla el doquery que será capaz de recrear la estructura de la tabla. */
    $create_table_query = "";
    $consulta = "SHOW CREATE TABLE {{table}} ;";
    $respuesta = doquery($consulta, $tabla , '' , true)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
   if($_POST['tabla']=='si'){
    while ($fila = mysql_fetch_array($respuesta , MYSQL_NUM)) {
           $create_table_query =
'
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `'.$tabla.'`
--

DROP TABLE IF EXISTS `'.$tabla.'`;
';
         $create_table_query .= $fila[1].";";
    }
    }

    /* Se halla el query que será capaz de insertar los datos. */
    $insert_into_query = "";
    $consulta = "SELECT * FROM {{table}};";
    $respuesta = doquery($consulta, $tabla , '' , true )
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_ASSOC)) {
            $columnas = array_keys($fila);
            foreach ($columnas as $columna) {
                if ( gettype($fila[$columna]) == "NULL" ) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'".mysql_real_escape_string($fila[$columna])."'";
                }
            }
            $insert_into_query .= "INSERT INTO `$tabla` VALUES (".implode(", ", $values).");\n";
            unset($values);
    }

$dump .= "
$create_table_query

--
-- Datenbank: `".$tabla."`
--

$insert_into_query

";
}

/* Envio */
if ( !headers_sent() ) {
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-Transfer-Encoding: binary");
    switch ($compresion) {
    case "gz":
        header("Content-Disposition: attachment; filename=$nombre.gz");
        header("Content-type: application/x-gzip");
        echo gzencode($dump, 9);
      exit();
        break;
    case "bz2":
        header("Content-Disposition: attachment; filename=$nombre.bz2");
        header("Content-type: application/x-bzip2");
        echo bzcompress($dump, 9);
      exit();
        break;
    case "norm":
        header("Content-Disposition: attachment; filename=$nombre");
        header("Content-type: application/force-download");
        echo $dump;
      exit();
      break;
    }
} else {
    echo "<b>ATENCION: Probablemente ha ocurrido un error</b><br />\n<pre>\n$dump\n</pre>";
}
}
      display(parsetemplate(gettemplate('adm/backup'), $parse), false, '', true, false);
//Version de 1.0
ini_restore("memory_limit");
?>