<?php

/**
 * strings.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

if (!defined('INSIDE'))
{
   die();
}  
 
function colorNumber($n, $s = '') {
	if ($n > 0) {
		if ($s != '') {
			$s = colorGreen($s);
		} else {
			$s = colorGreen($n);
		}
	} elseif ($n < 0) {
		if ($s != '') {
			$s = colorRed($s);
		} else {
			$s = colorRed($n);
		}
	} else {
		if ($s != '') {
			$s = $s;
		} else {
			$s = $n;
		}
	}
	return $s;
}

function colorRed($n) {
	return '<font color="#ff0000">' . $n . '</font>';
}

function colorGreen($n) {
	return '<font color="#00ff00">' . $n . '</font>';
}

function pretty_number($n, $floor = true) {
	if ($floor) {
		$n = floor($n);
	}
	return number_format($n, 0, ",", ".");
}
// round to zero example -123.7 to -123 or 123.7 to 123
// function included by Mori (c) 2009 for Xnova

function zround($n) {
	if ($n < 0) {
    $n = ceil($n);  }
  else { 
    $n = floor($n); }
	return $n;
}
// Created by Perberos. All rights reversed (C) 2006
?>