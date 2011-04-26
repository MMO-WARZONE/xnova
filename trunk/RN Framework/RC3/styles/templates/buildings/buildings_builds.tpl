<br />
<script type="text/javascript" src="./scripts/jquery.js"></script>
<script type="text/javascript" src="./scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('1', 'fade=1,height=auto')
animatedcollapse.addDiv('1-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('2', 'fade=1,height=auto')
animatedcollapse.addDiv('2-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('3', 'fade=1,height=auto')
animatedcollapse.addDiv('3-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('4', 'fade=1,height=auto')
animatedcollapse.addDiv('4-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('12', 'fade=1,height=auto')
animatedcollapse.addDiv('12-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('14', 'fade=1,height=auto')
animatedcollapse.addDiv('14-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('15', 'fade=1,height=auto')
animatedcollapse.addDiv('15-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('21', 'fade=1,height=auto')
animatedcollapse.addDiv('21-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('22', 'fade=1,height=auto')
animatedcollapse.addDiv('22-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('23', 'fade=1,height=auto')
animatedcollapse.addDiv('23-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('24', 'fade=1,height=auto')
animatedcollapse.addDiv('24-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('31', 'fade=1,height=auto')
animatedcollapse.addDiv('31-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('33', 'fade=1,height=auto')
animatedcollapse.addDiv('33-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('34', 'fade=1,height=auto')
animatedcollapse.addDiv('34-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('41', 'fade=1,height=auto')
animatedcollapse.addDiv('41-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('42', 'fade=1,height=auto')
animatedcollapse.addDiv('42-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('43', 'fade=1,height=auto')
animatedcollapse.addDiv('43-cancel', 'fade=1,height=auto')
animatedcollapse.addDiv('44', 'fade=1,height=auto')
animatedcollapse.addDiv('44-cancel', 'fade=1,height=auto')
animatedcollapse.ontoggle=function($, divobj, state){
}
function infodiv(i){
if (i != 1){javascript:animatedcollapse.hide('1');}
if (i != 2){javascript:animatedcollapse.hide('2');}
if (i != 3){javascript:animatedcollapse.hide('3');}
if (i != 4){javascript:animatedcollapse.hide('4');}
if (i != 12){javascript:animatedcollapse.hide('12');}
if (i != 14){javascript:animatedcollapse.hide('14');}
if (i != 15){javascript:animatedcollapse.hide('15');}
if (i != 21){javascript:animatedcollapse.hide('21');}
if (i != 22){javascript:animatedcollapse.hide('22');}
if (i != 23){javascript:animatedcollapse.hide('23');}
if (i != 24){javascript:animatedcollapse.hide('24');}
if (i != 31){javascript:animatedcollapse.hide('31');}
if (i != 33){javascript:animatedcollapse.hide('33');}
if (i != 34){javascript:animatedcollapse.hide('34');}
if (i != 41){javascript:animatedcollapse.hide('41');}
if (i != 42){javascript:animatedcollapse.hide('42');}
if (i != 43){javascript:animatedcollapse.hide('43');}
if (i != 44){javascript:animatedcollapse.hide('44');}
if (i != "1-cancel"){javascript:animatedcollapse.hide('1-cancel');}
if (i != "2-cancel"){javascript:animatedcollapse.hide('2-cancel');}
if (i != "3-cancel"){javascript:animatedcollapse.hide('3-cancel');}
if (i != "4-cancel"){javascript:animatedcollapse.hide('4-cancel');}
if (i != "12-cancel"){javascript:animatedcollapse.hide('12-cancel');}
if (i != "14-cancel"){javascript:animatedcollapse.hide('14-cancel');}
if (i != "15-cancel"){javascript:animatedcollapse.hide('15-cancel');}
if (i != "21-cancel"){javascript:animatedcollapse.hide('21-cancel');}
if (i != "22-cancel"){javascript:animatedcollapse.hide('22-cancel');}
if (i != "23-cancel"){javascript:animatedcollapse.hide('23-cancel');}
if (i != "24-cancel"){javascript:animatedcollapse.hide('24-cancel');}
if (i != "31-cancel"){javascript:animatedcollapse.hide('31-cancel');}
if (i != "33-cancel"){javascript:animatedcollapse.hide('33-cancel');}
if (i != "34-cancel"){javascript:animatedcollapse.hide('34-cancel');}
if (i != "41-cancel"){javascript:animatedcollapse.hide('41-cancel');}
if (i != "42-cancel"){javascript:animatedcollapse.hide('42-cancel');}
if (i != "43-cancel"){javascript:animatedcollapse.hide('43-cancel');}
if (i != "44-cancel"){javascript:animatedcollapse.hide('44-cancel');}
}
animatedcollapse.init()
</script>

<div id="content">
{BuildListScript}
    <table width="60%">
        {BuildList}
        <tr>
            <th colspan="3">
{infodiv}
			</th>
        </tr>
        {BuildingsList}
    </table>
</div>