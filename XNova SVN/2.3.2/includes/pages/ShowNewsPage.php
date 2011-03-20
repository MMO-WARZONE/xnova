<?php
//version 1
function ShowNewsPage(){
    global $displays,$db,$lang;
        $displays->assignContent("new");
	 //Mostrar News
	
        // Show all news*
    	$results = $db->query("SELECT * FROM `{{table}}` ORDER BY `news_id` DESC", 'news');
        $ult_new=0;
        $i=0;
	while ($idnews=mysql_fetch_array($results))
	{
            if($i==0){
                $ult_new=$idnews["news_id"];
            }
            $displays->newBlock("list_noticias");
            $displays->assign("id_news",$idnews["news_id"]);
            $displays->assign("news_titulo",$idnews["news_titulo"]);
            $displays->assign("news_date",date("d-m-y H:i:s",$idnews["news_date"]));
            $i++;
	}

        $displays->gotoblock("_ROOT");
        $idnews=!isset($_GET['idnews'])?$ult_new:$_GET['idnews'];

        if (is_numeric($idnews)){
                $Show = $db->query("SELECT * FROM `{{table}}` WHERE `news_id` = '". $idnews ."'", 'news',true);
		$displays->assign("news_titulo",$Show["news_titulo"]);
                $displays->assign("news_news",$Show["news_news"]);
	}

$displays->display();
}
?>