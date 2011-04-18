
<div id="bxx" class="z"></div>
<script   type="text/javascript">

v=new Date();
var bxx=document.getElementById('bxx');
function t(){
	n=new Date();
	ss={time};
	s=ss-Math.round((n.getTime()-v.getTime())/1000.);
	m=0;h=0;
	if(s<0){
		bxx.innerHTML='{ready}<br><a href=buildings.php?mode=research&cp={idcp}>{continue}</a>';
	}else{
		if(s>59){m=Math.floor(s/60);s=s-m*60;}
		if(m>59){h=Math.floor(m/60);m=m-h*60;}
		if(s<10){s="0"+s}
		if(m<10){m="0"+m}
		bxx.innerHTML=h+':'+m+':'+s+'<br><a href="buildings.php?mode=research&unbau={unbau}">{cancel}<br><br>{name}</a>';
	}
	window.setTimeout("t();",999);
}
window.onload=t;

</script>