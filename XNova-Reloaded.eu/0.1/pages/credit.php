<?php

/**
 * stat.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

	includeLang('credit');

	$parse   = $lang;

	display(parsetemplate(gettemplate('credit_body'), $parse), $lang['cred_credit'], false);
?>