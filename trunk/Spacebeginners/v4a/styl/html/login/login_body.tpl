<!--

/**
  * login_body.tpl
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

-->

<script type="text/javascript">
var lastType = "";
function changeAction(type) {

    if (document.formular.Uni.value == '') {
        alert('{log_univ}');
    } else {

        if(type == "login" && lastType == "") {
            var url = "http://" + document.formular.Uni.value + "";
            document.formular.action = url;
        } else {
            var url = "http://" + document.formular.Uni.value + "/reg.php";
            document.formular.action = url;
            document.formular.submit();
        }
    }
}
</script>

<div style='position:absolute; bottom:0px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/planet.png' alt=''></div>
<div style='position:absolute; top:30px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/titelname.png' style='width:700px' alt=''></div>
<div style='position:absolute; bottom:20px; right:0%; width:200px;' ><a href="login.php?page=kontakt">{login_3000}</a> / <a href="login.php?page=credit">{login_3001}</a></div>

<div style='position:absolute; bottom:20px; left:0%; width:130px;'><img src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Transitional" style='height:31px; width:88px;'></div>

<div style='position:absolute; top:0px; right:0px; left:0px; width:100%;' >
<table style='width:100%' cellspacing='0' >
    <tr><td align='center' >

        <table style='width:300px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' >{login_1000}</td>
                <td class='c' style='width:50%' align='center' >{login_1001}</td></tr>
        </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt='box2_title_left.png'><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt='box3_header_left.png'><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt='box2_title_left.png'>

            </td><td align="center" >

        <table style='width:300px' cellspacing="0" >
            <tr><td class='c' style='width:50%' align='center' >{login_1002}</td>
                <td class='c' style='width:50%' align='center' ><a href="{forum_url}" style='color:#FFFFFF;' target='_blank'>{login_1003}</a></td></tr>
        </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt='box2_title_left.png'><img src='./styl/image/login/box1_header_center2.png' style='width:288px; height:15px;' alt='box3_header_left.png'><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt='box2_title_left.png'>

            </td></tr>
</table>

<br><br><br><br><br><br>


<center><table style='width:600px;' cellspacing='0'>
    <tr><td style='width:100%; color:#FFFFFF; font-size:112%' align='center'> {servername} {login_0001}<br><br> {login_0002} {login_0003}<br><br><div align='left' ><ul><li>{login_0004}</li><li>{login_0005}</li><li>{login_0006}</li><li>{login_0007}</li><li>{login_0008}</li><li>{login_0009}</li></ul></div><br><u>{login_0010}</u><br>{login_0011}{login_0012}{login_0013}{login_0014}{login_0015}</td></tr>
</table></center>

<br><br>

<form name="formular" action="" method="post" onsubmit="changeAction('login');">
<div style='position:absolute; top:370px; right:0px; left:0px; width:100%;' >

<center><table style='width:720px;'>
    <tr><td style='width:300px; height:100px;' align="center" >

        <img src='./styl/image/login/box2_title_left.png' style='width:20px; height:15px;' alt=''><img src='./styl/image/login/box2_title_center.png' style='width:260px; height:15px;' alt=''><img src='./styl/image/login/box2_title_right.png' style='width:20px; height:15px;' alt=''><table style='width:300px; height:75px;' cellspacing='0' >
            <tr><td class='c' style='width:48%' align='center'>{login_2000}      </td>
                <td class='c' style='width:4%'  align='center'> :                </td>
                <td class='c' style='width:48%' align='center'>{online_users}    </td></tr>
            <tr><td class='c' style='width:48%' align='center'>{login_2001}     </td>
                <td class='c' style='width:4%'  align='center'> :                </td>
                <td class='c' style='width:48%' align='center'>{last_user}       </td></tr>
            <tr><td class='c' style='width:48%' align='center'>{login_2002}     </td>
                <td class='c' style='width:4%'  align='center'> :                </td>
                <td class='c' style='width:48%' align='center'>{users_amount}    </td></tr>
        </table><img src='./styl/image/login/box2_title_left2.png' style='width:20px; height:15px;' alt=''><img src='./styl/image/login/box2_title_center2.png' style='width:260px; height:15px;' alt=''><img src='./styl/image/login/box2_title_right2.png' style='width:20px; height:15px;' alt=''>

            </td>
        <td style='width:104px' align="center" >

        <img src='./styl/image/login/box1_header_left.png' style='width:7px; height:15px;' alt='box2_title_left.png'><img src='./styl/image/login/box1_header_center.png' style='width:88px; height:15px;' alt='box3_header_left.png'><img src='./styl/image/login/box1_header_right.png' style='width:7px; height:15px;' alt='box2_title_left.png'><table style='width:100px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' ><a href="login.php?page=reg">{login_2003}</a></td></tr>
        </table><img src='./styl/image/login/box1_header_left2.png' style='width:7px; height:15px;' alt='box2_title_left.png'><img src='./styl/image/login/box1_header_center2.png' style='width:88px; height:15px;' alt='box3_header_left.png'><img src='./styl/image/login/box1_header_right2.png' style='width:7px; height:15px;' alt='box2_title_left.png'>

            </td>
        <td style='width:300px; height:100px;'>

        <img src='./styl/image/login/box2_title_left.png' style='width:20px; height:15px;' alt=''><img src='./styl/image/login/box2_title_center.png' style='width:260px; height:15px;' alt=''><img src='./styl/image/login/box2_title_right.png' style='width:20px; height:15px;' alt=''><table style='width:300px; height:75px;' cellspacing='0' >
            <tr><td class='c' style='width:48%' align='center'> {login_2004} </td>
                <td class='c' style='width:4%'  align='center'> : </td>
                <td class='c' style='width:48%' align='center'><input name="username" value="" type="text"> </td></tr>
            <tr><td class='c' style='width:48%' align='center'> {login_2005} </td>
                <td class='c' style='width:4%'  align='center'> : </td>
                <td class='c' style='width:48%' align='center'><input name="password" value="" type="password">  </td></tr>
            <tr><td class='c' style='width:48%' align='center'><a href="#" onclick="document.getElementById('image').src = 'captcha.php?sid=' + Math.random(); return false"><img src='captcha.php' id='image' alt=''></a></td>
                <td class='c' style='width:4%'  align='center'> : </td>
                <td class='c' style='width:48%' align='center'><input name="captcha" size="20" maxlength="20" type="text" onKeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"></td></tr>
        </table><img src='./styl/image/login/box2_title_left2.png' style='width:20px; height:15px;' alt=''><img src='./styl/image/login/box2_title_center2.png' style='width:260px; height:15px;' alt=''><img src='./styl/image/login/box2_title_right2.png' style='width:20px; height:15px;' alt=''>

            </td></tr>
</table></center>

<br>

<center><img src='./styl/image/login/box2_title_left.png' style='width:20px; height:15px;' alt=''><img src='./styl/image/login/box2_title_center.png' style='width:310px; height:15px;' alt=''><img src='./styl/image/login/box2_title_right.png' style='width:20px; height:15px;' alt=''><table style='width:350px' cellspacing='0' >
    <tr><td class='c' style='width:48%' align='center'>{login_2006} <input name="rememberme" type="checkbox">     </td>
        <td class='c' style='width:4%'  align='center'> &nbsp; </td>
        <td class='c' style='width:48%' align='center'><script type="text/javascript">document.formular.Uni.focus(); </script><input name="submit" value="{login_2007}" type="submit"></td></tr>
</table><img src='./styl/image/login/box2_title_left2.png' style='width:20px; height:15px;' alt=''><img src='./styl/image/login/box2_title_center2.png' style='width:310px; height:15px;' alt=''><img src='./styl/image/login/box2_title_right2.png' style='width:20px; height:15px;' alt=''></center>


</div></form></div>
