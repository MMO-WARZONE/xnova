<?php


if(!defined('INSIDE')){ die("attemp hacking");}

// Requerimientos
{$requeriments = array(
//Edificios
12 => array(3=>5,113=>3),
15 => array(14=>10,108=>10),
21 => array(14=>2),
33 => array(15=>1,113=>12),
//Tecnologias
106 => array(31=>3),
108 => array(31=>1),
109 => array(31=>4),
110 => array(113=>3,31=>6),
111 => array(31=>2),
113 => array(31=>1),
114 => array(113=>5,110=>5,31=>7),
115 => array(113=>1,31=>1),
117 => array(113=>1,31=>2),
118 => array(114=>3,31=>7),
120 => array(31=>1,113=>2),
121 => array(31=>4,120=>5,113=>4),
122 => array(31=>5,113=>8,120=>10,121=>5),
123 => array(31=>10,108=>8,114=>8),
199 => array(31=>12),
//Naves espaciales
202 => array(21=>2,115=>2),
203 => array(21=>4,115=>6),
204 => array(21=>1,115=>1),
205 => array(21=>3,111=>2,117=>2),
206 => array(21=>5,117=>4,121=>2),
207 => array(21=>7,118=>4),
208 => array(21=>4,117=>3),
209 => array(21=>4,115=>6,110=>2),
210 => array(21=>3,115=>3,106=>2),
211 => array(117=>6,21=>8,122=>5),
212 => array(21=>1),
213 => array(21=>9,118=>6,114=>5),
214 => array(21=>12,118=>7,114=>6,199=>1),
//Sistemas de defensa
401 => array(21=>1),
402 => array(113=>1,21=>2,120=>3),
403 => array(113=>3,21=>4,120=>6),
404 => array(21=>6,113=>6,109=>3,110=>1),
405 => array(21=>4,121=>4),
406 => array(21=>8,122=>7),
407 => array(110=>2,21=>1),
408 => array(110=>6,21=>6),
502 => array(44=>2),
503 => array(44=>4),
//Construcciones especiales
42 => array(41=>1),
43 => array(41=>1,114=>7)
);}

{$pricelist = array(

1 => array('metal'=>40,'crystal'=>10,'deuterium'=>0,'energy'=>0,'factor'=>3/2,"description"=>"Las minas de metal proveen los recursos bჩcos de un imperio emergente, y permiten la construcci゠de edificios y naves."),
2 => array('metal'=>30,'crystal'=>15,'deuterium'=>0,'energy'=>0,'factor'=>1.6,"description"=>"Los cristales son el recurso principal usado para construir circuitos electrォcos y ciertas aleaciones."),
3 => array('metal'=>150,'crystal'=>50,'deuterium'=>0,'energy'=>0,'factor'=>3/2,"description"=>"El deuterio se usa como combustible para naves, y se recolecta en el mar profundo. Es una sustancia muy escasa, y por ello, relativamente cara."),
4 => array('metal'=>50,'crystal'=>20,'deuterium'=>0,'energy'=>0,'factor'=>3/2,"description"=>"Las plantas de energ큠solar convierten energ큠fotォca en energ큠el郴rica, para su uso en casi todos los edificios y estructuras."),
12 => array('metal'=>500,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>1.8,"description"=>"Un reactor de fusi゠nuclear que produce un ုmo de helio a partir de dos ုmos de deuterio usando una presi゠extremadamente alta y una elevad탩ma temperatura."),
14 => array('metal'=>200,'crystal'=>60,'deuterium'=>100,'energy'=>0,'factor'=>2,"description"=>"Las fႲicas de robots proporcionan unidades baratas y de fჩl construcci゠que pueden ser usadas para mejorar o construir cualquier estructura planetaria. Cada nivel de mejora de la fႲica aumenta la eficiencia y el numero de unidades rob〩cas que ayudan en la construcciギ"),
15 => array('metal'=>500000,'crystal'=>250000,'deuterium'=>50000,'energy'=>0,'factor'=>2,"description"=>"La fႲica de nanobots es la ꀴima evoluci゠de la rob〩ca. Cada mejora proporciona nanobots mრy mრeficientes que incrementan la velocidad de construcciギ"),
21 => array('metal'=>200,'crystal'=>100,'deuterium'=>50,'energy'=>0,'factor'=>2,"description"=>"El hangar es el lugar donde se construyen naves y estructuras de defensa planetaria."),
22 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Almac邠de metal sin procesar."),
23 => array('metal'=>1000,'crystal'=>500,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Almac邠de cristal sin procesar."),
24 => array('metal'=>1000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Contenedores enormes para almacenar deuterio."),
31 => array('metal'=>100,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>2,"description"=>"Se necesita un laboratorio de investigaci゠para conducir la investigaci゠en nuevas tecnolog큳."),
33 => array('metal'=>0,'crystal'=>25000,'deuterium'=>5000,'energy'=>500,'factor'=>2,"description"=>"El Terraformer es necesario para habilitar Ⴅas inaccesibles de tu planeta para edificar infraestructuras."),
34 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"El depラto de la alianza ofrece la posibilidad de repostar a las flotas aliadas que est邠estacionadas en la アita ayudando a defender."),
44 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>500,'energy'=>0,'factor'=>2,"description"=>"El silo es un lugar de almacenamiento y lanzamiento de misiles planetarios."),
//Tecnologias
106 => array('metal'=>200,'crystal'=>1000,'deuterium'=>200,'energy'=>0,'factor'=>2,"description"=>"Usando esta tecnolog크 puede obtenerse informaci゠sobre otros planetas."),
108 => array('metal'=>0,'crystal'=>400,'deuterium'=>600,'energy'=>0,'factor'=>2,"description"=>"Cuanto mრelevado sea el nivel de tecnolog큠de computaciガ mრflotas podrრcontrolar simultaneamente. Cada nivel adicional de esta tecnologia, aumenta el numero de flotas en 1."),
109 => array('metal'=>800,'crystal'=>200,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Este tipo de tecnolog큠incrementa la eficiencia de tus sistemas de armamento. Cada mejora de la tecnolog큠militar aၤe un 10% de potencia a la base de daრde cualquier arma disponible."),
110 => array('metal'=>200,'crystal'=>600,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"La tecnolog큠de defensa se usa para generar un escudo de part탵las protectoras alrededor de tus estructuras. Cada nivel de esta tecnolog큠aumenta el escudo efectivo en un 10% (basado en el nivel de una estructura dada)."),
111 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Las aleaciones altamente sofisticadas ayudan a incrementar el blindaje de una nave aၤiendo el 10% de su fuerza en cada nivel a la fuerza base."),
113 => array('metal'=>0,'crystal'=>800,'deuterium'=>400,'energy'=>0,'factor'=>2,"description"=>"Entendiendo la tecnolog큠de diferentes tipos de energ크 muchas investigaciones nuevas y avanzadas pueden ser adaptadas. La tecnolog큠de energ큠es de gran importancia para un laboratorio de investigaci゠moderno."),
114 => array('metal'=>0,'crystal'=>4000,'deuterium'=>2000,'energy'=>0,'factor'=>2,"description"=>"Incorporando la cuarta y quinta dimensi゠en la tecnolog큠de propulsiガ se puede disponer de un nuevo tipo de motor; que es mრeficiente y usa menos combustible que los convencionales."),
115 => array('metal'=>400,'crystal'=>0,'deuterium'=>600,'energy'=>0,'factor'=>2,"description"=>"Ejecutar investigaciones en esta tecnolog큠proporciona motores de combusti゠siempre mრrapido, aunque cada nivel aumenta solamente la velocidad en un 10% de la velocidad base de una nave dada."),
117 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>6000,'energy'=>0,'factor'=>2,"description"=>"El sistema del motor de impulso se basa en el principio de la repulsi゠de part탵las. La materia repelida es basura generada por el reactor de fusi゠usado para proporcionar la energ큠necesaria para este tipo de motor de propulsiギ"),
118 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>6000,'energy'=>0,'factor'=>2,"description"=>"Los motores de hiperespacio permiten entrar al mismo a trav郠de una ventana hiperespacial para reducir drჴicamente el tiempo de viaje. El hiperespacio es un espacio alternativo con mრde 3 dimensiones."),
120 => array('metal'=>200,'crystal'=>100,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"La tecnolog큠lქr es un importante conocimiento; conduce a la luz monocromဩca firmemente enfocada sobre un objetivo. El daრpuede ser ligero o moderado dependiendo de la potencia del rayo..."),
121 => array('metal'=>1000,'crystal'=>300,'deuterium'=>100,'energy'=>0,'factor'=>2,"description"=>"La tecnolog큠iォca enfoca un rayo de iones acelerados en un objetivo, lo que puede provocar un gran daრdebido a su naturaleza de electrones cargados de energ큮"),
122 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>1000,'energy'=>0,'factor'=>2,"description"=>"Las armas de plasma son incluso mრpeligrosas que cualquier otro sistema de armamento conocido, debido a la naturaleza agresiva del plasma"),
123 => array('metal'=>240000,'crystal'=>400000,'deuterium'=>160000,'energy'=>0,'factor'=>2,"description"=>"Los cient킩cos de tus planetas pueden comunicarse entre ellos a trav郠de esta red."),
199 => array('metal'=>0,'crystal'=>0,'deuterium'=>0,'energy'=>300000,'factor'=>3,"description"=>"A trav郠del disparo de part탵las concentradas de gravit゠se genera un campo gravitacional artificial con suficiente potencia y poder de atracci゠para destruir no solo naves, sino lunas enteras."),
//Naves espaciales
202 => array('metal'=>2000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'consumption'=>20,'speed'=>28000,'capacity'=>5000,'name'=>"Nave pequeၠde carga",'description'=>"Las naves pequeၳ de carga son naves muy ჩles usadas para transportar recursos desde un planeta a otro."),
203 => array('metal'=>6000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,'consumption'=>50,'speed'=>17250,'capacity'=>25000,'name'=>"Nave grande de carga",'description'=>"La nave grande de carga es una versi゠avanzada de las naves pequeၳ de carga, permitiendo as퀵na mayor capacidad de almacenamiento y velocidades mრaltas gracias a un mejor sistema de propulsiギ"),
204 => array('metal'=>3000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'consumption'=>20,'speed'=>28750,'capacity'=>50,'name'=>"Cazador ligero",'description'=>"El cazador ligero es una nave maniobrable que puedes encontrar en casi cualquier planeta. El coste no es particularmente alto, pero asimismo el escudo y la capacidad de carga son muy bajas."),
205 => array('metal'=>6000,'crystal'=>4000,'deuterium'=>0,'energy'=>0,'consumption'=>75,'speed'=>28000,'capacity'=>100,'name'=>"Cazador pesado",'description'=>"El cazador pesado es la evoluci゠logica del ligero, ofreciendo escudos reforzados y una mayor potencia de ataque."),
206 => array('metal'=>20000,'crystal'=>7000,'deuterium'=>2000,'energy'=>0,'consumption'=>300,'speed'=>42000,'capacity'=>800,'name'=>"Crucero",'description'=>"Los cruceros de combate tienen un escudo casi tres veces mრfuerte que el de los cazadores pesados y mრdel doble de potencia de ataque. Su velocidad de desplazamiento estဴambi邠entre las mრrဩdas jamრvista."),
207 => array('metal'=>40000,'crystal'=>20000,'deuterium'=>0,'energy'=>0,'consumption'=>500,'speed'=>31000,'capacity'=>1500,'name'=>"Nave de batalla",'description'=>"Las naves de batalla son la espina dorsal de cualquier flota militar. Blindaje pesado, potentes sistemas de armamento y una alta velocidad de viaje, as퀣omo una gran capacidad de carga hace de esta nave un duro rival contra el que luchar."),
208 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,'name'=>"Colonizador",'description'=>"Esta nave proporciona lo necesario para ir a donde ningꂠhombre ha llegado antes y colonizar nuevos mundos."),
209 => array('metal'=>10000,'crystal'=>6000,'deuterium'=>2000,'energy'=>0,'consumption'=>300,'speed'=>4600,'capacity'=>20000,'name'=>"Reciclador",'description'=>"Los recicladores se usan para recolectar escombros flotando en el espacio para reciclarlos en recursos ꀩles."),
210 => array('metal'=>0,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'consumption'=>1,'speed'=>230000000,'capacity'=>5,'name'=>"Sonda de espionaje",'description'=>"Las sondas de espionaje son pequeჳ droides no tripulados con un sistema de propulsi゠excepcionalmente rဩdo usado para espiar en planetas enemigos."),
211 => array('metal'=>50000,'crystal'=>25000,'deuterium'=>15000,'energy'=>0,'consumption'=>1000,'speed'=>11200,'capacity'=>500,'name'=>"Bombardero",'description'=>"El Bombardero es una nave de propラto especial, desarrollado para atravesar las defensas planetarias mრpesadas."),
212 => array('metal'=>0,'crystal'=>2000,'deuterium'=>500,'energy'=>0,'name'=>"Sat逩te solar",'description'=>"Los sat逩tes solares son simples sat逩tes en アita equipados con c逵las fotovoltaicas y transmisores para llevar la energ큠al planeta. Se transmite por este medio a la tierra usando un rayo lქr especial."),
213 => array('metal'=>60000,'crystal'=>50000,'deuterium'=>15000,'energy'=>0,'consumption'=>1000,'speed'=>15500,'capacity'=>2000,'name'=>"Destructor",'description'=>"El destructor es la nave mრpesada jamრvista y posee un potencial de ataque sin precedentes."),
214 => array('metal'=>5000000,'crystal'=>4000000,'deuterium'=>1000000,'energy'=>0,'name'=>"Estrella de la muerte",'description'=>"No hay nada tan grande y peligroso como una estrella de la muerte aproximႤose."),
//Sistemas de defensa
401 => array('metal'=>2000,'crystal'=>0,'deuterium'=>0,'energy'=>0,"description"=>"El lanzamisiles es un sistema de defensa sencillo, pero barato."),
402 => array('metal'=>1500,'crystal'=>500,'deuterium'=>0,'energy'=>0,"description"=>"Por medio de un rayo lქr concentrado, se puede provocar mრdaრque con las armas bal탴icas normales."),
403 => array('metal'=>6000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,"description"=>"Los lქrs grandes posee una mejor salida de energ큠y una mayor integridad estructural que los lქrs pequeჳ."),
404 => array('metal'=>20000,'crystal'=>15000,'deuterium'=>2000,'energy'=>0,"description"=>"Usando una inmensa aceleraci゠electromagn逩ca, los caხes gauss aceleran proyectiles pesados."),
405 => array('metal'=>2000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,"description"=>"Los caხes iォcos disparan rayos de iones altamente energ逩cos contra su objetivo, desestabilizando los escudos y destruyendo los componentes electrォcos."),
406 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>30000,'energy'=>0,"description"=>"Los caხes de plasma liberan la energ큠de una pequeၠerupci゠solar en una bala de plasma. La energ큠destructiva es incluso superior a la del Destructor."),
407 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>0,'energy'=>0,"description"=>"La cꀵla pequeၠde protecci゠cubre el planeta con un delgado campo protector que puede absorber inmensas cantidades de energ큮"),
408 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>0,'energy'=>0,"description"=>"La cꀵla grande de protecci゠proviene de una tecnolog큠de defensa mejorada que absorbe incluso mრenerg큠antes de colapsarse."),
502 => array('metal'=>8000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,"description"=>"Los misiles de intercepci゠destruyen los misiles interplanetarios."),
503 => array('metal'=>12500,'crystal'=>2500,'deuterium'=>10000,'energy'=>0,"description"=>"Los misiles interplanetarios destruyen los sistemas de defensa del enemigo."),
//Construcciones especiales
41 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,"description"=>"Dado que la luna no tiene atmユera, se necesita una base lunar para generar espacio habitable."),
42 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,"description"=>"Usando el sensor phalanx, las flotas de otros imperios pueden ser descubiertas y observadas. Cuanto mayor sea la cadena de sensores phalanx, mayor el rango que pueda escanear."),
43 => array('metal'=>1000000,'crystal'=>2000000,'deuterium'=>1000000,'energy'=>0,"description"=>"El salto cuႴico usa portales transmisores-receptores capaces de enviar incluso la mayor flota instantaneamente a un portal lejano.")

);}

{$tech = array(
//Contrucciones
0 => "僺灑",
1 => "郑偞烿",
2 => "恶䁓烿",
3 => "郍怢倆炻偨",
4 => "倪逳能僑瀵烙",
12 => "怸瀵烙",
14 => "怺偨䂺僥傂",
15 => "炳灳怺偨䂺僥傂",
21 => "造耹傂",
22 => "郑偞䃓傓",
23 => "恶䁓䃓傓",
24 => "郍怢惽",
31 => "瀔灶傞邌傤",
33 => "倰偢怹造偨",
34 => "Depラto de la Alianza",
44 => "僼倹僑倄䂕",
//Tecnologias
100 => "瀔灶",
106 => "灺郴悢恋悀怯",
108 => "股炗怺悀怯",
109 => "恦偨悀怯",
110 => "進傡烾烻烟",
111 => "胅瀲悀怯",
113 => "能郏悀怯",
114 => "肅灺郴悀怯",
115 => "烃烧倕惎",
117 => "耉傲倕惎",
118 => "肅灺郴倕惎",
120 => "惀偉悀怯",
121 => "䀭偐悀怯",
122 => "灉炻偐悀怯",
123 => "胨怟烻烑瀔灑烜",
199 => "倕傛悀怯",
//Naves
200 => "耹耰",
202 => "倏傋胐肓耰",
203 => "倧傋胐肓耰",
204 => "聻傋怘悗怺",
205 => "郍傋怘悗怺",
206 => "僡怋耰",
207 => "怘倗耰",
208 => "悖怑耹",
209 => "僞怶耹",
210 => "悢恋偨",
211 => "聰炸怺",
212 => "倪逳能偫怟",
213 => "惁灭者",
214 => "恻怟",
//Naves
400 => "進傡僺灑",
401 => "火炭僑倄胅灮",
402 => "聻傋惀偉炮",
403 => "郍傋惀偉炮",
404 => "郘悯炮",
405 => "䀭偐炮",
406 => "灉炻偐恦偨",
407 => "倏傋進悤灩",
408 => "倧傋進悤灩",
502 => "惦怪僼倹",
503 => "怟遅僼倹",
//Construcciones especiales
40 => "灹悊僺灑",
41 => "怈瀃僺倰",
42 => "怟傔逵",
43 => "灺郴䀠送点"
);}

$lang['TITLE_GAME'] = 'Ugamela';

$lang['description'] = 'descripciェ';


$lang['ENCODING'] = 'GB2312';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'd M Y'; // Esto se deber큠cambiar al formato predeterminado para tu idioma, formato como php date()



$lang['Username'] = 'Nombre de Usuario';
$lang['Password'] = 'Contraseၧ';
$lang['Email'] = 'Email';


$lang['Metal'] = '½ðÊô'; //郑偞
$lang['Crystal'] = '¾§Ìå'; //恶䁓
$lang['Deuterium'] = 'ÖØÇâ'; //郍怢
$lang['Energy'] = 'ÄÜÁ¿'; //能郏

$lang['level'] = '灉炧';
$lang['Requirements'] = '退恂';
$lang['Name'] = 'Nombre';
$lang['Information_on'] = 'Informaci゠en %n:';
//  Index.php
$lang['NoFrames'] = 'Tu explorador no soporta frames.';


//overview
$lang['Planet_menu'] = 'Menꀤel planeta';
$lang['Planet'] = '怟瀃';
$lang['Have_new_message'] = 'Tienes 1 mensaje nuevo';
$lang['Have_new_messages'] = 'Tienes %m mensajes nuevos';
$lang['Server_time'] = '怍傡偨惶郴';
$lang['Events'] = '䂋䃶';
$lang['Free'] = 'Libre';
$lang['Diameter'] = '烴傄';
$lang['km.'] = '偬郌 ';
$lang['fields'] = '灺郴';
$lang['Developed_fields'] = 'Campos ocupados';
$lang['max_eveloped_fields'] = 'campos mီ de construcciェ';
$lang['Temperature'] = '怔怩';
$lang['approx'] = '倧炦';
$lang['to'] = '倰';
$lang['Position'] = '䁍灮';
$lang['Points'] = '烯倆';
$lang['Rank'] = '䁠烮偍炄悒倍倄䂎 ';
$lang['of'] = '䀭炄瀬  (䁍)->';

// message.php
$lang['Action'] = '储䁜';
$lang['Date'] = '惥怟';
$lang['From'] = '恥胪';
$lang['Subject'] = '䀻邘';
$lang['Ok'] = '灮傚';
$lang['show_only_partial_espionage_reports'] = '䂦僟悥偊䃅怾瀺怇邘';
$lang['Delete_marked_messages'] = '倠遤选惩炄䃡息';
$lang['Delete_all_messages'] = '倠遤恀怉䃡息';

//notes.php
/*
  Corresponde a la parte de la funcion de error();
*/
$lang['ErrorPage'] = 'Pჩna de errores';
$lang['Query'] = 'Consulta';
$lang['Queries'] = 'Consultas';
$lang['Table'] = 'Tabla';
$lang['Parallel_universe'] = '傇備 0';

$lang['Overview'] = '悂債';
$lang['Buildings'] = '僺灑';
$lang['Resources'] = '聄悐';
$lang['Research'] = '瀔灶';
$lang['Shipyard'] = '造耹傂';
$lang['Fleet'] = '耰速';
$lang['Technology'] = '烑悀';
$lang['Galaxy'] = '怟烻';
$lang['Defense'] = '進傡';
$lang['Alliance'] = '联烟';
$lang['Board'] = '肺偛';
$lang['Statistics'] = '悒倍';
$lang['Search'] = '怜瀢';
$lang['Help'] = '倮傩';
$lang['Messages'] = '悈息';
$lang['Notes'] = '惥僗';
$lang['Buddylist'] = '偽僋';
$lang['Options'] = '选遹';
$lang['Logout'] = '退僺';
$lang['Rules'] = '怸怏胄候';
$lang['Legal Notice'] = '惕傋恡怾';

//misc

$lang['Please Login'] = 'Please Login';
// Created by Perberos. All rights reversed (C) 2006 
?>