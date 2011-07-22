<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

	function SendSimpleMessage ( $Owner, $Sender, $Time, $Type, $From, $Subject, $Message)
	{

		if ($Time == '')
		{
			$Time = time();
		}

		$Message = (strpos($Message, "/adm/") === false ) ? $Message : "";

		$QryInsertMessage  = "INSERT INTO {{table}} SET ";
		$QryInsertMessage .= "`message_owner` = '". $Owner ."', ";
		$QryInsertMessage .= "`message_sender` = '". $Sender ."', ";
		$QryInsertMessage .= "`message_time` = '" . $Time . "', ";
		$QryInsertMessage .= "`message_type` = '". $Type ."', ";
$QryInsertMessage .= "`message_from` = '". mysql_real_escape_string($From) ."', "; 
        $QryInsertMessage .= "`message_subject` = '".  mysql_real_escape_string($Subject) ."', "; 
        $QryInsertMessage .= "`message_text` = '". mysql_real_escape_string($Message) ."';"; 
        doquery( $QryInsertMessage, 'messages'); 
 

		$QryUpdateUser  = "UPDATE `{{table}}` SET ";
		$QryUpdateUser .= "`new_message` = `new_message` + 1 ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $Owner ."';";
		doquery($QryUpdateUser, "users");
	}

?>