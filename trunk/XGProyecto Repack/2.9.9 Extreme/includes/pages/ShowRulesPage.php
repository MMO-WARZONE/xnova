<?php
#*******************************************************************************
#** Nome                   : Rules Page
#** Autor                    : nkrsystem
#** Descrição            : Pagina de regras.                            
#** Versão                  : 1 
#******************************************************************************** ?
if(!defined('INSIDE')){ die(header("location:../../"));}
 
display(parsetemplate(gettemplate('rules'), $parse));
?> 