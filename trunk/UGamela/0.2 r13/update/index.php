<?php  //r47-alliance_dbfix.php :: Arregla la base de datos alliance.

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');


$page = <<<HTML
	  {$lang['Welcome_to_Fix_section']}
	  </th>
	</tr>
	</tr>
	  <td class=l>
If you have a problem, send a mail to <b><font color="#7f7f7f">http://bugs.perberos.com.ar</font></b>. Or use the <a href="http://ugamela.perberos.com.ar/index.php?act=viewforum&f=17" target="_new">forum</a>.<br>
Too, there is a development Mailing List. <b><font color="#7f7f7f">ugamela-devel@lists.sourceforge.net</font></b>
can send a feature request, or another question.<br>
Forum at <a href="http://ugamela.perberos.com.ar/" target="_new">http://ugamela.perberos.com.ar/</a><br>
<br>
<br>
<font color="orange">Fixs</font>:
<lu>
	<li><a href="r47-alliance_dbfix.php">r47-alliance_dbfix</a>
		<font color="#7f7f7f">
			This is a fix of Alliance Request.
		</font>
	</li>
	<li><a href="r47-ranks_id_dbfix.php">r47-ranks_id_dbfix</a>
		<font color="#7f7f7f">
			This is a small fix of Alliance Ranks Users.
		</font>
	</li>
	<li><a href="r48-resources_dbfix.php">r48-resources_dbfix</a>
		<font color="#7f7f7f">
			Add the Income resources default values.
		</font>
	</li>
	<li><a href="r49-resources_porcent_dbfix.php">r49-resources_porcent</a>
		<font color="#7f7f7f">
			Change default values to 10. (Bug)
		</font>
	</li>
	<li><a href="r50-multiplier_addon_dbfix.php">r50-multiplier_addon_dbfix</a>
		<font color="#7f7f7f">
			AddOn to select a resource multiplier.
		</font>
	</li>
	<li><a href="r51-homeplanet_fields_dbfix.php">r51-homeplanet_fields_dbfix</a>
		<font color="#7f7f7f">
			AddOn to select homeplanet's fields initial.
		</font>
	</li>
	<li><a href="r54-energy_used_dbfix.php">r52-energy_used_dbfix</a>
		<font color="#7f7f7f">
			Wrong energy use.
		</font>
	</li>
	<li><a href="r56-reg_random_addon_dbfix.php">r56-reg_random_addon_dbfix</a>
		<font color="#7f7f7f">
			New random position system on registry.
		</font>
	</li>
	<li><a href="r8-rank_addon_dbfix.php">r8-rank_addon_dbfix</a>
		<font color="#7f7f7f">
			Add a few columns to ranks system.
		</font>
	</li>
	<li><a href="r9-alliance_rank_addon_dbfix.php">r9-alliance_rank_addon_dbfix</a>
		<font color="#7f7f7f">
			Add a few columns to alliance ranks system.
		</font>
	</li>
	<li><a href="r13-max_potition_dbfix.php">r13-max_potition_dbfix</a>
		<font color="#7f7f7f">
			AddOn to select max position on solar system.
		</font>
	</li>
</lu>
	</td>
	</tr>
HTML;




message($page,$lang['Fix']);









// Created by Perberos. All rights reversed (C) 2006 
?>
