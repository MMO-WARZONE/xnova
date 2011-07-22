<html>
    <head>
        <title>Session termin&eacute;e.</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" type="text/css" href="skins/xnova/default.css" /><link rel="stylesheet" type="text/css" href="skins/xnova/formate.css" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <script type="text/javascript" src="scripts/overlib.js"></script>
    </head>
    
    <body>
        <script type="text/javascript">
            var second = {tps_seconds};

            function Init() {
                document.getElementById("CompteARebours").innerHTML = second;
                setInterval(AffichageCompteARebours,1000);
            }

            function AffichageCompteARebours() {
                document.getElementById("CompteARebours").innerHTML = --second;
            }
 
            window.onload = function () { Init(); }
        </script>

        <center>
            <p></p>
            <table width="519">
                <tr>
                    <td class="c"><font color="">{session_close}</font></td>
                </tr>
                <tr>
                    <th class="errormessage">{mes_session_close}</th>
                </tr>
            </table>
            <p></p>
            <table width="519">
                <tr>
                    <td class="c">Redirection</td>
                </tr>
                <tr>
                    <th class="errormessage">Sie werden in <span id=CompteARebours></span> s<p></p><a href="login.php">Klicken Sie hier, um nicht zu warten</a></th>
                </tr>
            </table>
        </center>
    </body> 
</html> 