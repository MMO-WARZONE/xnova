<style type="text/css">
<!--
.wrapper #page #main .form form fieldset .login li label {
	color: #FFF;
}
.wrapper #page #main .form form fieldset .help li a {
	color: #FFF;
}
.wrapper #page #main #footer ul li a {
	color: #FFF;
}
.wrapper #page #main #footer p {
	color: #FFF;
}
-->
</style>
<div class="wrapper">
			<div id="page">
				<div id="header">
					<ul class="buttons">
						<li><a href="index.php">{menu_index}</a></li>
						<li class="skull"><a href="#"></a></li>

						<li class="tour"><a href="{forum_url}" target="_blank">{forum}</a></li>
					</ul>
				</div>
				<div id="main">
					<div class="content">
						<div class="central-btn">
	<a href="reg.php">&iexcl;{register_now}!</a>
</div>

<div class="text-flag">
    <p>{server_description}<br>
		  </p>
</div>
<strong class="logo">
	<a href="reg.php">{servername}</a>
</strong>					</div>

					<div class="form">
						<form action="" method="post" name="xgproyect">
							<fieldset>
								<ul class="login">
									<li>
										<label>{universe}</label>
										<select name="uni">
                                       <option value="uni1/index.php" >uni1</option>
								      </select>
									</li>

									<li>
										<label for="username">{user}</label>
										<div class="bg"><input name="username" value="" type="text"></div>
									</li>
									<li>
										<label for="userpass">{pass}</label>
										<div class="bg"><input name="password" value="" type="password"></div>
									</li>

									<li><div class="bg submit"><input type="submit" value="{login}" name="submit" class="submit" /></div></li>
								</ul>
								<ul class="help">
									<li><a href="index.php?page=lostpassword">{lostpassword}</a></li>
									<li><a href="reg.php">{register_now}</a></li>
								</ul>

							</fieldset>
						</form>
					</div>
					<div id="footer">
						<p>Powered by <a href="http://www.xgproyect.net/" target="_blanck" title="XG Proyect {version}">XG Proyect {version}</a> &#169; 2008 - 2011.</p>
						<ul>
						  <li><a href="?lang={$lng}"><img src="./styles/images/login/es.png" alt="" width="16" height="11"></a><br><br>
                          <p>{creditsdesing}</p>|<p> {creditsadapter}.</p>
				      </ul>
					</div>
				</div>
			</div>
		</div>