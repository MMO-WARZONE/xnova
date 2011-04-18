
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
<div style='position:absolute; top:30px; right:0px; left:0px; width:100%;' ><img src='./styl/image/login/titelname.png' style='width:700px' alt=''></div>
<div style='position:fixed; bottom:20px; right:0%; width:200px;' ><a href="login.php?page=kontakt">{login_3000}</a> / <a href="login.php?page=credit">{login_3001}</a></div>
<div style='position:fixed; bottom:20px; left:0%; width:200px;' align='left'>- <a href="login.php">Zur&uuml;ck zum Login</a></div>
<center>
<table style='width:100%' cellspacing='0' >
    <tr><td align='center' >

        <table style='width:300px' cellspacing='0' >
            <tr><td class='c' style='width:50%' align='center' >{login_1000}</td>
                <td class='c' style='width:50%' align='center' >{login_1001}</td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td><td align="center" >

        <table style='width:300px' cellspacing="0" >
            <tr><td class='c' style='width:50%' align='center' ><a href="login.php?page=regel">{login_1002}</a></td>
                <td class='c' style='width:50%' align='center' ><a href="{forum_url}" target='_blank'>{login_1003}</a></td></tr>
        </table><img src='./styl/image/login/menu_55.png' style='width:300px; height:10px;' alt=''>

            </td></tr>
</table>

<br><br><br><br><br><br>

<table style='width:520px;'>
    <tr><td align='center' valign='top'>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c"  align='center'><b>{rules} {servername}</b></td></tr>
            <tr><td class="c" align='center'><font color="#FF0000">{respectrules}</font></td></tr>
            <tr><td class="c"><div align="left"><a href="#a_1">{Account}</a><br>
                                               <a href="#a_2">{MultiAccount}</a><br>
                                               <a href="#a_3">{Sitting}</a><br>
                                               <a href="#a_4">{Trade}</a><br>
                                               <a href="#a_5">{Bash}</a><br>
                                               <a href="#a_6">{Push}</a><br>
                                               <a href="#a_7">{Bugusing}</a><br>
                                               <a href="#a_8">{MailIngame}</a><br>
                                               <a href="#a_9">{OutXnova}</a><br>
                                               <a href="#a_10">{Spam}</a></div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_1"><b>{Account}</b></div></td></tr>
            <tr><td class="c"><div align="left">- {AccountText}<br>- {AccountText2}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_2"><b>{MultiAccount}</b></div></td></tr>
            <tr><td class="c"><div align="left">- {MultiAccountText}<br>- {MultiAccountText2}<br>- {MultiAccountText3}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>


        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_3"><b>{Sitting}</b></div></td></tr>
            <tr><td class="c"><div align="left">{SittingText}<br>- {SittingText2}<br>- {SittingText3}<br>- {SittingText4}<br>- {SittingText5}<br>- {SittingText6}<br>- {SittingText7}<br>- {SittingText8}<br>- {SittingText9}<br><br>{SittingText10}<br>- {SittingText11}<br>- {SittingText12}<br>- {SittingText13}<br>- {SittingText14}<br>- {SittingText15}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_4"><b>{Trade}</b></div></td></tr>
            <tr><td class="c"><div align="left">{TradeText}<br>{TradeText2}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_5"><b>{Bash}</b></div></td></tr>
            <tr><td class="c"><div align="left">- {BashText}<br>- {BashText2}<br><br>{exception}<br>- {BashExepText}<br>- {BashExepText2}<br>- {BashExepText3}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_6"><b>{Push}</b></div></td></tr>
            <tr><td class="c"><div align="left">{PushText}<br>- {PushText2}<br>- {PushText3}<br>- {PushText4}<br>- {PushText5}<br><br>{exemple}<br>- {PushEx}<br>- {PushEx2}<br><br>{recyclage}<br>- {PushRec}<br><br>{mercenariat}<br>- {PushMer}<br>- {PushMer2}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_7"><b>{Bugusing}</b></div></td></tr>
            <tr><td class="c"><div align="left">-{BugusingText}<br>- {BugusingText2}<br>- {BugusingText3}<br>- {BugusingText4}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_8"><b>{MailIngame}</b></div></td></tr>
            <tr><td class="c"><div align="left">{MailIngameText}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_9"><b>{OutXnova}</b></div></td></tr>
            <tr><td class="c"><div align="left">{OutText}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        <br/><br/>

        <img src='./styl/image/login/menu_56.png' style='width:520px; height:10px;' alt=''><table style='width:520px' cellspacing='0' >
            <tr><td class="c" align='center'><div id="a_10"><b>{Spam}</b></div></td></tr>
            <tr><td class="c"><div align="left">{SpamText}</div></td></tr>
        </table><img src='./styl/image/login/menu_57.png' style='width:520px; height:10px;' alt=''>

        </td></tr>
</table>
</center>
