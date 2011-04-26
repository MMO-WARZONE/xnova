<?php // logout.php :: Establece el tiempo de expiración de las cookies.

include("common.php");

setcookie('ogamela', "", time()-100000, "/", "", 0);//le da el expire

message('Esperamos volver a verte pronto por aqu&iacute;. El Staff',"Sesi&oacute;n cerrada","login");

// Created by Perberos. All rights reversed (C) 2006
?>