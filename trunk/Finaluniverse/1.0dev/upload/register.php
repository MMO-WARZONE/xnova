<?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 die('ge')?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict //EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<div id="main">

  <div id="navi" style="position: absolute; left: 627px; top: 134px; width: 132px; height: 334px">
    <div class="menu"></div>
    <a target="_self" href="home.htm">
      <img border="0" src="images/b_01_nonact.png" alt="Login" name="navi01" id="navi01" onmouseover="document.getElementById('navi01').src='images/b_01_act.png';" onmouseout="document.getElementById('navi01').src='images/b_01_nonact.png';" width="132" height="65" style="position: absolute; left: 0px; top: 0px">
    </a>
    <a target="_self" href="info.htm">
	  <img border="0" src="images/b_02_nonact.png" alt="Mehr Informationen" name="navi02" id="navi02" onmouseover="document.getElementById('navi02').src='images/b_02_act.png';" onmouseout="document.getElementById('navi02').src='images/b_02_nonact.png';" width="132" height="65" style="position: absolute; left: 0px; top: 67px">
	</a>
      <img border="0" src="images/b_03_act.png" width="132" height="65" style="position: absolute; left: 0px; top: 134px">
    <a target="_self" href="gallery.htm">
      <img border="0" src="images/b_04_nonact.png" alt="Video und Screenshots" name="navi04" id="navi04" onmouseover="document.getElementById('navi04').src='images/b_04_act.png';" onmouseout="document.getElementById('navi04').src='images/b_04_nonact.png';" width="132" height="65" style="position: absolute; left: 0px; top: 201px">
	</a>
    <a target="_self" href="communication.htm">
      <img border="0" src="images/b_05_nonact.png" alt="Forum und IRC" name="navi05" id="navi05" onmouseover="document.getElementById('navi05').src='images/b_05_act.png';" onmouseout="document.getElementById('navi05').src='images/b_05_nonact.png';" width="132" height="65" style="position: absolute; left: 0px; top: 268px">
    </a>
    <td style="padding-top:0px;">
  </div>






  <div id="contentbox" class="contentbox" style="position: absolute; left: 290px; top: 135px; height: 332px; width:331px">

    <div id="title">Registrierung (enthält Forum-Registrierung!)</div>
    <div id="content1" style="position: absolute; left: 10px; top: 50px; width: 313px">
     <form class="registrationForm" name="registrationForm" action="http://lw.kippel.org/forum/index.php?action=WOTUserRegistration" method="post">
      		<?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 if(isset($_REQUEST['error'])) { ?>
      		<p style="color: #f00;"><?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 echo htmlspecialchars($_REQUEST['error']); ?></p>
      		<?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 } ?>      		
      		<p><span>Nickname: </span><input type="text" name="username" size="15" maxlength="15" value="<?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 if(isset($_REQUEST['username'])) echo htmlspecialchars($_REQUEST['username']);?>" /></p>
      		<p><span>Passwort: </span><input type="password" name="password" size="15" /></p>
      		<p><span>Passwort wiederholen: </span><input type="password" name="confirmPassword" size="15" /></p>
      		<p><span>E-Mail-Adresse: </span><input type="text" name="email" size="15" value="<?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 if(isset($_REQUEST['email'])) echo htmlspecialchars($_REQUEST['email']);?>" /></p>
      		<input type="hidden" name="serverID" value="2" />
      		<input type="hidden" name="successSite" value="<?php
/*
  This file is part of WOT Game.

    WOT Game is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WOT Game is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with WOT Game.  If not, see <http://www.gnu.org/licenses/>.
*/
 echo isset($_REQUEST['successSite']) ? htmlspecialchars($_REQUEST['successSite']) : "http://lw.kippeln.org/login.php"; ?>" />
      		<input type="hidden" name="failSite" value="http://lw.kippeln.org/register.php" />
      		<input type="submit" value="Abschicken" />
      	</form>
      	<!--div id="registerbutton">
        <a target="_blank" href="">
        <img border="0" src="images/registerbutton_nonact.png" alt="Registrieren" name="registerbutton" id="regbutton" onmouseover="document.getElementById('regbutton').src='images/registerbutton_act.png';" onmouseout="document.getElementById('regbutton').src='images/registerbutton_nonact.png';">
      	</a>
      </div-->
    </div>

  </div>





  <div id="downmenu" style="position: absolute; left: 641px; top: 571px">
    <a target="_blank" href="agb.htm">AGB</a>
    &nbsp; &#9679; &nbsp;
  </div>

</div>


</body>
</html>