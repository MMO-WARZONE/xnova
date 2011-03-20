<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** index.php                             **
******************************************/

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>

<title>Space Conflict</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main">
    <!--header -->
    <div id="header">
   	  <div class="col"></div>
        <div class="clear"></div>
        <div class="logo">
      </div>
    <!--header end-->
    <!--content -->
    <div class="content">
        <div class="indent">

            <div class="w100">
              <p>&nbsp;</p>
              <div class="side_bar">
    <div class="bg_side_bar">
        <div class="bg_side_bar1">
            <div class="indent">
            	<div id="statusbar"></div>
                   <div class="widget_style" id="categories">
<div>
                        <h2>Login Area</h2>
                        <ul>
<center>	<form name="formular" action="login.php" method="post">
    <input type="hidden" name="v" value="2">
    <script type="text/javascript"> document.formular.Uni.focus(); </script>
	Username :<input name="username" style="width: 180px" type="text" value="" class="eingabe" /></li>
	Password :<input name="password" style="width: 180px" type="password" value="" class="eingabe" /></li> 
  	<input name="submit" type="image" style="width: 62px" value="Login" src="images/login.gif" />
	</form>
<br>
  <a href="?page=register"><font size=3>Join Now!</font></a><br>
</center>
                        </ul>
                    </div>
                </div>

<div class="widget_style" id="categories">
                    <div>
                        <h2>Important Things</h2>

                      <ul>
	<li class="cat-item cat-item-3"><a href="index.php">News</a></li>
              <li class="cat-item cat-item-2"><a href="lostpassword.php">Forgot Password?</a></li>
	<li class="cat-item cat-item-7"><a href="http://spaceconflict.board-directory.com">Forum</a></li>
	</ul>
                  </div>
                </div>
                   <div class="widget_style" id="categories">
<div>
                        <h2>Space Conflict Team</h2>
                        <ul>
                              <ul>
                                <li>WELLST - Admin</li>
                              </ul>
                        </ul>
                    </div>
                </div>
                   <div class="widget_style" id="categories">
<div>
                        <h2>Known bugs:</h2>
                        <ul>
                           <li>Negative resources</li>
                           <li>Espionage probe count</li>
                        </ul>
                    </div>
                </div>
              </div>
        </div>
    </div>
</div><div class="column_center">                        <!--end navigation-->
<?

	$page=$_GET['page'];
	$default_page="news";
	if (is_null($page)) {
		$page="news.shtml";
	} else {
		$page="$page.php";
	}

	if (file_exists("$page")) {
		include("$page");
	} else {
		include("404.html");
	}

?>
</div>
   <div class="clear"></div>
            </div>
        </div>
    </div>
    <!--content end-->

    <!--footer -->
    <div id="footer">
        <span>OasisRage 2.0 by darkOasis</span><br />
    </div>
    <!--footer end-->	
</div>		
</body>
</html>