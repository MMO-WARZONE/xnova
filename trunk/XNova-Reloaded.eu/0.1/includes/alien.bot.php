<?php
/** 
 * @authors 		gianluca311, Steggi
 * @filename 		alien.bot.php
 * @project			xnova-reloaded.de
 * @version			0.1
 */

class alien {
	
	protected $galaxy;
	protected $system;
	protected $planet;
	
	/* bot starts here*/
	public function __construct() {	
	}
	
	protected function get_target () {
		$g = round(rand(1,9));
		$s = round(rand(1,499));
		$p = round(rand(1,15));
		$Query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE `galaxy` = '".$g."' AND `system` = '".$s."' AND `planet` = '".$p."';");
		$PlanetExist = $Query->fetch();
		if($PlanetExist) {
			$kord_array = array($g,$s,$p);
			$kords = implode(',', $kord_array);
			return $kords;
		}
		else {
		
		}
	}
}
?>