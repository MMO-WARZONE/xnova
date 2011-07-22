LocalizationStrings = new Array();
LocalizationStrings.timeunits = new Array();
LocalizationStrings.timeunits.short = new Array();
LocalizationStrings.timeunits.short.day = 't';
LocalizationStrings.timeunits.short.hour = 'h';
LocalizationStrings.timeunits.short.minute = 'm';
LocalizationStrings.timeunits.short.second = 's';
LocalizationStrings.status = new Array();

LocalizationStrings.decimalPoint = ",";
LocalizationStrings.thousandSeperator = ".";
LocalizationStrings.unitMega = 'M';
LocalizationStrings.unitKilo = 'K';
LocalizationStrings.unitMilliard = 'Mrd';

function OpenPopup(target_url, win_name, width, height) {
	var new_win = window.open(target_url+'&ajax=1', win_name, 'scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width='+width+',height='+height+',screenX='+((screen.width-width) / 2)+",screenY="+((screen.height-height) / 2)+",top="+((screen.height-height) / 2)+",left="+((screen.width-width) / 2));
	new_win.focus();
}

function allydiplo(action, id, level) {
	if(id != '0')
		var vid = "&id="+id;
	else
		var vid = "";
				
	if(level != '0')
		var vlevel = "&level="+level;
	else
		var vlevel = "";
		
    OpenPopup("game.php?page=alliance&mode=admin&edit=diplo&action="+action+vid+vlevel+"&ajax=1", "diplo", 720, 300);
}
/* BUTTON MAX IN HANGAR BUG IN THIS FUNCTION */
	
	function maxcount(id){
	var metmax = parseInt($('#current_metal').text().replace(/\./g, '')) / parseInt($('#metal_'+id).text().replace(/\./g,""));
	var crymax = parseInt($('#current_crystal').text().replace(/\./g, '')) / parseInt($('#crystal_'+id).text().replace(/\./g,""));
	var deumax = parseInt($('#current_deuterium').text().replace(/\./g, '')) / parseInt($('#deuterium_'+id).text().replace(/\./g,""));
	var noriomax = parseInt($('#current_norio').text().replace(/\./g, '')) / parseInt($('#norio_'+id).text().replace(/\./g,""));
	
	if(isNaN(metmax) && isNaN(crymax) && isNaN(deumax) && isNaN(noriomax))
	{
		return 0;
	}
	
	/*Cuando son tres -- when they are three*/
	else if(isNaN(noriomax) && isNaN(deumax) && isNaN(crymax)) 
	{
		return removeE(Math.floor(metmax));
	}
	else if(isNaN(noriomax) && isNaN(metmax) && isNaN(crymax)) {
		return removeE(Math.floor(deumax));
	}	
	else if(isNaN(noriomax) && isNaN(deumax) && isNaN(metmax)) {
		return removeE(Math.floor(crymax));
	}	
	else if(isNaN(metmax) && isNaN(deumax) && isNaN(crymax)) {
		return removeE(Math.floor(noriomax));
	}
	
	/*Cuando son solo dos -- when they are two*/
	else if(isNaN(metmax) && isNaN(crymax))
	{
		return removeE(Math.floor(deumax, noriomax));
	}
	else if(isNaN(metmax) && isNaN(deumax)) 
	{
		return removeE(Math.floor(crymax, noriomax));
	}
	else if(isNaN(metmax) && isNaN(noriomax)) 
	{
		return removeE(Math.floor(crymax, deumax));
	}
	else if(isNaN(crymax) && isNaN(deumax)) 
	{
		return removeE(Math.floor(metmax, noriomax));
	}
	else if(isNaN(crymax) && isNaN(noriomax)) 
	{
		return removeE(Math.floor(metmax, deumax));
	}
	else if(isNaN(noriomax) && isNaN(deumax)) 
	{
		return removeE(Math.floor(metmax, crymax));
	}
	
	/*Cuando es solo uno -- when only one*/
	else if(isNaN(metmax)) {
		return removeE(Math.floor(Math.min(crymax, deumax, noriomax)));
	}
	else if(isNaN(crymax)) {
		return removeE(Math.floor(Math.min(metmax, deumax, noriomax)));
	}
	else if(isNaN(deumax)) {
		return removeE(Math.floor(Math.min(metmax, crymax, noriomax)));
	}
	else if(isNaN(noriomax)) {
		return removeE(Math.floor(Math.min(metmax, crymax, deumax)));
	}
	else {
		return removeE(Math.floor(Math.min(metmax, Math.min(crymax, Math.min(deumax, noriomax)))));
	} 
	
	/* ORIGINAL FUNCTION */
	/*
	function maxcount(id){
        var metmax = parseInt($('#current_metal').text().replace(/./g, '')) / parseInt($('#metal_'+id).text().replace(/./g,""));
        var crymax = parseInt($('#current_crystal').text().replace(/./g, '')) / parseInt($('#crystal_'+id).text().replace(/./g,""));
        var deumax = parseInt($('#current_deuterium').text().replace(/./g, '')) / parseInt($('#deuterium_'+id).text().replace(/./g,""));
        if(isNaN(metmax) && isNaN(crymax) && isNaN(deumax))
                return 0;
        else if(isNaN(metmax) && isNaN(crymax))
                return removeE(Math.floor(deumax));
        else if(isNaN(metmax) && isNaN(deumax))
                return removeE(Math.floor(crymax));
        else if(isNaN(crymax) && isNaN(deumax))
                return removeE(Math.floor(metmax));
        else if(isNaN(metmax))
                return removeE(Math.floor(Math.min(crymax, deumax)));
        else if(isNaN(crymax))
                return removeE(Math.floor(Math.min(metmax, deumax)));
        else if(isNaN(deumax))
                return removeE(Math.floor(Math.min(metmax, crymax)));
        else
                return removeE(Math.floor(Math.min(metmax, Math.min(crymax, deumax))));
}*/
	
} 