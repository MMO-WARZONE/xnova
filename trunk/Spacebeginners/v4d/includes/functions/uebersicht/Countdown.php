<?php

/**
  * Countdown.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

/* Korrektur: meikel */

function countdown($typ, $resttime) {
    $script = sprintf('
    <span class="actions_text" id="countDown%1$sText">
	</span>
    <script type="text/javascript">
	    var countDown%1$s = %2$s;
	    var timestamp%1$s = countDown%1$s;
	    function countDown_'.$typ.'() {
	        sekunden = timestamp%1$s;
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

	        var bt = "%1$s"=="epoche"?"":"";
	        monate = (monate > 0) ? monate+" m " : "";
	        tage = (tage > 0) ? tage+" t " : "";
	        stunden = (stunden > 0) ? stunden+":" : "";
	        minuten = (minuten > 0) ? minuten+":" : "00:";
	        sekunden = (sekunden > 0) ? sekunden : "00";
	        text = bt + monate+tage+stunden+minuten+sekunden;

	        if (timestamp%1$s < 1) {
	            document.getElementById("countDown%1$sText").innerHTML = "Fertig!";
	            return;
	        } else {
	            timestamp%1$s--;
	            document.getElementById("countDown%1$sText").innerHTML = text;
	            setTimeout("countDown_%1$s()", 1000);
	        }
	    }

	    countDown_'.$typ.'();
	    </script>
'		, $typ, $resttime);

    return $script;
}
?>