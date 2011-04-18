
<!--

/**
  * login_anmelden.tpl
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

-->

<div style='position:absolute; top:30px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/titelname.png' style='width:700px' alt=''></div>
<div style='position:absolute; bottom:20px; right:0%; width:200px;' ><a href="login.php?page=kontakt">{anmelden_3000}</a> / <a href="login.php?page=credit">{anmelden_3001}</a></div>

<div style='position:absolute; bottom:20px; left:0%; width:200px;' align='left'>- <a href="login.php">{anmelden_3002}</a></div>
<div style='position:absolute; bottom:60px; left:0%; width:200px;' align='left'>- <a href="login.php?page=volk_01">{anmelden_3003}</a></div>
<div style='position:absolute; bottom:75px; left:0%; width:200px;' align='left'>- <a href="login.php?page=volk_02">{anmelden_3004}</a></div>
<div style='position:absolute; bottom:90px; left:0%; width:200px;' align='left'>- <a href="login.php?page=volk_03">{anmelden_3005}</a></div>

<div style='position:absolute; top:0px; right:0px; left:0px; width:100%;' >
<table style='width:100%' cellspacing='0' >
    <tr><td align='center' >

        <table style='width:300px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' >{anmelden_1000}</td>
                <td class='c' style='width:50%' align='center' >{anmelden_1001}</td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td><td align="center" >

        <table style='width:300px' cellspacing="0" >
            <tr><td class='c' style='width:50%' align='center' ><a href="login.php?page=regel">{anmelden_1002}</a></td>
                <td class='c' style='width:50%' align='center' ><a href="{forum_url}" target='_blank'>{anmelden_1003}</a></td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td></tr>
</table>

<br><br><br><br><br><br>

<center><table>
    <tr><td>

        <img src='./styl/image/login/menu_52.png' style='width:150px; height:10px;' alt=''><table style='width:150px;' cellspacing='0' >
            <tr><td class='c' align='center' ><img src='./styl/image/pfeile/linku.png' alt=''><a href='login.php?page=volk_01' > {anmelden_4000} </a><img src='./styl/image/pfeile/rechtu.png' alt=''></td></tr>
            <tr><td class='c' align='center' style='height:160px'><img src='./styl/image/volk/volk_01.jpg' style='width:90%; height:148px;' alt=''></td></tr>
        </table><img src='./styl/image/login/menu_53.png' style='width:150px; height:10px;' alt=''>

            </td>
        <td>

        <img src='./styl/image/login/menu_52.png' style='width:150px; height:10px;' alt=''><table style='width:150px;' cellspacing='0' >
            <tr><td class='c' align='center' ><img src='./styl/image/pfeile/linku.png' alt=''><a href='login.php?page=volk_02' > {anmelden_4001} </a><img src='./styl/image/pfeile/rechtu.png' alt=''></td></tr>
            <tr><td class='c' align='center' style='height:160px'><img src='./styl/image/volk/volk_02.jpg' style='width:90%; height:148px;' alt=''></td></tr>
        </table><img src='./styl/image/login/menu_53.png' style='width:150px; height:10px;' alt=''>

            </td>
        <td>

        <img src='./styl/image/login/menu_52.png' style='width:150px; height:10px;' alt=''><table style='width:150px;' cellspacing='0' >
            <tr><td class='c' align='center' ><img src='./styl/image/pfeile/linku.png' alt=''><a href='login.php?page=volk_03' > {anmelden_4002} </a><img src='./styl/image/pfeile/rechtu.png' alt=''></td></tr>
            <tr><td class='c' align='center' style='height:160px'><img src='./styl/image/volk/volk_03.jpg' style='width:90%; height:148px;' alt=''></td></tr>
        </table><img src='./styl/image/login/menu_53.png' style='width:150px; height:10px;' alt=''>

            </td></tr>
</table></center>

<br>



<form action="" method="post">   <div style='position:absolute; top:320px; right:0px; left:0px; width:100%;' >

<center><table>
    <tr><td>

        <img src='./styl/image/login/menu_54.png' style='width:300px; height:10px;' alt=''><table style='width:300px;' cellspacing='0' >
            <tr><td class='c' align='center' style='width:50%'> {anmelden_2007} </td>
                <td class='c' align='center' style='width:50%'><select name="volk"><option value="A"> {anmelden_2007_01} </option>
                                                                                   <option value="B"> {anmelden_2007_02} </option>
                                                                                   <option value="C"> {anmelden_2007_03} </option></select></td></tr>

        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td></tr>
</table></center>

<center><table style='width:720px;'>
    <tr><td style='width:300px; height:100px;'>

         <img src='./styl/image/login/menu_54.png' style='width:300px; height:10px;' alt=''><table style='width:300px; height:75px;' cellspacing='0' >
            <tr><td class='c' style='width:48%' align='center' title='{anmelden_2005}' >{anmelden_2000}   </td>
                <td class='c' style='width:4%'  align='center'> :                </td>
                <td class='c' style='width:48%' align='center'><input name="character" size="20" maxlength="20" type="text" onKeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"></td></tr>
            <tr><td class='c' style='width:48%' align='center' title='{anmelden_2005}' >{anmelden_2001}   </td>
                <td class='c' style='width:4%'  align='center'> :                </td>
                <td class='c' style='width:48%' align='center'><input name="passwrd" size="20" maxlength="20" type="password" onKeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"></td></tr>
            <tr><td class='c' style='width:48%' align='center'>{anmelden_2002}   </td>
                <td class='c' style='width:4%'  align='center'> :                </td>
                <td class='c' style='width:48%' align='center'><input name="email" size="20" maxlength="40" type="text" onKeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"></td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td>
        <td style='width:104px' align="center" >

        <img src='./styl/image/login/menu_50.png' style='width:100px; height:10px;' alt=''><table style='width:100px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' ><input name="submit" type="submit" value="{signup}"></td></tr>
        </table><img src='./styl/image/login/menu_51.png' style='width:100px; height:10px;' alt=''>

            </td>
        <td style='width:300px; height:100px;'>

        <img src='./styl/image/login/menu_54.png' style='width:300px; height:10px;' alt=''><table style='width:300px; height:75px;'  cellspacing='0'>
            <tr><td class='c' style='width:48%' align='center' title='{anmelden_2005}' > {anmelden_2003} </td>
                <td class='c' style='width:4%'  align='center'> :               </td>
                <td class='c' style='width:48%' align='center'><input name="planet" size="20" maxlength="20" type="text" onKeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;if (event.which==60 || event.which==62) return false;"></td></tr>
            <tr><td class='c' style='width:48%' align='center'> {anmelden_2004} </td>
                <td class='c' style='width:4%'  align='center'> :               </td>
                <td class='c' style='width:48%' align='center'><select name="sex"><option value="M">{anmelden_2004_01}  </option>
                                                                                  <option value="F">{anmelden_2004_02}  </option></select></td></tr>
            <tr><td class='c' style='width:48%' align='center'><a href="#" onclick="document.getElementById('image').src = 'captcha.php?sid=' + Math.random(); return false"><img src='captcha.php' id='image' alt=''></a></td>
                <td class='c' style='width:4%'  align='center'> : </td>
                <td class='c' style='width:48%' align='center'><input name="captcha" size="20" maxlength="20" type="text" onKeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"></td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td></tr>
</table></center>

<br>

<center>
<img src='./styl/image/login/menu_54.png' style='width:350px; height:10px;' alt=''><table style='width:350px'  cellspacing='0'>
    <tr><td class='c' style='width:100%' align='center' valign='top'>{anmelden_2006}<input name="rgt" type="checkbox"></td></tr>
</table><img src='./styl/image/login/menu_55.png' style='width:350px; height:10px;' alt=''>
</center>

</div></form></div>