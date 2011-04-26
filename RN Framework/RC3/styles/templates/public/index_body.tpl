<div id="main">
    <div id="login">
        <div id="login_input">
            <form action="" method="post">
            <table width="400" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr style="vertical-align: top;">
                <td style="padding-right: 4px;">
                    {user} <input name="username" value="" type="text">
                    {pass} <input name="password" value="" type="password">
                </td>
            </tr><tr>
                <td style="padding-right: 4px;">
                    {remember_pass} <input name="rememberme" type="checkbox"><input name="submit" value="{login}" type="submit">
                </td>
            </tr><tr>
                <td style="padding-right: 4px;"><a href="index.php?page=lostpassword">{lostpassword}</a><br>Mit dem Login akzeptiere ich die <a href="index.php?page=agb">AGB</a> und die <a href="index.php?page=rules">Regeln</a></td>
            </tr>
            </tbody>
            </table>
            </form>
        </div>
	</div>
    <div id="mainmenu" style="margin-top: 20px;">
    	<a href="index.php">{index}</a>
        <a href="index.php?page=reg">{register}</a>
        <a href="index.php?page=agb">AGB</a>
        <a href="index.php?page=rules">Regeln</a>
        <a href="{forum_url}">{forum}</a>
	</div>
    <div id="rightmenu" class="rightmenu">
        <div id="title">{welcome_to} {servername}</div>
        <div id="content">
        		<div id="text1" style="text-align:center;">
        			<div style="text-align: left;"><strong>{servername}{server_description}
					</div>
				</div>
        		<div id="register" class="bigbutton" onclick="document.location.href='index.php?page=reg';">{server_register}</div>
                <div id="text2">
                    <div id="text3" style="text-align:center;">
                        <b>{server_message} {servername}!</b>
                    </div>
                </div>
		</div>
	</div>
</div>


<!-- F&uuml;r den News-Mod muss {news} hier eintragen und die index_news.tpl anpassen! -->