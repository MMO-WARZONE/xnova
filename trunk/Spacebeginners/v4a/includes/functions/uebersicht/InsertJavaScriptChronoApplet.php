<?php

/**
  * InsertJavaScriptChronoApplet.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function InsertJavaScriptChronoApplet ( $Type, $Ref, $Value, $Init ) {
        if ($Init == true) {
                $JavaString  = "

<script type=\"text/javascript\">
function t". $Type . $Ref ."() {
    v = new Date();
    var bxx". $Type . $Ref ." = document.getElementById('bxx". $Type . $Ref ."');
    n = new Date();
    ss". $Type . $Ref ." = pp". $Type . $Ref .";
    ss". $Type . $Ref ." = ss". $Type . $Ref ." - Math.round((n.getTime() - v.getTime()) / 1000.);
    m". $Type . $Ref ." = 0;
    h". $Type . $Ref ." = 0;

    if (ss". $Type . $Ref ." < 0) {
        bxx". $Type . $Ref .".innerHTML = \"-\";
    } else {

        if (ss". $Type . $Ref ." > 59) {
            m". $Type . $Ref ." = Math.floor(ss". $Type . $Ref ." / 60);
            ss". $Type . $Ref ." = ss". $Type . $Ref ." - m". $Type . $Ref ." * 60;
        }

        if (m". $Type . $Ref ." > 59) {
            h". $Type . $Ref ." = Math.floor(m". $Type . $Ref ." / 60);
            m". $Type . $Ref ." = m". $Type . $Ref ." - h". $Type . $Ref ." * 60;
        }

        if (ss". $Type . $Ref ." < 10) {
            ss". $Type . $Ref ." = \"0\" + ss". $Type . $Ref .";
        }

        if (m". $Type . $Ref ." < 10) {
            m". $Type . $Ref ." = \"0\" + m". $Type . $Ref .";
        }

        bxx". $Type . $Ref .".innerHTML = h". $Type . $Ref ." + \":\" + m". $Type . $Ref ." + \":\" + ss". $Type . $Ref .";
    }

    pp". $Type . $Ref ." = pp". $Type . $Ref ." - 1;
    window.setTimeout(\"t". $Type . $Ref ."();\", 999);
}
</script>\n";
        } else {
                $JavaString  = "
<script type=\"text/javascript\">
pp". $Type . $Ref ." = ". $Value .";
t". $Type . $Ref ."();
</script>\n";
        }

        return $JavaString;
}

?>