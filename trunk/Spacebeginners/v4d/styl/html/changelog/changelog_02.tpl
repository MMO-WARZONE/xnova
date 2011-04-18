
<script type="text/javascript">
function f(target_url,win_name) {
    var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
    new_win.focus();
}

zaehler=0;
text='';
last='';
function showDIV( elementID,inout ) {

    if (inout=='in') {
        displayType = ( document.getElementById( elementID ).style.display == 'none' ) ? 'block' : 'none';
        document.getElementById( elementID ).style.display = displayType;
        visibilityType = ( document.getElementById( elementID ).style.visibility == 'hidden' ) ? 'visible' : 'hidden';
        document.getElementById( elementID ).style.visibility = visibilityType;

        if (document.getElementById( last )) {
            displayType = ( document.getElementById( last ).style.display == 'none' ) ? 'block' : 'none';
            document.getElementById( last ).style.display = displayType;
            visibilityType = ( document.getElementById( last ).style.visibility == 'hidden' ) ? 'visible' : 'hidden';
            document.getElementById( last ).style.visibility = visibilityType;
        }
        last = elementID;
    }else {
        document.getElementById( last ).style.display = 'none';
        document.getElementById( last ).style.visibility = 'hidden';
        last='';
    }
}
</script>

<table style='width:800px;' cellspacing='0' >
    <tr><td style='width:250px;' valign='top'>

            <img src='{dpath}balken/menu_54.png' style='width:250px; height:12px;' alt=''><table style='width:250px;' cellspacing="0" >
                <tr><td class='sb' align='center' style='width:100%; cursor:pointer;' ><div style="text-align:left;  float:left;">- {name}: {version_number} </div>
                                                                                       <div style="text-align:right; float:right;" onclick="javascript:showDIV('{version_number}','in')"><font color="red"> + </font></div></td></tr>
            </table><img src='{dpath}balken/menu_55.png' style='width:250px; height:12px;' alt=''>

       </td><td style='width:550px;' valign='top'>

            <div id="{version_number}" style="visibility:hidden; display:none;">

                <img src='{dpath}balken/menu_56.png' style='width:540px; height:12px;' alt=''><table style='width:540px;' cellspacing='0' >
                    <tr><td style='width:100%;' class='sb' align='center'>{description}</td></tr>
                </table><img src='{dpath}balken/menu_57.png' style='width:540px; height:12px;' alt=''>

            </div>

    </td></tr>
</table>