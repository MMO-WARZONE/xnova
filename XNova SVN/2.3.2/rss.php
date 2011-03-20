<?php
//version 2.3
define('INSIDE'  , true);
include('includes/functions/classes/MySqlDatabase.php');
$db_rss = new MySqlDatabase();
header('Content-type: text/xml; charset="utf-8"');
$rss_titulo = $db_rss->game_config["game_name"];
$rss_url =dirname("http://". $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'])."/";
$rss_descripcion = "Noticias de {$db_rss->game_config["game_name"]}";
$rss_email =$db_rss->game_config["user_mail"]."@".$db_rss->game_config["smtp_mail"];
// Escribimos el archivo RSS
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
echo "<rss version=\"0.92\">
      <channel>
          <docs>{$rss_url}rss.php</docs>
          <title>$rss_titulo</title>
          <link>$rss_url</link>
          <description>$rss_descripcion</description>
          <language>es</language>
          <managingEditor>$rss_email</managingEditor>
          <webMaster>$rss_email</webMaster>
          <copyright>Copyright 2009 - 2010 Xnova-Svn</copyright>
          <generator>Xnova Svn RSS</generator>\n";

$rss_query=$db_rss->query("SELECT * FROM `{{table}}` ORDER BY `news_id` DESC LIMIT 0 , 10", 'news');
    while ($rss=mysql_fetch_array($rss_query))
    {
        echo "<item>\n" ;
        echo "<title><![CDATA[".$rss["news_titulo"]."]]></title>\n";
        echo "<link><![CDATA[".$rss_url."game.php?page=news&idnew=".$rss["news_id"]."]]></link>\n";
        echo "<description><![CDATA[".$rss["news_news"]."]]></description>\n";
        echo "<pubDate>".date("d-m-y H:i:s",$rss["news_date"])."</pubDate>\n";
        echo "</item>\n";
    }
echo "</channel>";
echo "</rss>";
?>