
/*******************************************************************************************************
*
*		german UGamela (C) 2008
*		OpenSource aslong as you don't remove our Copyright
*		Licence GNU (GPL)
*		http://ugamela-forum.pheelgood.net
*		clock by Phlegma on 29.01.2008
*
*******************************************************************************************************/

var ZeitString, DatumsString = "";

function ZeitDatum () { //http://www.rz.uni-hohenheim.de/www/lernhilfen/JavaScript/beispiele/uhr.html
        Jetzt = new Date();
       
        // aktuelles Datum
        Tag = Jetzt.getDate();
        Monat = Jetzt.getMonth()+1;
        
		Jahr = Jetzt.getFullYear();
        DatumsString = ((Tag<10) ? "0" : "") + Tag;
        DatumsString += ((Monat<10) ? ".0" : ".") + Monat;
        DatumsString += "." + Jahr;
        
        //document.Uhr.Datum.value = DatumsString;

        //aktuelle Uhrzeit
        Stunden = Jetzt.getHours();
        Minuten = Jetzt.getMinutes();
        Sekunden = Jetzt.getSeconds();
        ZeitString = ((Stunden<10) ? "0" : "") + Stunden;
        ZeitString += ((Minuten < 10) ? ":0" : ":") + Minuten;
        ZeitString += ((Sekunden < 10) ? ":0" : ":") + Sekunden;
        
        //document.Uhr.Zeit.value = ZeitString;
        
        // modification here
        document.getElementById('time').innerHTML = ZeitString;

        setTimeout("ZeitDatum()", 1000);
}