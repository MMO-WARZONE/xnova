<?php include('login.php');?>

    	<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
            <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a> </p>			<p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>
	<br />	<div id="pageheader">
		<h2>	
            <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a> </h2> 
			</div>
 
	<br clear="all" /><br />
    		<?php
	if(!isset($_SESSION['suser'])) {
	?>
    <strong><h1>You must be logged in for this action!</h1></strong>
	<?php
	} else {
	?>
	<form action="reactiemede.php" method="post" name="postform">
 
<table class="tablebg" width="100%" cellspacing="0">
<caption><div class="cap-left"><div class="cap-right">&nbsp;Place a new message&nbsp;</div></div></caption>	<tr>
		<td class="row1"><b class="genmed">Subject type:</b></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td><input type="radio" class="radio" name="keuze" value="notpol" /><span class="genmed">Normal</span> <span style="white-space: nowrap;"><input type="radio" class="radio" name="keuze" value="pol" />POLL</span> </td>
			</tr>
			</table>
		</td>
	</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Forum:</b></td>
	<td class="row2" width="78%"><select class="post" style="width:450px" type="text" name="forum" size="1" tabindex="2"><option><?php echo "{$_GET['forum']}" ?></option></select> </td>
</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Subject:</b></td>
	<td class="row2" width="78%"><input class="post" style="width:450px" type="text" name="onderwerp" size="45" maxlength="60" tabindex="2" value="" /></td>
</tr>
<tr>
	<td class="row1" valign="top"><b class="genmed">Message:</b><br /><span class="gensmall">Place your message here, it can't contain more than <strong>60000</strong> characters.&nbsp;</span><br /><br />
			<table width="100%" cellspacing="5" cellpadding="0" border="0" align="center">
		<tr>
			<td class="gensmall" align="center"><b>Smilies</b></td>
		</tr>
		<tr>
			<td align="center">
									<a href="#" onclick="insert_text(':D', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_biggrin.gif" width="15" height="17" alt=":D" title="Very Happy" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':)', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_smile.gif" width="15" height="17" alt=":)" title="Smile" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(';)', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_wink.gif" width="15" height="17" alt=";)" title="Wink" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':(', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_sad.gif" width="15" height="17" alt=":(" title="Sad" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':o', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_surprised.gif" width="15" height="17" alt=":o" title="Surprised" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':shock:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_eek.gif" width="15" height="17" alt=":shock:" title="Shocked" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':?', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_confused.gif" width="15" height="17" alt=":?" title="Confused" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text('8-)', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_cool.gif" width="15" height="17" alt="8-)" title="Cool" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':lol:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_lol.gif" width="15" height="17" alt=":lol:" title="Laughing" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':x', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_mad.gif" width="15" height="17" alt=":x" title="Mad" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':P', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_razz.gif" width="15" height="17" alt=":P" title="Razz" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':oops:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_redface.gif" width="15" height="17" alt=":oops:" title="Embarrassed" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':cry:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_cry.gif" width="15" height="17" alt=":cry:" title="Crying or Very Sad" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':evil:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_evil.gif" width="15" height="17" alt=":evil:" title="Evil or Very Mad" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':twisted:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_twisted.gif" width="15" height="17" alt=":twisted:" title="Twisted Evil" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':roll:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_rolleyes.gif" width="15" height="17" alt=":roll:" title="Rolling Eyes" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':!:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_exclaim.gif" width="15" height="17" alt=":!:" title="Exclamation" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':?:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_question.gif" width="15" height="17" alt=":?:" title="Question" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':idea:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_idea.gif" width="15" height="17" alt=":idea:" title="Idea" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':arrow:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_arrow.gif" width="15" height="17" alt=":arrow:" title="Arrow" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':|', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_neutral.gif" width="15" height="17" alt=":|" title="Neutral" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':mrgreen:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_mrgreen.gif" width="15" height="17" alt=":mrgreen:" title="Mr. Green" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':geek:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_geek.gif" width="17" height="17" alt=":geek:" title="Geek" hspace="2" vspace="2" /></a>
									<a href="#" onclick="insert_text(':ugeek:', true); return false;" style="line-height: 20px;"><img src="./images/smilies/icon_e_ugeek.gif" width="17" height="18" alt=":ugeek:" title="Uber Geek" hspace="2" vspace="2" /></a>
							</td>
		</tr>
 
		
		</table>
		</td>
	<td class="row2" valign="top">
		<script type="text/javascript">
			// <![CDATA[
	
			var form_name = 'postform';
			var text_name = 'message';
			// ]]>
		</script>		
 
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr valign="middle" align="left">
	<td colspan="2">
		<script type="text/javascript">
		// <![CDATA[
		
		// Define the bbCode tags
		var bbcode = new Array();
		var bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]','[flash=]', '[/flash]','[size=]','[/size]');
		var imageTag = false;
		
		// Helpline messages
		var help_line = {
			b: 'Vette tekst: [b]tekst[/b]',
			i: 'Cursieve tekst: [i]tekst[/i]',
			u: 'Onderstreepte tekst: [u]tekst[/u]',
			q: 'Citeer tekst: [quote]tekst[/quote]',
			c: 'Code weergave: [code]code[/code]',
			l: 'Lijst: [list]tekst[/list]',
			o: 'Geordende lijst: [list=]tekst[/list]',
			p: 'Afbeelding: [img]http://www.phpbb.nl/fotos/foto.jpg[/img]',
			w: 'URL: [url]http://url[/url] of [url=http://url]URL tekst[/url]',
			s: 'Tekstkleur: [color=red]tekst[/color] Tip: je kan ook dit gebruiken: #FF0000',
			f: 'Letter grootte: [size=85]kleine tekst[/size]',
			e: 'Lijst: voeg lijstelement toe',
			d: 'Flash: [flash=height,width]http://url[/flash]',
			t: '{ BBCODE_T_HELP }',
			tip: 'Tip: opmaak kan je snel toepassen op de geselecteerde tekst.'
					}
		
		// ]]>
		</script>
		<script type="text/javascript" src="js/editor.js"></script>
 
		<input type="button" class="btnbbcode" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px;" onclick="bbstyle(0)" onmouseover="helpline('b')" onmouseout="helpline('tip')" />
		<input type="button" class="btnbbcode" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px;" onclick="bbstyle(2)" onmouseover="helpline('i')" onmouseout="helpline('tip')" />
		<input type="button" class="btnbbcode" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px;" onclick="bbstyle(4)" onmouseover="helpline('u')" onmouseout="helpline('tip')" />
					<input type="button" class="btnbbcode" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onclick="bbstyle(6)" onmouseover="helpline('q')" onmouseout="helpline('tip')" />
				<input type="button" class="btnbbcode" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onclick="bbstyle(8)" onmouseover="helpline('c')" onmouseout="helpline('tip')" />
		<input type="button" class="btnbbcode" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onclick="bbstyle(10)" onmouseover="helpline('l')" onmouseout="helpline('tip')" />
		<input type="button" class="btnbbcode" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onclick="bbstyle(12)" onmouseover="helpline('o')" onmouseout="helpline('tip')" />
		<input type="button" class="btnbbcode" accesskey="t" name="addlitsitem" value="[*]" style="width: 40px" onclick="bbstyle(-1)" onmouseover="helpline('e')" onmouseout="helpline('tip')" />				
					<input type="button" class="btnbbcode" accesskey="p" name="addbbcode14" value="Img" style="width: 40px" onclick="bbstyle(14)" onmouseover="helpline('p')" onmouseout="helpline('tip')" />
					<input type="button" class="btnbbcode" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onclick="bbstyle(16)" onmouseover="helpline('w')" onmouseout="helpline('tip')" />
				<span class="genmed nowrap">Size: <select class="gensmall" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" onmouseover="helpline('f')" onmouseout="helpline('tip')">
			<option value="50">Extra small</option>
			<option value="85">Small</option>
			<option value="100" selected="selected">Normal</option>
			<option value="150">Big</option>
			<option value="200">Extra big</option>
		</select></span>
	</td>
</tr>
<tr>
	<td id="helpline">Hint: format can be used quick on selected text.&nbsp;</td>
			<td class="genmed" align="center">Textcolor</td>
	</tr>
		<tr>
			<td valign="top" style="width: 100%;"><textarea name="reactie" rows="15" cols="76" tabindex="3" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);" style="width: 98%;"></textarea></td>
						<td width="80" align="center" valign="top">
				<script type="text/javascript">
				// <![CDATA[
					colorPalette('v', 7, 6)
				// ]]>
				</script>
			</td>
				 	</tr>
		</table>
	</td>
</tr>
 
 
<tr>
	<td class="row1" valign="top"><b class="genmed">Doesn't Work !! Options:</b><br />
		<table cellspacing="2" cellpadding="0" border="0">
		<tr>
			<td class="gensmall"><a href="./faq.php?mode=bbcode">BBCode</a> is <em>OFF</em></td>
		</tr>
				<tr>
			<td class="gensmall">[img] is <em>OFF</em></td>
		</tr>
		<tr>
			<td class="gensmall">[flash] is <em>OFF</em></td>
		</tr>
		<tr>
			<td class="gensmall">[url] is OFF</td>
		</tr>
		<tr>
			<td class="gensmall">Smilies is <em>OFF</em></td>
		</tr>
				</table>
	</td>
	<td class="row2">
		<table cellpadding="1">
					<tr>
				<td><input type="checkbox" class="radio" name="disable_bbcode" /></td>
				<td class="gen">Shut down BBCode</td>
			</tr>
					<tr>
				<td><input type="checkbox" class="radio" name="disable_smilies" /></td>
				<td class="gen">Shut down smilies</td>
			</tr>
				<tr>
			<td><input type="checkbox" class="radio" name="disable_magic_url" /></td>
			<td class="gen">Stop automizing URL's</td>
		</tr>
				</table>
	</td>
</tr>
 
 
<tr>
	<td class="cat" colspan="2" align="center">
		<input class="btnmain" type="submit" accesskey="s" tabindex="11" name="post" value="Place" />
		&nbsp; <input class="btnlite" type="reset" accesskey="c" tabindex="14" name="cancel" value="Reset" />
	</td>
</tr>
</table>
 
	<input type="hidden" name="creation_time" value="1242754260" />
<input type="hidden" name="form_token" value="b9ccd86cb0f695bb2ec74562927bed369eda414f" />
	</form>
    	<?php
	}
	?>
 
<br clear="all" />
 
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
            <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a> </p>			<p class="datetime">All times are GMT</p>		</td>
	</tr>
	</table>		<br clear="all" />
 
		<?php 
		$res=mysql_query("select count(username) from beta_users where forum_online='online'") or die(mysql_error());
		$res2=mysql_query("select username from beta_users where forum_online='online'") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
	include('visitors.php');
	$guests = CountGuests() - $row['count(username)'];
    $user =	"<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\">";
	$user .= "<tr>";
	$user .="<td class=\"cat\"><h4>Who is online</h4></td></tr><tr>";
	$user .="<td class=\"row1\" width=\"100%\"><span class=\"genmed\">Users on this forum ";
	$user .=":: ".$row['count(username)']." registered and ".$guests." guests ";
	$user .="<br />";
	$i=0;
	if(mysql_num_rows($res2) > 0) {
	
			while ($row2=mysql_fetch_assoc($res2))
			{
		$res3=mysql_query("select authlevel from beta_users where username = '".$row2['username']."'") or die(mysql_error());
		$row3=mysql_fetch_assoc($res3);
    	if($row3['authlevel'] != 0) {
			if($row3['authlevel'] != 1) {
				if($row3['authlevel'] != 2) {
					$status = "Site Admin";
					$color = "red";
					}	
				else{
					$status = "SGO";
					$color = "green";
				}
			}else{
				$status = "GO";
				$color = "lightgreen";
			}	
		}else {	
			$status = "User";	
			$color = "#06C";
		}
			$user .= "<div  style=\"color: ".$color."\"><b>".$row2['username']."</b></div>";
			$i++;
			}
	}
	else{
		$user .= "None registered users";
	}
	$user .= "</span></td>";
	$user .="</tr>";
	$user .="</table>";
	echo $user; 
?>	