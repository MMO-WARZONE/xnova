
<!--

/**
  * anmelden.tpl
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

-->

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>{servername}</title>

<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="styl/css/login/styles.css">

<script type="text/javascript" src="scripts/overlib.js" ></script>
<script type="text/javascript" src="./scripts/jquery.js" ></script>
<script type="text/javascript" src="./scripts/animatedcollapse.js" ></script>

<style type="text/css">
body{ color:white;font-family:verdana; font-size:12px;}

#progressBar {
        position:relative;
        width:200px;
        height:15px;
        border-style:solid;
        border-width:1px;
        border-color:darkred;
        padding:0px;
}

#progressIndicator {
        position:absolute;
        top:0px;
        left:0px;
        background-color:red;
        width:1px;
        height:15px;
        font-size:1px;
}

#progressText {
        position:absolute;
        top:0px;
        left:0px;
        border-style:none;
        width:200px;
        height:15px;
        text-align:center;
        color:white;
        font-family:verdana;
        font-size:9px;
}

#mContainer {
        position:relative;
        height:30px;
}

.mImg {
        visibility:hidden;
        border-style:solid;
        border-width:1px;
        display:none;
}

PRE {
        background-color:#CCCCCC;
        border-color:#C0C0C0;
        border-style:solid;
        border-width:1px;
        font-family:verdana;
        font-size:9px;
        padding:10px;
}
</style>


<script type="text/javascript">

if (navigator.userAgent.indexOf("Opera") != -1) {
    setTimeout("self.location.href='game.php?page=Space-Beginners'",1500);
}
var imageArray = new Array("design/xnova/balken/menu_01.png","design/xnova/balken/menu_02.png","design/xnova/balken/menu_03.png","design/xnova/balken/menu_04.png","design/xnova/balken/menu_05.png","design/xnova/balken/menu_06.png","design/xnova/balken/menu_07.png","design/xnova/balken/menu_08.png","design/xnova/balken/menu_09.png","design/xnova/balken/menu_10.png","design/xnova/balken/menu_11.png","design/xnova/balken/menu_12.png","design/xnova/balken/menu_13.png","design/xnova/balken/menu_14.png","design/xnova/balken/menu_50.png","design/xnova/balken/menu_51.png","design/xnova/balken/menu_52.png","design/xnova/balken/menu_53.png","design/xnova/balken/menu_54.png","design/xnova/balken/menu_55.png","design/xnova/balken/menu_56.png","design/xnova/balken/menu_57.png",
                           "design/xnova/gebaeude/1.gif","design/xnova/gebaeude/2.gif","design/xnova/gebaeude/3.gif","design/xnova/gebaeude/4.gif","design/xnova/gebaeude/11.gif","design/xnova/gebaeude/12.gif","design/xnova/gebaeude/14.gif","design/xnova/gebaeude/15.gif","design/xnova/gebaeude/21.gif","design/xnova/gebaeude/23.gif","design/xnova/gebaeude/24.gif","design/xnova/gebaeude/25.gif","design/xnova/gebaeude/26.gif","design/xnova/gebaeude/27.gif","design/xnova/gebaeude/31.gif","design/xnova/gebaeude/33.gif","design/xnova/gebaeude/34.gif","design/xnova/gebaeude/41.gif","design/xnova/gebaeude/42.gif","design/xnova/gebaeude/43.gif","design/xnova/gebaeude/44.gif","design/xnova/gebaeude/45.gif","design/xnova/gebaeude/46.gif",
                           "design/xnova/gebaeude/106.gif","design/xnova/gebaeude/107.gif","design/xnova/gebaeude/108.gif","design/xnova/gebaeude/109.gif","design/xnova/gebaeude/110.gif","design/xnova/gebaeude/111.gif","design/xnova/gebaeude/113.gif","design/xnova/gebaeude/114.gif","design/xnova/gebaeude/115.gif","design/xnova/gebaeude/117.gif","design/xnova/gebaeude/118.gif","design/xnova/gebaeude/120.gif","design/xnova/gebaeude/121.gif","design/xnova/gebaeude/122.gif","design/xnova/gebaeude/123.gif","design/xnova/gebaeude/124.gif","design/xnova/gebaeude/199.gif",
                           "design/xnova/gebaeude/401.gif","design/xnova/gebaeude/402.gif","design/xnova/gebaeude/403.gif","design/xnova/gebaeude/404.gif","design/xnova/gebaeude/405.gif","design/xnova/gebaeude/406.gif","design/xnova/gebaeude/407.gif","design/xnova/gebaeude/408.gif","design/xnova/gebaeude/409.gif","design/xnova/gebaeude/410.gif","design/xnova/gebaeude/502.gif","design/xnova/gebaeude/120.gif","design/xnova/gebaeude/503.gif",
                           "design/xnova/images/appolonium.gif","design/xnova/images/deuterium.gif","design/xnova/images/energie.gif","design/xnova/images/kristall.gif","design/xnova/images/metall.gif",
                           "design/xnova/img/b.gif","design/xnova/img/bg1.gif","design/xnova/img/e.gif","design/xnova/img/m.gif","design/xnova/img/r.gif","design/xnova/img/s.gif",
                           "design/xnova/planeten/normaltempplanet01.gif","design/xnova/planeten/normaltempplanet02.gif","design/xnova/planeten/normaltempplanet03.gif","design/xnova/planeten/normaltempplanet04.gif","design/xnova/planeten/normaltempplanet05.gif","design/xnova/planeten/normaltempplanet06.gif","design/xnova/planeten/normaltempplanet07.gif","design/xnova/planeten/normaltempplanet08.gif","design/xnova/planeten/normaltempplanet09.gif","design/xnova/planeten/normaltempplanet10.gif",
                           "design/xnova/planeten/dschjungelplanet01.gif","design/xnova/planeten/dschjungelplanet02.gif","design/xnova/planeten/dschjungelplanet03.gif","design/xnova/planeten/dschjungelplanet04.gif","design/xnova/planeten/dschjungelplanet05.gif","design/xnova/planeten/dschjungelplanet06.gif","design/xnova/planeten/dschjungelplanet07.gif","design/xnova/planeten/dschjungelplanet08.gif","design/xnova/planeten/dschjungelplanet09.gif","design/xnova/planeten/dschjungelplanet10.gif",
                           "design/xnova/planeten/eisplanet01.gif","design/xnova/planeten/eisplanet02.gif","design/xnova/planeten/eisplanet03.gif","design/xnova/planeten/eisplanet04.gif","design/xnova/planeten/eisplanet05.gif","design/xnova/planeten/eisplanet06.gif","design/xnova/planeten/eisplanet07.gif","design/xnova/planeten/eisplanet08.gif","design/xnova/planeten/eisplanet09.gif","design/xnova/planeten/eisplanet10.gif",
                           "design/xnova/planeten/gasplanet01.gif","design/xnova/planeten/gasplanet02.gif","design/xnova/planeten/gasplanet03.gif","design/xnova/planeten/gasplanet04.gif","design/xnova/planeten/gasplanet05.gif","design/xnova/planeten/gasplanet06.gif","design/xnova/planeten/gasplanet07.gif","design/xnova/planeten/gasplanet08.gif","design/xnova/planeten/gasplanet09.gif","design/xnova/planeten/gasplanet10.gif",
                           "design/xnova/planeten/trockenplanet01.gif","design/xnova/planeten/trockenplanet02.gif","design/xnova/planeten/trockenplanet03.gif","design/xnova/planeten/trockenplanet04.gif","design/xnova/planeten/trockenplanet05.gif","design/xnova/planeten/trockenplanet06.gif","design/xnova/planeten/trockenplanet07.gif","design/xnova/planeten/trockenplanet08.gif","design/xnova/planeten/trockenplanet09.gif","design/xnova/planeten/trockenplanet10.gif",
                           "design/xnova/planeten/wasserplanet01.gif","design/xnova/planeten/wasserplanet02.gif","design/xnova/planeten/wasserplanet03.gif","design/xnova/planeten/wasserplanet04.gif","design/xnova/planeten/wasserplanet05.gif","design/xnova/planeten/wasserplanet06.gif","design/xnova/planeten/wasserplanet07.gif","design/xnova/planeten/wasserplanet08.gif","design/xnova/planeten/wasserplanet09.gif","design/xnova/planeten/wasserplanet10.gif",
                           "design/xnova/planeten/mond/mond.gif","design/xnova/planeten/mond/mond_01.gif","design/xnova/planeten/mond/mond_02.gif","design/xnova/planeten/mond/mond_03.gif","design/xnova/planeten/mond/mond_04.gif","design/xnova/planeten/mond/mond_05.gif",
                           "design/xnova/planeten/small_planet/s_normaltempplanet01.gif","design/xnova/planeten/small_planet/s_normaltempplanet02.gif","design/xnova/planeten/small_planet/s_normaltempplanet03.gif","design/xnova/planeten/small_planet/s_normaltempplanet04.gif","design/xnova/planeten/small_planet/s_normaltempplanet05.gif","design/xnova/planeten/small_planet/s_normaltempplanet06.gif","design/xnova/planeten/small_planet/s_normaltempplanet07.gif","design/xnova/planeten/small_planet/s_normaltempplanet08.gif","design/xnova/planeten/small_planet/s_normaltempplanet09.gif","design/xnova/planeten/small_planet/s_normaltempplanet10.gif",
                           "design/xnova/planeten/small_planet/s_dschjungelplanet01.gif","design/xnova/planeten/small_planet/s_dschjungelplanet02.gif","design/xnova/planeten/small_planet/s_dschjungelplanet03.gif","design/xnova/planeten/small_planet/s_dschjungelplanet04.gif","design/xnova/planeten/small_planet/s_dschjungelplanet05.gif","design/xnova/planeten/small_planet/s_dschjungelplanet06.gif","design/xnova/planeten/small_planet/s_dschjungelplanet07.gif","design/xnova/planeten/small_planet/s_dschjungelplanet08.gif","design/xnova/planeten/small_planet/s_dschjungelplanet09.gif","design/xnova/planeten/small_planet/s_dschjungelplanet10.gif",
                           "design/xnova/planeten/small_planet/s_eisplanet01.gif","design/xnova/planeten/small_planet/s_eisplanet02.gif","design/xnova/planeten/small_planet/s_eisplanet03.gif","design/xnova/planeten/small_planet/s_eisplanet04.gif","design/xnova/planeten/small_planet/s_eisplanet05.gif","design/xnova/planeten/small_planet/s_eisplanet06.gif","design/xnova/planeten/small_planet/s_eisplanet07.gif","design/xnova/planeten/small_planet/s_eisplanet08.gif","design/xnova/planeten/small_planet/s_eisplanet09.gif","design/xnova/planeten/small_planet/s_eisplanet10.gif",
                           "design/xnova/planeten/small_planet/s_gasplanet01.gif","design/xnova/planeten/small_planet/s_gasplanet02.gif","design/xnova/planeten/small_planet/s_gasplanet03.gif","design/xnova/planeten/small_planet/s_gasplanet04.gif","design/xnova/planeten/small_planet/s_gasplanet05.gif","design/xnova/planeten/small_planet/s_gasplanet06.gif","design/xnova/planeten/small_planet/s_gasplanet07.gif","design/xnova/planeten/small_planet/s_gasplanet08.gif","design/xnova/planeten/small_planet/s_gasplanet09.gif","design/xnova/planeten/small_planet/s_gasplanet10.gif",
                           "design/xnova/planeten/small_planet/s_trockenplanet01.gif","design/xnova/planeten/small_planet/s_trockenplanet02.gif","design/xnova/planeten/small_planet/s_trockenplanet03.gif","design/xnova/planeten/small_planet/s_trockenplanet04.gif","design/xnova/planeten/small_planet/s_trockenplanet05.gif","design/xnova/planeten/small_planet/s_trockenplanet06.gif","design/xnova/planeten/small_planet/s_trockenplanet07.gif","design/xnova/planeten/small_planet/s_trockenplanet08.gif","design/xnova/planeten/small_planet/s_trockenplanet09.gif","design/xnova/planeten/small_planet/s_trockenplanet10.gif",
                           "design/xnova/planeten/small_planet/s_wasserplanet01.gif","design/xnova/planeten/small_planet/s_wasserplanet02.gif","design/xnova/planeten/small_planet/s_wasserplanet03.gif","design/xnova/planeten/small_planet/s_wasserplanet04.gif","design/xnova/planeten/small_planet/s_wasserplanet05.gif","design/xnova/planeten/small_planet/s_wasserplanet06.gif","design/xnova/planeten/small_planet/s_wasserplanet07.gif","design/xnova/planeten/small_planet/s_wasserplanet08.gif","design/xnova/planeten/small_planet/s_wasserplanet09.gif","design/xnova/planeten/small_planet/s_wasserplanet10.gif",
                           "image/gala/links.gif","image/gala/rechts.gif",
                           "image/hintergrund/hintergrund_01.jpg",
                           "image/html/serial_32.gif","image/html/tidy_32.gif","image/html/vh401.gif",
                           "image/overview/Flotten.gif","image/overview/Miener.gif","image/overview/News_01.gif","image/overview/News_02.gif","image/overview/Punkte.gif","image/overview/Raid.gif","image/overview/User.gif",
                           "image/stat/allianz.png","image/stat/galaktiker.png","image/stat/gesamt.png","image/stat/sulurior.png","image/stat/team.png","image/stat/zyraten.png",
                           "image/volk/volk_01.jpg","image/volk/volk_02.jpg","image/volk/volk_03.jpg","image/volk/volk_04.png"
                           );
var progress = 0;

function loadImages() {

    if(document.all)document.getElementById("progressIndicator").style.height = 13;
    mHTML = "";
    rowTrack=0;

    for(i=0;i<imageArray.length;i++) {
        mHTML+='<img onload="incrementProgress();" class="mImg" align=left width=1 height=1 src=styl/' + imageArray[i] + '>'
        rowTrack++;

        if(rowTrack>=3){
            rowTrack=0; mHTML+="";
        }
    }
    document.getElementById("mContainer").innerHTML = mHTML;
}

function incrementProgress() {
    progress++;
    document.getElementById("progressIndicator").style.width = ((progress/imageArray.length)*100) + "%";
    document.getElementById("progressText").innerHTML = Math.round((progress/imageArray.length)*100) + '%';
    if(progress>=imageArray.length)showImages();
}

function showImages() {
    for(i=0;i<document.images.length;i++)if(document.images[i].className == "mImg")document.images[i].style.visibility="visible";
    document.getElementById("progressText").innerHTML = "{wartezeit_1005}";
    setTimeout("self.location.href='game.php?page=Space-Beginners'",1500);
}

</script>

</head>
<body style="background-color:black;padding-top:50px;color:white" onload="loadImages();">

<center>

<div style='position:absolute; bottom:0px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/planet.png' alt=''></div>
<div style='position:absolute; top:30px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/titelname.png' style='width:700px' alt=''></div>
<div style='position:absolute; top:0px; right:0px; left:0px; width:100%;' >
<table style='width:100%' cellspacing='0' >
    <tr><td align='center' >

        <table style='width:300px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' >{wartezeit_1000}</td>
                <td class='c' style='width:50%' align='center' >{wartezeit_1001}</td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td><td align="center" >

        <table style='width:300px' cellspacing="0" >
            <tr><td class='c' style='width:50%' align='center' ><a href="login.php?page=regel">{wartezeit_2002}</a></td>
                <td class='c' style='width:50%' align='center' ><a href="{forum_url}" target='_blank'>{wartezeit_2003}</a></td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td></tr>
</table>

<table>
     <tr><td style='height:135px;'>&nbsp;</td></tr>
</table>

<center>

<img src='./styl/image/login/menu_54.png' style='width:300px; height:10px;' alt=''>
<table cellpadding='0' cellspacing='0' style='width:300px;'>
    <tr><td align='center' class='c'>{wartezeit_1004}<br><br>

                            <div id="progressBar">
                                <div id="progressIndicator"></div>
                                <div id="progressText"></div>
                            </div>
                            <div id="mContainer"></div>
            </td></tr>
</table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>
</center>

</div>
</center>
</body>
</html>