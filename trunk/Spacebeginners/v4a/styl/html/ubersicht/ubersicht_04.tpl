
<!--

/**
  * ubersicht_04.tpl
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

-->

<form action="overview.php?mode=renameplanet&amp;pl={planet_id}" method="POST">

<img src='{dpath}balken/menu_56.png' style='width:500px; height:12px;' alt='' ><table cellspacing='0' cellpadding='0' style='width:500px;'>
    <tr><td class='sb' style='width:100%' align='left'>{over_3005} <img src='./styl/image/pfeile/rechtu.png' alt=''></td></tr>
</table><img src='{dpath}balken/menu_57.png' style='width:500px; height:12px;' alt=''>

<br><br>
<img src='{dpath}balken/menu_56.png' style='width:500px; height:12px;' alt='' ><table cellspacing='0' cellpadding='0' style='width:500px;'>
    <tr><td class='sb' style='width:33%;' align='left'>{over_3007}</td>
        <td class='sb' style='width:33%;' align='left'><input type="password" name="pw"></td>
        <td class='sb' style='width:33%;' align='right'><input type="submit" name="action" value="{over_3006}" alt="{over_2008}">&nbsp;</td></tr>
</table><img src='{dpath}balken/menu_57.png' style='width:500px; height:12px;' alt='' >

<input type="hidden" name="kolonieloeschen" value="1">
<input type="hidden" name="deleteid" value ="{planet_id}">

</form>

<div style='position:absolute; bottom:20px; right:0%; width:150px;' ><a href='./overview.php' >{over_9908}</a></div>
