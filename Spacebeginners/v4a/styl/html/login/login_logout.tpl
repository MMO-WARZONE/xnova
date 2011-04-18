
<!--

/**
  * login_logout.tpl
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
<script type="text/javascript">
var second = {tps_seconds};
function Init() {
    document.getElementById("CompteARebours").innerHTML = second;
    setInterval(AffichageCompteARebours,1000);
}

function AffichageCompteARebours() {
    document.getElementById("CompteARebours").innerHTML = --second;
}

window.onload = function () {
    Init();
}
</script>

</head>
<body>

<center>

<div style='position:absolute; bottom:0px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/planet.png' alt=''></div>
<div style='position:absolute; top:30px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/titelname.png' style='width:700px' alt=''></div>
<div style='position:absolute; top:0px; right:0px; left:0px; width:100%;' >

<center><table style='width:100%' cellspacing='0' >
    <tr><td align='center' >

        <table style='width:300px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' >{logout_1000}</td>
                <td class='c' style='width:50%' align='center' >{logout_1001}</td></tr>
        </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt=''>

            </td><td align="center" >

        <table style='width:300px' cellspacing="0" >
            <tr><td class='c' style='width:50%' align='center' >{logout_1002}</td>
                <td class='c' style='width:50%' align='center' ><a href="{forum_url}" style='color:#FFFFFF;' target='_blank'>{logout_1003}</a></td></tr>
        </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt=''>

            </td></tr>
</table></center> 

<center><table>
     <tr><td style='height:75px;'>&nbsp;</td></tr>
</table></center>

<center><img src='./styl/image/login/box1_header_left.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right.png' style='width:7px; height:15px;' alt=''><table cellpadding='0' cellspacing='0' style='width:300px;'>
    <tr><td align='center' class='c'>{logout_1004}<br><br><br>{logout_1005}<span id=CompteARebours></span>{logout_1006}<br><br><a href="login.php">{logout_1007}</a>
            </td></tr>
</table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt=''></center>

<center><table>
     <tr><td style='height:50px;'>&nbsp;</td></tr>
</table></center>

<center><table cellpadding='0' cellspacing='0'>
    <tr><td>

            <img src='./styl/image/login/box1_header_left.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right.png' style='width:7px; height:15px;' alt=''><table cellpadding='0' cellspacing='0' style='width:300px;'>
                <tr><td class='c' align='center'><a href='./login.php'><u>{logout_1008}</u></a><br><br><img src='./styl/image/login/logo.png' style='width:296px; height:70px;' alt=''></td></tr>
            </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt=''>

            </td>
        <td style='width:25px' >&nbsp;</td>
        <td>

            <img src='./styl/image/login/box1_header_left.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right.png' style='width:7px; height:15px;' alt=''><table cellpadding='0' cellspacing='0' style='width:300px;'>
                <tr><td class='c' align='center'><a href='{forum_url}' target='_blank'><u>{logout_1009}</u></a><br><br><img src='./styl/image/login/logo.png' style='width:296px; height:70px;' alt=''></td></tr>
            </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt=''><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt=''><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt=''>

            </td></tr>
</table></center>

</div>
</center>
</body>
</html>