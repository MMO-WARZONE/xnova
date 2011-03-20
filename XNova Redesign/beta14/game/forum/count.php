<?php
/*$file = "hitcount.txt";
if (file_exists($file)) {
  $fp = fopen("$file", "r+");
  flock($fp, 1);
  $count = fgets($fp, 4096);
  $count += 1; 
  fseek($fp,0);
  fputs($fp, $count);
  flock($fp, 3);
  fclose($fp);
  echo $count;
} else {
  echo "Cannot open file - '\$file'<BR>";
}
 $hits = file_get_contents("hitcount.txt"); 
 $hits = $hits + 1; 
  
 $handle = fopen("hitcount.txt", "w"); 
 fwrite($handle, $hits); 
 fclose($handle); 

 print $hits; /*
// $fp = fopen("hitcount.txt", "r"); 


$count = fread($fp, 1024); 

fclose($fp); 



$count = $count + 1; 



echo "<p>Page views:" . $count . "</p>"; 


$fp = fopen("hitcount.txt", "w"); 

fwrite($fp, $count); 

fclose($fp);

//$filename = "hitcount.txt";

$file = file($filename);
$file = array_unique($file);
$hits = count($file);
echo $hits;

$fd = fopen ($filename , "r");
$fstring = fread ($fd , filesize ($filename));
fclose($fd);
$fd = fopen ($filename , "w");
$fcounted = $fstring."\n".getenv("REMOTE_ADDR");
$fout= fwrite ($fd , $fcounted );
fclose($fd);
//$filename = "hitcount.txt"; 
$fd = fopen ($filename, "r"); 
$contents = fread ($fd, filesize($filename)); 
fclose ($fd); 
$contents=$contents+1;
echo $contents; 

$fp = fopen ($filename, "w"); 
fwrite ($fp,$contents);
fclose ($fp); 
//$count_my_page = ("hitcounter.txt");
$hits = file($count_my_page);
$hits[0] ++;
$fp = fopen($count_my_page , "w");
fputs($fp , "$hits[0]");
fclose($fp);
echo $hits[0];
*/
?>
