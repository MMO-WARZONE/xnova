<BR /><BR />
        <style type="text/css" media="screen">    @import "login/css/css.css"; </style>
        <style type="text/css" media="screen">    @import "login/css/externalHome.css"; </style>
        <script src="login/images/function.js" type="text/javascript"></script>
        
        <script type="text/javascript" src="login/images/prototype.js"></script>
        <script type="text/javascript" src="login/images/scriptaculous.js"></script><script type="text/javascript" src="login/images/builder.js"></script><script type="text/javascript" src="login/images/effects.js"></script><script type="text/javascript" src="login/images/dragdrop.js"></script><script type="text/javascript" src="login/images/controls.js"></script><script type="text/javascript" src="login/images/slider.js"></script><script type="text/javascript" src="login/images/sound.js"></script>


       
    </head><body>

<!-- Footer -->
<div id="footerfirst">
    <div id="footer_text" class="fliessfooter">
                <div id="footer" class="fliessfooter">
            <div class="footer_left"></div>
            
            <div class="footer_right">
                                              
                                              </div>
            <br class="clearMe">
        </div>
    </div>
</div>
<!-- Footer --> 




<div id="main">
<!--
<div style="position: absolute; left: 318px; top: 188px;"><img src="login/images/bg_star_anim_01.gif" height="13" width="13"></div>
<div style="position: absolute; left: 529px; top: 178px;"><img src="login/images/bg_star_anim_02.gif" height="13" width="13"></div>
<div style="position: absolute; left: 494px; top: 500px;"><img src="login/images/bg_star_anim_03.gif" height="13" width="13"></div>
<div style="position: absolute; left: 362px; top: 262px;"><img src="login/images/bg_star_anim_04.gif" height="13" width="13"></div>
<div style="position: absolute; left: 396px; top: 334px;"><img src="login/images/bg_star_anim_05.gif" height="13" width="13"></div>
--!>
    
    
    <!-- Partner -->
    <div id="partner"></div>
    <!-- Partner -->
    
    <!-- Info-Bar -->
    <div id="infobar">
        <div id="online" style="margin-left:80px;margin-top:-23px" class="fliesstext1">{log_online}: {online_users}</div>
        <div id="register" style="margin-left:200px;margin-top:-23px" class="fliesstext1">{log_numbreg}: {users_amount}</div>
        <br class="clearMe">
    </div>
    <!-- Info-Bar -->

    <!-- Left -->
    <div id="left">

        
       <form name="formular" action="" method="post" onSubmit="changeAction('login');" style="margin-top: -9px; margin-left: 70px;"> <input name="timestamp" value="1173621187" type="hidden">
        <div id="div_login" class="fliesstext">
            
            <div id="login">LOGIN</div>
            <div id="pw_forgotten" align="center"><a href="lostpassword.php">{PasswordLost}</a></div>
            
            
            
            <br class="clearMe">
            
            
            <label for="username" id="label_user"><input name="v" value="2" type="hidden">{User_name}</label>
            <input name="username" value="" type="text" class="text" value="" maxlength="20">
            <br class="clearMe">
            <label for="password" id="label_password">{Password}</label>
            <input name="password" value="" type="password" class="text" value="" maxlength="30">
            <br class="clearMe">
            <div id="loginbar">
                <div id="but_register" class="fliesstext"><a href="reg.php" onFocus="this.blur()" onMouseOver="changePic('but_register','do_login/images/reg.gif')" onMouseOut="changePic('but_register','do_login/images/reg1.gif)" style="display: block;"><img style="opacity:0%" src="login/images/reg.gif"></a></div>
                <input id="but_login" name="submit" value="" class="fliesstext" onMouseOver="changePic('but_login','do_img/global/intro/but_log_1.png'); this.style.color='#FFFFFF';" onMouseOut="changePic('but_login','do_img/global/intro/but_log_0.png');this.style.color='#afc9d3';" type="submit">
            </div>
            
            
            <div id="langbar">
                <div id="but_lang">
                   
                </div>
                <div id="choose_lang" style="display: none;" onMouseOut="hideLang();">

                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- Left -->
    
    <!-- Right -->
    <div id="right">
    
        <div id="teaser_nav_top" class="fliesstext">
            

            <br class="clearMe">
        </div>
        <div id="box">

            <div id="div_ingame" style="visibility: hidden;">

            </div>

            <div id="div_infos" style="visibility: visible;">
                <div id="infos" class="fliess10px-white"><strong>Welcome to {servername}!</strong><br><br /><strong>{servername}</strong> {log_desc} <br><br>/Admin@{servername}.</div>
            </div>

         </div>
        <div id="box2">

            <div id="div_ingame" style="visibility: hidden;">

            </div>

            <div id="div_infos" style="visibility: visible;">
                <div id="infos" class="fliess10px-white"><strong>NEWS!</strong><br><br /> {log_news}<a href="topkb.php" target="_new"><font color=lime><b>{Hfamelink}</b></font></a> <br><br>/Admin@{servername}.</div>
            </div>

         </div>
        <div id="box3">

            <div id="div_ingame" style="visibility: hidden;">

            </div>

            <div id="div_infos2" style="visibility: visible;">
                <div id="infos2" class="fliess10px-white"><strong>3!</strong><br><br /> screens </div>
            </div>

         </div>


        <div id="teaser_nav_bottom" class="fliesstext">

            <br class="clearMe">
        </div>
       
    </div>
    <!-- Right -->
	
    <br class="clearMe">
</div>

<br class="clearMe">






</body></html>
