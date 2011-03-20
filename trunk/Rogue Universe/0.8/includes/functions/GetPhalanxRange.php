<?php

function GetPhalanxRange ( $PhalanxLevel ) {
	// Level                       1  2  3  4  5  6  7  = lvl
	// range                0  3  5  7  9 11 13  = (lvl * 2) - 1
	// phalanx nr systems  0  3  8 15 24 35 48  =
	$PhalanxRange = 0;
	if ($PhalanxLevel > 1) {
		for ($Level = 2; $Level < $PhalanxLevel + 1; $Level++) {
			$lvl           = ($Level * 2) - 1;
			$PhalanxRange += $lvl;
		}
	}
	return $PhalanxRange;
}
?>