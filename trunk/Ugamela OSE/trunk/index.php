<?php
/*
 * Ugamela OSE
 * index.php - Pagina inicial
 * Last Revition: 2009.05.03 01:33 (GMT - 03:00)
 *
 * Copyright (C) Perberos (German Augusto Perugorria)
 * Copyright (C) Matsusoft Corporation
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 ******************************************************************************/
define('INSIDE', true);

$ugamela_root_path = './';
require $ugamela_root_path.'extension.inc';
require $ugamela_root_path.'common.'.$phpEx;

if (!user_check())
{
	header('Location: login.php');
}
else
{
	echo template_parse(template_get('index_frames'), $lang);
}

?>
