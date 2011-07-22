<div class="wrapper-guide">
			<div id="page">

				<div id="header">
					<ul class="buttons">
						<li><a href="index.php">{menu_index}</a></li>
						<li class="skull"><a href="#"></a></li>

						<li class="tour"><a href="{forum_url}" target="_blank">{forum}</a></li>
					</ul>
				</div>
				<div id="main">

					<div class="content-big">
<div class="register">
	<div class="form-reg">
		<form name="lostpassword" action="index.php?page=lostpassword" method="post" id="formID">
			
				<div class="left-col">
					<ul class="login">

						<h2>{lost_pass_title}</h2>
						<label for="universe">{universe}</label><br>
        		<select name="universe" id="Andromeda">
            <option value="index.php" >Andromeda</option>
			    </select><br>
			
				<li><label for="email">{email}</label>
        	<center><b>{email}: <input type="text" name="email" /></b></center>
							
					</ul>

				</div>
				<div class="right-col">
				  <br><br><br><br><input tabindex="2" class="submit" type="submit" value="{send}"/>
				
				</div>
			
		</form>
	</div>
</div>
<strong class="logo">{servername}</strong>

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