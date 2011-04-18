<!--

/**
  * simple_header.tpl
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

-->


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>{title}</title>

<link rel="shortcut icon" href="favicon.ico">
{-style-}

<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
{-meta-}
<script type="text/javascript" src="scripts/overlib.js" ></script>
<script type="text/javascript" src="./scripts/jquery.js" ></script>
<script type="text/javascript" src="./scripts/animatedcollapse.js" ></script>
<script type="text/javascript">
animatedcollapse.addDiv('new0001', 'fade=1,height=auto')
animatedcollapse.addDiv('new0002', 'fade=1,height=auto')
animatedcollapse.addDiv('new0003', 'fade=1,height=auto')
animatedcollapse.addDiv('new0004', 'fade=1,height=auto')
animatedcollapse.addDiv('new0005', 'fade=1,height=auto')
animatedcollapse.addDiv('new0006', 'fade=1,height=auto') 

animatedcollapse.addDiv('new1000', 'fade=1,height=auto')
animatedcollapse.addDiv('new1001', 'fade=1,height=auto')
animatedcollapse.addDiv('new1002', 'fade=1,height=auto')
animatedcollapse.addDiv('new1003', 'fade=1,height=auto')
animatedcollapse.addDiv('new1004', 'fade=1,height=auto')
animatedcollapse.addDiv('new1005', 'fade=1,height=auto')
animatedcollapse.addDiv('new1006', 'fade=1,height=auto')
animatedcollapse.addDiv('new1007', 'fade=1,height=auto')
animatedcollapse.addDiv('new1008', 'fade=1,height=auto')
animatedcollapse.addDiv('new9999', 'fade=1,height=auto')

animatedcollapse.init()
function infodiv(i){

    if(i == 0004){
        animatedcollapse.show('new0004');
    }
    if(i != 0004){
        animatedcollapse.hide('new0004');
    }
    if(i == 0005){
        animatedcollapse.show('new0005');
    }
    if(i != 0005){
        animatedcollapse.hide('new0005');
    }

    if(i == 1000){
        animatedcollapse.show('new1000');
    }
    if(i != 1000){
        animatedcollapse.hide('new1000');
    }
    if(i == 1001){
        animatedcollapse.show('new1001');
    }
    if(i != 1001){
        animatedcollapse.hide('new1001');
    }
    if(i == 1002){
        animatedcollapse.show('new1002');
    }
    if(i != 1002){
        animatedcollapse.hide('new1002');
    }
    if(i == 1003){
        animatedcollapse.show('new1003');
    }
    if(i != 1003){
        animatedcollapse.hide('new1003');
    }
    if(i == 1004){
        animatedcollapse.show('new1004');
    }
    if(i != 1004){
        animatedcollapse.hide('new1004');
    }
    if(i == 1005){
        animatedcollapse.show('new1005');
    }
    if(i != 1005){
        animatedcollapse.hide('new1005');
    }
    if(i == 1006){
        animatedcollapse.show('new1006');
    }
    if(i != 1006){
        animatedcollapse.hide('new1006');
    }
    if(i == 1007){
        animatedcollapse.show('new1007');
    }
    if(i != 1007){
        animatedcollapse.hide('new1007');
    }
    if(i == 9999){
        animatedcollapse.show('new9999');
    }
    if(i != 9999){
        animatedcollapse.hide('new9999');
    }

}

</script>


</head>
<body>

<table cellspacing='0' style='width:100%' cellpadding='0' border='0'>
    <tr><td style='width:100%' colspan='2'>