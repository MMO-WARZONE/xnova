<?php
//version 1
function ShowNewsAdmin($user){
    global $displays,$db,$lang;

if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));
    $displays->assignContent("adm/new");
	// Add / Edit news
	if ($_POST['tipo'] == "Anadir")
	{
		$news = $_POST['news'];
                $titulo = $_POST['titulo'];
		$db->query ("INSERT `{{table}}` SET `news_news` = '". $news ."',`news_date` = '". time() ."',`news_titulo` = '". $titulo ."'", 'news');

		$actionnews = "";
	}elseif ($_POST['tipo'] == "Modificar")
	{
		$news = $_POST['news'];
		$idnews = $_POST['id_news'];
		$db->query ("UPDATE `{{table}}` SET `news_news` = '". $news ."' WHERE `news_id` = '". $idnews ."'", 'news');
		$actionnews = "";
	}
        if ($_GET['actionnews'] == "borrar")
	{
		$idnews = $_GET['idnews'];
		$db->query("DELETE FROM `{{table}}` WHERE `news_id` = '". $idnews ."'", 'news');
	}elseif ($_GET['actionnews'] == "editar")
	{
		$idnews =$_GET['idnews'];
		// Show selected news
		$Show = $db->query("SELECT * FROM `{{table}}` WHERE `news_id` = '". $idnews ."'", 'news',true);
		$displays->assign("id_news_edit",$Show["news_id"]);
                $displays->assign("news_news_edit",$Show["news_news"]);
	}
        // Show all news
    	$results = $db->query("SELECT * FROM `{{table}}` ORDER BY `news_id` DESC", 'news');
	while ($idnews=mysql_fetch_array($results))
	{
            $displays->newBlock("list_noticias");
            $displays->assign("id_news",$idnews["news_id"]);
            $displays->assign("news_titulo",$idnews["news_titulo"]);
            $displays->assign("news_date",date("d-m-y H:i:s",$idnews["news_date"]));


	}    

$displays->display();
}
?>