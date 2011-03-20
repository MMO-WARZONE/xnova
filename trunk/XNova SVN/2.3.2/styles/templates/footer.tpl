<script>
messageboxHeight=0;
errorboxHeight=0;
contentbox = document.getElementById('content');
</script>

<div id='messagebox'>
<center>
</center>
</div>
<div id='errorbox'>
<center>
  
</center>
</div>
<script>
headerHeight = 71;
errorbox.style.top=parseInt(headerHeight+messagebox.offsetHeight+5)+'px';
contentbox.style.top=parseInt(headerHeight+errorbox.offsetHeight+messagebox.offsetHeight+10)+'px';

contentbox.style.height=parseInt(window.innerHeight)-messagebox.offsetHeight-errorbox.offsetHeight-headerHeight-30;


</script>
</body>
<html>