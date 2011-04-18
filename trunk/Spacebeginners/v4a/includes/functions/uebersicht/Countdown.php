<?

/**
  * Countdown.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function countdown($typ, $resttime) {
    $script = '

    <span class="actions_text" id="countDown'.$typ.'Text"></span>
    <script type="text/javascript">

    var countDown'.$typ.' = '.$resttime.';
    var timestamp'.$typ.'=countDown'.$typ.';
    function countDown_'.$typ.'() {
        sekunden = timestamp'.$typ.';
        monate = Math.floor(sekunden/2419200);
        sekunden-=monate*2419200;

        tage = Math.floor(sekunden/86400);
        sekunden-=tage*86400;

        stunden=Math.floor(sekunden/3600);
        sekunden-=stunden*3600;

        minuten=Math.floor(sekunden/60);
        sekunden-=minuten*60;

        if(stunden < 10) stunden = "0"+stunden;

        if(sekunden < 10) sekunden = "0"+sekunden;

        if(minuten < 10) minuten = "0"+minuten;

        var bt = "'.$typ.'"=="epoche"?"":"";
        monate = (monate > 0) ? monate+" m " : "";
        tage = (tage > 0) ? tage+" t " : "";
        stunden = (stunden > 0) ? stunden+":" : "";
        minuten = (minuten > 0) ? minuten+":" : "00:";
        sekunden = (sekunden > 0) ? sekunden : "00";
        text = bt + monate+tage+stunden+minuten+sekunden;

        if (timestamp'.$typ.' < 1) {
            document.getElementById("countDown'.$typ.'Text").innerHTML = "Fertig!";
            return;
        } else {
            timestamp'.$typ.'--;
            document.getElementById("countDown'.$typ.'Text").innerHTML = text;
            setTimeout("countDown_'.$typ.'()", 1000);
        }
    }

    countDown_'.$typ.'();
    </script>';

    return $script;
}
?>