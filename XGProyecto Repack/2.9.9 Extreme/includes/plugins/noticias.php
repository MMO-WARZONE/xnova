<?php
//PLUGIN PARA XGPROYECT

#@Name: Noticias
#@Author: Think at waterspace.es
#@Thanks: Adri93 por el plugin system.
#@Compatibilidad: 2.9.X

define('TIMESTAMP',time());
    
$name = "Noticias";
$config_line .= AdmPlugin($name, "");
    
if(PluginAct($name))
{
    $noticias = new noticias($lang);
}
    
class noticias
{
    public function __construct(&$lang)
    {
        global $game_config;
        if(!isset($game_config['news']))
            $news = $this->runInstall();
        else
            $news = $game_config['news'];
        
        if(defined('IN_ADMIN'))
        {
            if(isset($_POST['config_news']) AND $_POST['config_news'] != "" AND $_POST['config_news'] != $news)
                $this->updateNews();
                
            $this->setAdmLang($news,$lang);
        }
        else
            $this->insertNews($news,$lang);
    }
    
    private function updateNews()
    {
        doquery("UPDATE {{table}} SET `config_value` = '".mysql_real_escape_string($_POST['config_news'])."' WHERE `config_name` = 'news'","config");
    }
    
    private function setAdmLang($news,&$lang)
    {
        $lang['se_server_status_message'] = "Noticias</th><th><textarea name=\"config_news\" cols=\"80\" rows=\"5\" size=\"80\" >$news</textarea></th></tr><tr><th>".$lang['se_server_status_message'];
    }
    
    private function insertNews($news,&$lang)
    {
        $lang['ov_server_time'] = "<font color=green>Noticias</font></th>
            <th colspan=\"3\"><div align=center>$news</div></th></tr><tr>
            <th>".$lang['ov_server_time'];
    }
    
    private function runInstall()
    {
        doquery("INSERT INTO {{table}} SET `config_name` = 'news', `config_value` = 'Plugin noticias instalado correctamente'","config");
        return 'Plugin noticias instalado correctamente';
    }
} 
