<?php include('login.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>XNova Forum</title>
<LINK HREF="css/stylesheet.css" REL="stylesheet" TYPE="text/css">
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
<script language="javascript" src="js/time.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script>
<!--
//alert("Forum isn't ready yet!   Click ok to go on!");
-->
</script>
<?php 
$res=mysql_query("select max(id) from beta_users") or die(mysql_error());
$row=mysql_fetch_assoc($res);
$aantal=$row['max(id)'];
//$array=1;
$res2=mysql_query("select id from beta_board_subject order by id") or die(mysql_error());
$z=1;
if(mysql_num_rows($res2) > 0) {
while ($row2=mysql_fetch_assoc($res2)){
	/*for( $i = 1; $i < $aantal; $i++){
		$array[$i]=1;
		echo serialize($array[$i]);
	}*/
	$res3=mysql_query("select unread from beta_board_subject where id=".$row2['id']) or die(mysql_error());
	$row3=mysql_fetch_array($res3, MYSQL_ASSOC);
	$plus=unserialize($row3['unread']);
	for($i=1;$i<=$aantal;$i++){
		if($plus[$i]==NULL){
		$plus[$i]=1;
		}
	}
	mysql_query("update beta_board_subject set unread='".serialize($plus)."' where id=".$row2['id']) or die(mysql_error());
	$z++;
}
}
/*$id=12;
$res3=mysql_query("select unread from beta_board_subject where id=30") or die(mysql_error());
$row3=mysql_fetch_array($res3, MYSQL_ASSOC);
$change=unserialize($row3['unread']);
for($i=1;$i<=$aantal;$i++){
	if($i==$id){
		$change[$i]=0;
	}
}
mysql_query("update beta_board_subject set unread='".serialize($change)."' where id=30") or die(mysql_error());
echo "<hr>";
$sql=mysql_query("select unread from beta_board_subject") or die(mysql_error());
while($my=mysql_fetch_array($sql, MYSQL_ASSOC)){
	$load=unserialize($my['unread']);
	for( $i = 1; $i <= $aantal; $i++){
		echo $load[$i];
	}	
	echo "<br>";
}
$T=mysql_query("select max(id) from beta_board_forum") or die(mysql_error());
$test=mysql_fetch_assoc($T);
$T2=mysql_query("select forum from beta_board_forum where id='".$test['max(id)']."'") or die(mysql_error());
$test2=mysql_fetch_assoc($T2);
echo $test2['forum'];*/
?>
</head>

<body id="bodyid" onLoad="MM_preloadImages('img/button_topic_new2.gif')" >
<?php
	function pretty_number($n, $floor = true) {
		if ($floor) {
			$n = floor($n);
		}
		return number_format($n, 0, ",", ".");
	}
	
//session_start();
?>
<div  style="margin-left:auto;margin-right:auto;width:800px">

<table width="800" border="0.25" align="center" bgcolor="#333333" cellpadding="0" cellspacing="0" bordercolor="black" >
<div class="capleft"><div class="capright"></div></div>
  <tr>
  	<td width="800" height="99" align="center">
    <?php 
	/*$res=mysql_query("select unread from beta_board_subject order by id") or die(mysql_error());
	if(mysql_num_rows($res) > 0){
	while($row=mysql_fetch_assoc($res)){
		for( $i = 0; $i < $aantal; $i++){
	    $load=unserialize($row['unread']);
		echo $load;
    	}
	}
	}*/
	?>
    <br />
        <h3>Warsaalk is working on the forum, click <a href="a.txt" target="_blank">here</a> to open the file where you can see what still need to be done.</h3>
    <br /><br />
	<img src="img/xnovaproject.png" />
    <br />
    <br />
    </td>
  </tr>
  <tr>
    <td height="30" align="center" class="navrow">
    <?php
	if(!isset($_SESSION['suser'])) {
	?>
	<div class="logincolor"><form method="post">
	Username: <input type="text" name="naam" size="15" class="post">&nbsp;
	Password: <input type="password" name="wacht" size="15" class="post">&nbsp;
	<input type="checkbox" name="memory" value="1"> Remember (cookie)&nbsp;
	<input type="submit" name="login" value="log in" class="btnmain">
	</form></div>
	<?php
	} else {
	?>
	<div class="logincolor">Player: <?php $naam = $_SESSION['suser']; echo $naam; ?>,
	<a href="logout.php">Logout</a></div>
	<?php
    }
	?>
    </td>
  </tr>
  <tr>
    
    <td height="204">
    <div id="axah" >
    <?php
	if( $_GET['page']!=NULL ){
		if( $_GET['page']!='topic'){
			if( $_GET['page']!='forums'){
				if( $_GET['page']!='pol'){
					echo "There is something wrong! Contact Warsaalk";
				}else{
					include('pol.php');
				}
			}else{
				include('forums.php');
			}
		}else{
		if( $_GET['t']==2 ){
			include('topic.php');
		}else{
			include('topicmede.php');
		}
		}
	}else{
		include('home.php');
	}
	?>
	</div>
    </td>
  
  </tr>
  <tr>
    <td align="center"><br /><hr width="700" class="hrbottom" /><br />Designed by <A HREF="mailto:warsaalk@gmail.com?SUBJECT=Contact for Forum">Warsaalk</A> for <a target="_blank" href="http://xnovauk.darkevo.org/">XNova UK</a><br />Warsaalk &copy; 2009. All rights reserved.<br /><br />
    <?php include('count.php');?></td>
  </tr>
  <tr>
  <td>&nbsp;
  </td>
  </tr>
</table>
<div align="center"><img src="img/bottombar.gif" /></div>
</div>
<br />
<br />
<br />
</body>
</html>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
//-->
</script>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
ajax("time.php","time",500);
</script>
