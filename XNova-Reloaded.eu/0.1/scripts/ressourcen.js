function format(zahl)
{
	var zahl;
	var temp1;
	var temp2;
	var temp3;
	var output = "";
	max[0]--;
	
	if(zahl >= 1000000)
	{
		temp1 = Math.floor(zahl / 1000000);
		output += "" + temp1 + ".";
		temp2 = Math.floor((zahl - (temp1 * 1000000)) / 1000) + "";
		if(temp2.length == 1)
		{
			output += "00" + temp2 + ".";
		}
		else if(temp2.length == 2)
		{
			output += "0" + temp2 + ".";
		}
		else
		{
			output += "" + temp2 + ".";
		}
		temp3 = Math.floor(zahl - (temp1 * 1000000) - (temp2 * 1000)) + "";
		if(temp3.length == 1)
		{
			output += "00" + temp3 + "";
		}	
		else if(temp3.length == 2)
		{
			output += "0" + temp3 + "";
		}
		else
		{
			output += "" + temp3 + "";
		}
	}
	else if(zahl >= 1000)
	{
		temp1 = Math.floor(zahl / 1000);
		output += "" + temp1 + ".";
		temp2 = Math.floor(zahl - (temp1 * 1000)) + "";
		if(temp2.length == 1)
		{
			output += "00" + temp2 + "";
		}
		else if(temp2.length == 2)
		{
			output += "0" + temp2 + "";
		}
		else
		{
			output += "" + temp2 + "";
		}
	}
	else
	{
		output = zahl;
	}
	return output;
}

function count()
{
	var metall = 0;
	var kristall = 0;
	var deuterium = 0;
	var bold1_met = '';
	var bold2_met = '';
	var bold1_kris = '';
	var bold2_kris = '';
	var bold1_deut = '';
	var bold2_deut = '';
	var faktor_met = speed; //hier die Speedwerte der Produ eintragen
	var faktor_kris = speed;
	var faktor_deut = speed;
	var ges_met = production[0];
	var ges_kris = production[1];
	var ges_deut = production[2];
	var rohstoffe = document.getElementById('ress');
	
	//Werte für Metall
	if(rohstoffe.metall.value >= max[0] || rohstoffe.bmetall.value == 1 || ress[0] >= max[0]) {
		bold1_met = '<font color=red>';
		bold2_met = '</font>';
		rohstoffe.bmetall.value = 1;
		if(rohstoffe.metall.value >= max[0]) faktor_met = 0;
	}
	metall = Math.floor(rohstoffe.metall.value) + Math.floor(ress[0]);
	rohstoffe.metall.value = (Math.floor(rohstoffe.metall.value * 10000)/10000) + (ges_met * faktor_met);
	
	//Werte für Kristall
	if(rohstoffe.kristall.value >= max[1] || rohstoffe.bkristall.value == 1 || ress[1] >= max[1]) {
		bold1_kris = '<font color=red>';
		bold2_kris = '</font>';
		rohstoffe.bkristall.value = 1;
		if(rohstoffe.metall.value >= max[1]) faktor_kris = 0;
	}
	kristall = Math.floor(rohstoffe.kristall.value) + Math.floor(ress[1]);
	rohstoffe.kristall.value = (Math.floor(rohstoffe.kristall.value * 10000)/10000) + (ges_kris * faktor_kris);
	
	//Werte für Deut
	if(rohstoffe.deuterium.value >= max[2] || rohstoffe.bdeuterium.value == 1 || ress[2] >= max[2]) {
		bold1_deut = '<font color=red>';
		bold2_deut = '</font>';
		rohstoffe.bdeuterium.value = 1;
		if(rohstoffe.metall.value >= max[2]) faktor_deut = 0;
	}
	deuterium = Math.floor(rohstoffe.deuterium.value) + Math.floor(ress[2]);
	rohstoffe.deuterium.value = (Math.floor(rohstoffe.deuterium.value * 10000)/10000) + (ges_deut * faktor_deut);
	
	
	if(metall < 0) metall = 0;
	if(kristall < 0) kristall = 0;
	if(deuterium < 0) deuterium = 0;

	
    if(document.getElementById('roh') && document.getElementById('met') && document.getElementById('kry'))
    {
    	document.getElementById('roh').innerHTML = bold1_met+format(metall)+bold2_met;
    	document.getElementById('met').innerHTML = bold1_kris+format(kristall)+bold2_kris;
    	document.getElementById('kry').innerHTML = bold1_deut+format(deuterium)+bold2_deut;
    }
    if(document.layers)
    {
    	document.getElementById('roh').document.write(bold1_met+format(metall)+bold2_met);
    	document.getElementById('roh').document.close();
    	document.getElementById('met').document.write(bold1_kris+format(kristall)+bold2_kris);
    	document.getElementById('met').document.close();
    	document.getElementById('kry').document.write(bold1_deut+format(deuterium)+bold2_deut);
    	document.getElementById('kry').document.close();
    }
	
}

if (stopped==0) {
	window.setInterval("count()",1000);
}

