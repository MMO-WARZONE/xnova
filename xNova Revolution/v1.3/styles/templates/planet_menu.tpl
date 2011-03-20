<div id='menu2'>
<div id="clock"></div>
<script language="JavaScript">
<!-- Script Burada Basliyor 
var nav=navigator.userAgent.toLowerCase();
var isopera=false;
if ((nav.indexOf('opera 1')!=-1) || (nav.indexOf('opera 2')!=-1) || (nav.indexOf('opera 3')!=-1) || (nav.indexOf('opera 4')!=-1) || (nav.indexOf('opera 5')!=-1) || (nav.indexOf('opera 6')!=-1)) isopera=true;
var dayarray=new Array("Lun","Mar","Mie","Jue","Vie","Sab","Dom")
var montharray=new Array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic")
function getthedate(){
var mydate=new Date()
var year=mydate.getFullYear()
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10) daym="0"+daym
var hours=mydate.getHours()
var minutes=mydate.getMinutes()
var seconds=mydate.getSeconds()
var tz=Math.round(mydate.getTimezoneOffset()/60)
var shvaikatimezone=2
tz+=shvaikatimezone
var hourss=hours+tz;
hourss>=24?hourss-=24:hourss;
hourss<=0?hourss+=24:hourss;
if (hourss==24) hourss=0
var dn="种"
var dns="种"
// Burada Yazan 种 "謌lede 謓ce" Anlamina Gelir AM in T黵k鏴 Karsiligidir. //
if (hours>=24)
{
 dn="諷"
 hours-=12
}
if (hours==0) hours=12
if (hourss>=24)
{
 dns="諷"
 hourss-=12
}
// Burada Yazan 諷 "謌lede Sonra" Anlamina Gelir PM in T黵k鏴 Karsiligidir. //
if (hourss==0) hourss=12
if (minutes<=9) minutes="0"+minutes
if (seconds<=9) seconds="0"+seconds
// Altkisimda Face Yazan Yerden Font Degisikligi Yapabilirsiniz.//
var st1="<font color='#FFFFFF' face='Arial'>"
var st2="<font color='#FF0000' face='Arial'>"
var st3="<font color='#008000' face='Arial'>"
if (mydate.getDay()!=0)
 cdate="<large>"+st1+"<b>"+daym+"  "+montharray[month]+"  "+year+"   "+dayarray[day]+"  "+hours+":"+minutes+":"+seconds+"</b></font></large>"
else
  cdate="<small>"+st2+"<b>"+daym+"  "+montharray[month]+"  "+year+"   "+dayarray[day]+"  "+hours+":"+minutes+":"+seconds+" </b></font></small>"
// 諷 ve 种 kisimlarini yukardaki siralamadan "+dn"+ kismini silerek 鏸karabilirsiniz.//
if (document.all&&isopera!=true)
{
 document.all.clock.style.position='relative'
 document.all.clock.innerHTML=cdate
}
else if (document.layers)
 {
  document.clock.visibility='show'
  document.clock.document.open();
  document.clock.document.write('<center>'+cdate+'</center>');
  document.clock.document.close();
 }
else if (document.getElementById&&isopera!=true)
  {document.getElementById("clock").innerHTML=cdate}  
else document.write('<center>'+cdate+'</center>')  
}
if (!document.layers&&!document.all&&!document.getElementById) getthedate()
else if (isopera!=true) setInterval("getthedate()",1000)
else getthedate();
//!--> Script burada bitiyor.
</script>
</body>  <br>
    </div>
</div>
<div id='menu2'>
<br>
    {planetmenulist}
<br>
</div>
