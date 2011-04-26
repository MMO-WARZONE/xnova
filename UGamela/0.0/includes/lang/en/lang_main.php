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

1 => array('metal'=>40,'crystal'=>10,'deuterium'=>0,'energy'=>0,'factor'=>3/2,"description"=>"Used in the extraction of metal ore, metal mines are of primary importance to all emerging and established empires."),
2 => array('metal'=>30,'crystal'=>15,'deuterium'=>0,'energy'=>0,'factor'=>1.6,"description"=>"Crystals are the main resource used to build electronic circuits and form certain alloy compounds."),
3 => array('metal'=>150,'crystal'=>50,'deuterium'=>0,'energy'=>0,'factor'=>3/2,"description"=>"Deuterium is used as fuel for spaceships and is harvested in the deep sea. Deuterium is a rare substance and is thus relatively expensive."),
4 => array('metal'=>50,'crystal'=>20,'deuterium'=>0,'energy'=>0,'factor'=>3/2,"description"=>"Solar power plants absorb energy from solar radiation. All mines need energy to operate."),
12 => array('metal'=>500,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>1.8,"description"=>"Un reactor de fusiÛn nuclear que produce un ·tomo de helio a partir de dos ·tomos de deuterio usando una presiÛn extremadamente alta y una elevadÌsima temperatura."),
14 => array('metal'=>200,'crystal'=>60,'deuterium'=>100,'energy'=>0,'factor'=>2,"description"=>"Robotic factories provide construction robots to aid in the construction of buildings. Each level increases the speed of the upgrade of buildings."),
15 => array('metal'=>500000,'crystal'=>250000,'deuterium'=>50000,'energy'=>0,'factor'=>2,"description"=>"La f·brica de nanobots es la ˙ltima evoluciÛn de la robÛtica. Cada mejora proporciona nanobots m·s y m·s eficientes que incrementan la velocidad de construcciÛn."),
21 => array('metal'=>200,'crystal'=>100,'deuterium'=>50,'energy'=>0,'factor'=>2,"description"=>"El hangar es el lugar donde se construyen naves y estructuras de defensa planetaria."),
22 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Provides storage for excess metal."),
23 => array('metal'=>1000,'crystal'=>500,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Provides storage for excess crystal."),
24 => array('metal'=>1000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Giant tanks for storing newly-extracted deuterium."),
31 => array('metal'=>100,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>2,"description"=>"A research lab is required in order to conduct research into new technologies."),
33 => array('metal'=>0,'crystal'=>25000,'deuterium'=>5000,'energy'=>500,'factor'=>2,"description"=>"El Terraformer es necesario para habilitar ·reas inaccesibles de tu planeta para edificar infraestructuras."),
34 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"El depÛsito de la alianza ofrece la posibilidad de repostar a las flotas aliadas que estÈn estacionadas en la Ûrbita ayudando a defender."),
44 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>500,'energy'=>0,'factor'=>2,"description"=>"Missile silos are used to store missiles."),
//Tecnologias
106 => array('metal'=>200,'crystal'=>1000,'deuterium'=>200,'energy'=>0,'factor'=>2,"description"=>"Usando esta tecnologÌa, puede obtenerse informaciÛn sobre otros planetas."),
108 => array('metal'=>0,'crystal'=>400,'deuterium'=>600,'energy'=>0,'factor'=>2,"description"=>"Cuanto m·s elevado sea el nivel de tecnologÌa de computaciÛn, m·s flotas podr·s controlar simultaneamente. Cada nivel adicional de esta tecnologia, aumenta el numero de flotas en 1."),
109 => array('metal'=>800,'crystal'=>200,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Este tipo de tecnologÌa incrementa la eficiencia de tus sistemas de armamento. Cada mejora de la tecnologÌa militar aÒade un 10% de potencia a la base de daÒo de cualquier arma disponible."),
110 => array('metal'=>200,'crystal'=>600,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"La tecnologÌa de defensa se usa para generar un escudo de partÌculas protectoras alrededor de tus estructuras. Cada nivel de esta tecnologÌa aumenta el escudo efectivo en un 10% (basado en el nivel de una estructura dada)."),
111 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"Las aleaciones altamente sofisticadas ayudan a incrementar el blindaje de una nave aÒadiendo el 10% de su fuerza en cada nivel a la fuerza base."),
113 => array('metal'=>0,'crystal'=>800,'deuterium'=>400,'energy'=>0,'factor'=>2,"description"=>"Entendiendo la tecnologÌa de diferentes tipos de energÌa, muchas investigaciones nuevas y avanzadas pueden ser adaptadas. La tecnologÌa de energÌa es de gran importancia para un laboratorio de investigaciÛn moderno."),
114 => array('metal'=>0,'crystal'=>4000,'deuterium'=>2000,'energy'=>0,'factor'=>2,"description"=>"Incorporando la cuarta y quinta dimensiÛn en la tecnologÌa de propulsiÛn, se puede disponer de un nuevo tipo de motor; que es m·s eficiente y usa menos combustible que los convencionales."),
115 => array('metal'=>400,'crystal'=>0,'deuterium'=>600,'energy'=>0,'factor'=>2,"description"=>"Ejecutar investigaciones en esta tecnologÌa proporciona motores de combustiÛn siempre m·s rapido, aunque cada nivel aumenta solamente la velocidad en un 10% de la velocidad base de una nave dada."),
117 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>6000,'energy'=>0,'factor'=>2,"description"=>"El sistema del motor de impulso se basa en el principio de la repulsiÛn de partÌculas. La materia repelida es basura generada por el reactor de fusiÛn usado para proporcionar la energÌa necesaria para este tipo de motor de propulsiÛn."),
118 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>6000,'energy'=>0,'factor'=>2,"description"=>"Los motores de hiperespacio permiten entrar al mismo a travÈs de una ventana hiperespacial para reducir dr·sticamente el tiempo de viaje. El hiperespacio es un espacio alternativo con m·s de 3 dimensiones."),
120 => array('metal'=>200,'crystal'=>100,'deuterium'=>0,'energy'=>0,'factor'=>2,"description"=>"La tecnologÌa l·ser es un importante conocimiento; conduce a la luz monocrom·tica firmemente enfocada sobre un objetivo. El daÒo puede ser ligero o moderado dependiendo de la potencia del rayo..."),
121 => array('metal'=>1000,'crystal'=>300,'deuterium'=>100,'energy'=>0,'factor'=>2,"description"=>"La tecnologÌa iÛnica enfoca un rayo de iones acelerados en un objetivo, lo que puede provocar un gran daÒo debido a su naturaleza de electrones cargados de energÌa."),
122 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>1000,'energy'=>0,'factor'=>2,"description"=>"Las armas de plasma son incluso m·s peligrosas que cualquier otro sistema de armamento conocido, debido a la naturaleza agresiva del plasma"),
123 => array('metal'=>240000,'crystal'=>400000,'deuterium'=>160000,'energy'=>0,'factor'=>2,"description"=>"Los cientÌficos de tus planetas pueden comunicarse entre ellos a travÈs de esta red."),
199 => array('metal'=>0,'crystal'=>0,'deuterium'=>0,'energy'=>300000,'factor'=>3,"description"=>"A travÈs del disparo de partÌculas concentradas de gravitÛn se genera un campo gravitacional artificial con suficiente potencia y poder de atracciÛn para destruir no solo naves, sino lunas enteras."),
//Naves espaciales
202 => array('metal'=>2000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'consumption'=>20,'speed'=>28000,'capacity'=>5000,'name'=>"Nave pequeÒa de carga",'description'=>"Las naves pequeÒas de carga son naves muy ·giles usadas para transportar recursos desde un planeta a otro."),
203 => array('metal'=>6000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,'consumption'=>50,'speed'=>17250,'capacity'=>25000,'name'=>"Nave grande de carga",'description'=>"La nave grande de carga es una versiÛn avanzada de las naves pequeÒas de carga, permitiendo asÌ una mayor capacidad de almacenamiento y velocidades m·s altas gracias a un mejor sistema de propulsiÛn."),
204 => array('metal'=>3000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'consumption'=>20,'speed'=>28750,'capacity'=>50,'name'=>"Cazador ligero",'description'=>"El cazador ligero es una nave maniobrable que puedes encontrar en casi cualquier planeta. El coste no es particularmente alto, pero asimismo el escudo y la capacidad de carga son muy bajas."),
205 => array('metal'=>6000,'crystal'=>4000,'deuterium'=>0,'energy'=>0,'consumption'=>75,'speed'=>28000,'capacity'=>100,'name'=>"Cazador pesado",'description'=>"El cazador pesado es la evoluciÛn logica del ligero, ofreciendo escudos reforzados y una mayor potencia de ataque."),
206 => array('metal'=>20000,'crystal'=>7000,'deuterium'=>2000,'energy'=>0,'consumption'=>300,'speed'=>42000,'capacity'=>800,'name'=>"Crucero",'description'=>"Los cruceros de combate tienen un escudo casi tres veces m·s fuerte que el de los cazadores pesados y m·s del doble de potencia de ataque. Su velocidad de desplazamiento est· tambiÈn entre las m·s r·pidas jam·s vista."),
207 => array('metal'=>40000,'crystal'=>20000,'deuterium'=>0,'energy'=>0,'consumption'=>500,'speed'=>31000,'capacity'=>1500,'name'=>"Nave de batalla",'description'=>"Las naves de batalla son la espina dorsal de cualquier flota militar. Blindaje pesado, potentes sistemas de armamento y una alta velocidad de viaje, asÌ como una gran capacidad de carga hace de esta nave un duro rival contra el que luchar."),
208 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,'name'=>"Colonizador",'description'=>"Esta nave proporciona lo necesario para ir a donde ning˙n hombre ha llegado antes y colonizar nuevos mundos."),
209 => array('metal'=>10000,'crystal'=>6000,'deuterium'=>2000,'energy'=>0,'consumption'=>300,'speed'=>4600,'capacity'=>20000,'name'=>"Reciclador",'description'=>"Los recicladores se usan para recolectar escombros flotando en el espacio para reciclarlos en recursos ˙tiles."),
210 => array('metal'=>0,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'consumption'=>1,'speed'=>230000000,'capacity'=>5,'name'=>"Sonda de espionaje",'description'=>"Las sondas de espionaje son pequeÒos droides no tripulados con un sistema de propulsiÛn excepcionalmente r·pido usado para espiar en planetas enemigos."),
211 => array('metal'=>50000,'crystal'=>25000,'deuterium'=>15000,'energy'=>0,'consumption'=>1000,'speed'=>11200,'capacity'=>500,'name'=>"Bombardero",'description'=>"El Bombardero es una nave de propÛsito especial, desarrollado para atravesar las defensas planetarias m·s pesadas."),
212 => array('metal'=>0,'crystal'=>2000,'deuterium'=>500,'energy'=>0,'name'=>"SatÈlite solar",'description'=>"Los satÈlites solares son simples satÈlites en Ûrbita equipados con cÈlulas fotovoltaicas y transmisores para llevar la energÌa al planeta. Se transmite por este medio a la tierra usando un rayo l·ser especial."),
213 => array('metal'=>60000,'crystal'=>50000,'deuterium'=>15000,'energy'=>0,'consumption'=>1000,'speed'=>15500,'capacity'=>2000,'name'=>"Destructor",'description'=>"El destructor es la nave m·s pesada jam·s vista y posee un potencial de ataque sin precedentes."),
214 => array('metal'=>5000000,'crystal'=>4000000,'deuterium'=>1000000,'energy'=>0,'name'=>"Estrella de la muerte",'description'=>"No hay nada tan grande y peligroso como una estrella de la muerte aproxim·ndose."),
//Sistemas de defensa
401 => array('metal'=>2000,'crystal'=>0,'deuterium'=>0,'energy'=>0,"description"=>"El lanzamisiles es un sistema de defensa sencillo, pero barato."),
402 => array('metal'=>1500,'crystal'=>500,'deuterium'=>0,'energy'=>0,"description"=>"Por medio de un rayo l·ser concentrado, se puede provocar m·s daÒo que con las armas balÌsticas normales."),
403 => array('metal'=>6000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,"description"=>"Los l·sers grandes posee una mejor salida de energÌa y una mayor integridad estructural que los l·sers pequeÒos."),
404 => array('metal'=>20000,'crystal'=>15000,'deuterium'=>2000,'energy'=>0,"description"=>"Usando una inmensa aceleraciÛn electromagnÈtica, los caÒones gauss aceleran proyectiles pesados."),
405 => array('metal'=>2000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,"description"=>"Los caÒones iÛnicos disparan rayos de iones altamente energÈticos contra su objetivo, desestabilizando los escudos y destruyendo los componentes electrÛnicos."),
406 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>30000,'energy'=>0,"description"=>"Los caÒones de plasma liberan la energÌa de una pequeÒa erupciÛn solar en una bala de plasma. La energÌa destructiva es incluso superior a la del Destructor."),
407 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>0,'energy'=>0,"description"=>"La c˙pula pequeÒa de protecciÛn cubre el planeta con un delgado campo protector que puede absorber inmensas cantidades de energÌa."),
408 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>0,'energy'=>0,"description"=>"La c˙pula grande de protecciÛn proviene de una tecnologÌa de defensa mejorada que absorbe incluso m·s energÌa antes de colapsarse."),
502 => array('metal'=>8000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,"description"=>"Los misiles de intercepciÛn destruyen los misiles interplanetarios."),
503 => array('metal'=>12500,'crystal'=>2500,'deuterium'=>10000,'energy'=>0,"description"=>"Los misiles interplanetarios destruyen los sistemas de defensa del enemigo."),
//Construcciones especiales
41 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,"description"=>"Dado que la luna no tiene atmÛsfera, se necesita una base lunar para generar espacio habitable."),
42 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,"description"=>"Usando el sensor phalanx, las flotas de otros imperios pueden ser descubiertas y observadas. Cuanto mayor sea la cadena de sensores phalanx, mayor el rango que pueda escanear."),
43 => array('metal'=>1000000,'crystal'=>2000000,'deuterium'=>1000000,'energy'=>0,"description"=>"El salto cu·ntico usa portales transmisores-receptores capaces de enviar incluso la mayor flota instantaneamente a un portal lejano.")

);}

{$tech = array(
//Contrucciones
0 => "Buildings",
1 => "Metal Mine",
2 => "Crystal Mine",
3 => "Deuterium Synthesizer",
4 => "Solar Plant",
12 => "Fusion Reactor",
14 => "Robotics Factory",
15 => "Nanite Factory",
21 => "Shipyard",
22 => "Metal Storage",
23 => "Crystal Storage",
24 => "Deuterium Tank",
31 => "Research Lab",
33 => "Terraformer",
34 => "DepÛsito de la Alianza",
44 => "Missile Silo",
//Tecnologias
100 => "Research",
106 => "Espionage Technology",
108 => "Computer Technology",
109 => "Weapons Technology",
110 => "Shielding Technology",
111 => "Armour Technology",
113 => "Energy Technology",
114 => "Hyperspace Technology",
115 => "Combustion Drive",
117 => "Impulse Drive",
118 => "Hyperspace Drive",
120 => "Laser Technology",
121 => "Ion Technology",
122 => "Plasma Technology",
123 => "Intergalactic Research Network",
199 => "Graviton Technology",
//Naves
200 => "Ships",
202 => "Small Cargo",
203 => "Large Cargo",
204 => "Light Fighter",
205 => "Heavy Fighter",
206 => "Cruiser",
207 => "Battleship",
208 => "Colony Ship",
209 => "Recycler",
210 => "Espionage Probe",
211 => "Bomber",
212 => "Solar Satellite",
213 => "Destroyer",
214 => "Deathstar",
//Naves
400 => "Defense",
401 => "Rocket Launcher",
402 => "Light Laser",
403 => "Heavy Laser",
404 => "Gauss Cannon",
405 => "Ion Cannon",
406 => "Plasma Turret",
407 => "Small Shield Dome",
408 => "Large Shield Dome",
502 => "Anti-Ballistic Missiles",
503 => "Interplanetary Missiles",
//Construcciones especiales
40 => "Lunar Buildings",
41 => "Lunar Base",
42 => "Sensor Phalanx",
43 => "Jump Gate"
);}

$lang['TITLE_GAME'] = 'Ugamela';

$lang['description'] = 'description';


$lang['ENCODING'] = 'iso-8859-1';
$lang['DIRECTION'] = 'ltr';
$lang['LEFT'] = 'left';
$lang['RIGHT'] = 'right';
$lang['DATE_FORMAT'] =  'd M Y'; // Esto se deberÌa cambiar al formato predeterminado para tu idioma, formato como php date()



$lang['Username'] = 'Username';
$lang['Password'] = 'Password';
$lang['Email'] = 'Email';


$lang['Metal'] = 'Metal';
$lang['Crystal'] = 'Crystal';
$lang['Deuterium'] = 'Deuterium';
$lang['Energy'] = 'Energy';

$lang['level'] = 'level';
$lang['Requirements'] = 'Requirements';
$lang['Name'] = 'Name';
$lang['Information_on'] = 'Information on %n:';
//  Index.php
$lang['NoFrames'] = 'You Browser dont work with frames.';


//Overview
$lang['Planet_menu'] = 'Planet menu';
$lang['Planet'] = 'Planet';
$lang['Have_new_message'] = 'Have 1 new message';
$lang['Have_new_messages'] = 'Have %m new messages';
$lang['Server_time'] = 'Time';
$lang['Events'] = 'Events';
$lang['Free'] = 'Free';
$lang['Diameter'] = 'Diameter';
$lang['fields'] = 'fields';
$lang['Developed_fields'] = 'Developed fields';
$lang['max_eveloped_fields'] = 'max. eveloped fields';
$lang['Temperature'] = 'Temperature';
$lang['approx'] = 'approx.';
$lang['to'] = 'to';
$lang['∞C'] = '∞C';
$lang['Position'] = 'Position';
$lang['Points'] = 'Points';
$lang['Rank'] = 'Rank';
$lang['of'] = 'of';

// message.php
$lang['Action'] = 'Action';
$lang['Date'] = 'Date';
$lang['From'] = 'From';
$lang['Subject'] = 'Subject';
$lang['Ok'] = 'Ok';
$lang['show_only_partial_espionage_reports'] = 'show only partial espionage reports';
$lang['Delete_marked_messages'] = 'Delete marked messages';
$lang['Delete_all_messages'] = 'Delete all messages';

/*
  Corresponde a la parte de la funcion de error();
*/
$lang['ErrorPage'] = 'ErrorPage';
$lang['Query'] = 'Query';
$lang['Queries'] = 'Queries';
$lang['Table'] = 'Table';
$lang['Parallel_universe'] = 'Multiverse';
$lang['Multiverse'] = 'Multiverse';

$lang['Overview'] = 'Overview';
$lang['Buildings'] = 'Buildings';
$lang['Resources'] = 'Resources';
$lang['Research'] = 'Research';
$lang['Shipyard'] = 'Shipyard';
$lang['Fleet'] = 'Fleet';
$lang['Technology'] = 'Technology';
$lang['Galaxy'] = 'Galaxy';
$lang['Defense'] = 'Defense';
$lang['Alliance'] = 'Alliance';
$lang['Board'] = 'Board';
$lang['Statistics'] = 'Statistics';
$lang['Search'] = 'Search';
$lang['Help'] = 'Help';
$lang['Messages'] = 'Messages';
$lang['Notes'] = 'Notes';
$lang['Buddylist'] = 'Buddylist';
$lang['Options'] = 'Options';
$lang['Logout'] = 'Logout';
$lang['Rules'] = 'Rules';
$lang['Legal Notice'] = 'Legal Notice';

{//Errores de Cookies
$lang['cookies']['Error1'] = 'Datos invalidos de cookie (Error 1). Por favor, borre '.
			'las cookies e inicie de nuevo.<br /><a href="login.php?do=login">'.
			'Iniciar sesiÛn</a><br /><br />Si el error persiste, tratÅEde contactar'.
			' a un administrador del servidor. Muchas gracias.';
$lang['cookies']['Error2'] = 'Datos invalidos de cookie (Error 2). Por favor, borre'.
			' las cookies e inicie de nuevo.<br /><a href="login.php?do=login">'.
			'Iniciar sesiÛn</a><br /><br />Si el error persiste, tratÅEde contactar'.
			' a un administrador del servidor. Muchas gracias.';
$lang['cookies']['Error3'] = 'Datos invalidos de cookie (Error 3). Por favor, borre'.
			' las cookies e inicie de nuevo.<br /><a href="login.php?do=login">'.
			'Iniciar sesiÛn</a><br /><br />Si el error persiste, tratÅEde contactar'.
			' a un administrador del servidor. Muchas gracias.';
}
//Login
$lang['Login'] = 'Login';
$lang['Please_Login'] = 'Por favor, <a href="login.php" target="_main">identif&iacute;cate...</a>';
$lang['Please_Wait'] = 'Espere por favor';
$lang['Remember_me'] = 'Remember Me';
$lang['Register'] = 'Register';

//Misc
$lang['Time'] = 'Time';//*


// Created by Perberos. All rights reversed (C) 2006 
?>
