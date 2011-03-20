<?php

// ----------------------------------------------------------------------------------------------------------
// Interface !
$lang['nfo_page_title']  = "Information";
$lang['nfo_title_head']  = "Information om";
$lang['nfo_name']        = "Namn";
$lang['nfo_destroy']     = "Riv";
$lang['nfo_level']       = "Nivå";
$lang['nfo_range']       = "Sensor avstånd";
$lang['nfo_used_energy'] = "Energi konsumtion";
$lang['nfo_used_deuter'] = "Deuterium konsumtion";
$lang['nfo_prod_energy'] = "Energi Produktion	";
$lang['nfo_difference']  = "Mellanskillnad";
$lang['nfo_prod_p_hour'] = "produktion/timme";
$lang['nfo_needed']      = "Kriterier";
$lang['nfo_dest_durati'] = "Rivnings Tid";

$lang['nfo_struct_pt']   = "Strukturell Integritet";
$lang['nfo_shielf_pt']   = "Sköldstyrka";
$lang['nfo_attack_pt']   = "Attackstyrka";
$lang['nfo_rf_again']    = "Eldhastighet mot";
$lang['nfo_rf_from']     = "Eldhastighet från";
$lang['nfo_capacity']    = "Last kapacitet";
$lang['nfo_units']       = "enheter";
$lang['nfo_base_speed']  = "Grundhastighet";
$lang['nfo_consumption'] = "Bränsle konsumtion (Deuterium)";

// ----------------------------------------------------------------------------------------------------------
// Interface of Jump Gate
$lang['gate_start_moon'] = "Start måne";
$lang['gate_dest_moon']  = "Mål måne :";
$lang['gate_use_gate']   = "Använd Rymdport";
$lang['gate_ship_sel']   = "Välj skepp";
$lang['gate_ship_dispo'] = "tillgängliga";
$lang['gate_jump_btn']   = "Utför hopp!";
$lang['gate_jump_done']  = "Rymdportal håller på att återuppladdas!<br>Rymdportalen kommer vara återställd för nytt hopp om: ";
$lang['gate_wait_dest']  = "Destinations portalen återuppladdas!Rymdportalen kommer vara återställd för nytt hopp om: ";
$lang['gate_no_dest_g']  = "Det finns ingen Rymdportal på den planeten du vill skicka din flottilj";
$lang['gate_wait_star']  = "Rymdportalen återuppladdas!<br>Portalen kommar vara återställd för nytt hopp om: ";
$lang['gate_wait_data']  = "FEL, hoppdata fattas!";
$lang['gate_vacation']	 = "FEL, Du kan inte använda en Rymdportal när ditt konto är i viloläge !";
// ----------------------------------------------------------------------------------------------------------
// Buildings Mines!
$lang['info'][1]['name']          = "Metallgruva";
$lang['info'][1]['description']   = "Metaller är den huvudsakliga resursen som används i ditt Imperium. På större djup kan gruvorna producera mera duglig metall, att använda vid konstruktion av byggnader, skepp, försvar och forskning. Ju djupare gruvorna blir, desto mer energi går åt för maximera produktionen. Efter som metall är den mest lätt tillgängliga resursen, är också dess värde lägst när det gäller marknadspriser.";
$lang['info'][2]['name']          = "Kristallgruva";
$lang['info'][2]['description']   = "Kristaller är den huvudsakliga resursen för att utveckla bla. kretskort till datorer och annan likvärdig hårdvara, även för särskilda sammansatta legeringar som används vid sköld tillverkning. Jämfört med metallens produktions process, behöver den råa kristallens speciell behandlig för att omvandlas till industriell kristall. Därav tillkommer också en högre energi konsumtion än för metall. Utvecklandet av skepp och byggnader, och även specialiserad forskning, kräver oftast en viss mängd kristaller.";
$lang['info'][3]['name']          = "Deuteriumplattform";
$lang['info'][3]['description']   = "Deuterium (av grekiska deuteros = den andre) är en isotop av väte med en neutron förutom protonen i kärnan, och kallas vanligen tungt väte. Isotopen betecknas 2H eller D. Deuterium har vissa egenskaper (absorberar inte gärna neutroner) som gör den användbar i kärnreaktorer som använder ej anrikat uran, då i form av tungt vatten (D2O). Deuterium kan även användas som bränsle i fusionreaktorer, både rent deuterium och blandat med tritium. Deuterium används vid användandet av phalanxradar, utforskning av galaxer, skeppsbränsle och utvecklandet av specialiserad forskning.";

// ----------------------------------------------------------------------------------------------------------
// Buildings Energy!
$lang['info'][4]['name']          = "Solkraftverk";
$lang['info'][4]['description']   = "Gigantiska solpaneler används för att utvinna Energi till dina gruvor och Deuteriumplattformar. Ju högre level du har på dina solkraftverk desto större solpaneler får du som kan samla in solenergin, vilket resulterar i en högre energinivå. Solkraftverken täcker den största delen av Energibehovet på planeten. ";
$lang['info'][12]['name']         = "Fusionskraftverk";
$lang['info'][12]['description']  = "I ett fusionskraftverk, en deuterium och tritium (DT) blandningen är upptagna till de evakuerade reaktorn avdelningen och det joniserade och upphettas till termonukleär temperaturer. Bränslet hålls borta från kammarens väggar av magnetiska krafter länge nog för ett bra antal reaktioner äga rum. För varje gram av Deuterium kan upp till 41,32*10^-13 Joule ren energi utvinnas; med 1 gram kan du producera 172 MWh energi. <br>Större reaktorkomplex använder större mängd Deuterium och kan producera mer energi. Energi effekten kan utökas genom att forska energi teknologi.<br>Således kan man räkna ut energi produktionen i fusionkraftverket så här:<br><br> 30 * [Level Fusion Plant] * (1,05 + [Level Energy Technology] * 0,01) ^ [Level Fusion Plant]";

// ----------------------------------------------------------------------------------------------------------
// Buildings General!
$lang['info'][14]['name']         = "Robotfabrik";
$lang['info'][14]['description']  = "Robotfabriken tillverkar robotar som används till att uppgradera byggnader. Varje uppgradering av Robotfabriken ökar antalet robotar som används till byggnadskonstruktioner. Det medför att tiden för att bygga en byggnad minskas. ";
$lang['info'][15]['name']         = "Nanofabrik";
$lang['info'][15]['description']  = "Denna fabrik producerar saker som man tror är den ultimata revolutionen inom robotteknologin. Naniter är robotar som arbetar i storleken nanometer alltså 0,000 000 001 meter. Varje level halverar konstruktionstiden för Byggnader, Skepp och Försvar. Tack vare av deras höga prestanda och genom ett bra arbetarnätverk. ";
$lang['info'][21]['name']         = "Skeppsvarv";
$lang['info'][21]['description']  = "Det planetära skeppsvarvet är ansvarigt för att bygga rymdskepp och försvarssystem. Allt mer man uppgraderar skeppsvarvet kan det producera fler olika skepp och i en mycket högre hastighet. Om Nanofabriken är upprättad på planeten, kommer hastigheten för att bygga varje skepp och försvarssystem bli mycket högre. ";
$lang['info'][22]['name']         = "Metallager";
$lang['info'][22]['description']  = "Denna byggnad är ett gigantiskt lager för bruten Metall. Ju mer det uppgraderas, desto mer kan man lagra. När maxkapaciteten på metallagret nås, kan inte mer metall brytas i gruvan, men det går fortfarande att ta emot metalltransporter från andra planeter. ";
$lang['info'][23]['name']         = "Kristallager";
$lang['info'][23]['description']  = "I denna byggnad lagras rå Kristall. Ju mer byggnaden uppgraderas, desto mer kan man lagra. Men när maxkapaciteten på kristallagret nås, kan inte mer kristall brytas. ";
$lang['info'][24]['name']         = "Deuteriumtank";
$lang['info'][24]['description']  = "Denna byggnad är egentligen stora cisterner som är byggda speciellt för lagring av nyutvunnet Deuterium. För att bygga en Flotta behövs oftast deuterium. Denna Lagringstank hittar man då oftast nära Skeppsvarven. Medans Deuteriumtanken uppgraderas ökas kapaciteten, men när maxkapaciteten har nåtts kan inte mer deuterium framställas. ";
$lang['info'][31]['name']         = "Forskningslabb";
$lang['info'][31]['description']  = "I försök till att forska fram nya teknologier behöver man forskningslabb. Varje level ökar hastigheten på forskningen men tar också fram nya unika teknologier. För att kunna utföra forskning så snabbt som möjligt, skickas alla forskare till den planet där man startade forskningen. När uppgiften är klar, åker forskarna hem till deras planeter och tar med sig den nya teknologin. På detta vis lär sig hela imperiet den nya teknologin. ";
$lang['info'][33]['name']         = "Terraformare";
$lang['info'][33]['description']  = "Med minskande landareal i takt med planetens utveckling började man oroa sig för att behöva begränsa livsutrymmet på den. Gamla metoder såsom att bygga på höjden och bygga under marken blev mer och mer otillräckligt. Då kom en grupp högenergifysiker och nanoingenjörer äntligen på en lösning, Terraformaren. Med hjälp av enorma mängder energi kan man återskapa stora landområden, till och med kontinenter, till användbart skick. Detta görs med hjälp av små specialkonstruerade naniter som håller landmassan i brukbart tillstånd. Väl byggd, kan inte terraformaren dekonstrueras. ";
$lang['info'][34]['name']         = "Alliansdepå";
$lang['info'][34]['description']  = "Alliansdepån förser vänliga flottor, som befinner sig i omloppsbana, med bränsle och hjälper till att försvara dessa vid behov. För varje uppgraderad nivå kan 10,000 enheter/timme av deuterium skickas ut till flottor i omloppsbana";

// ----------------------------------------------------------------------------------------------------------
// Batiments Lune!
$lang['info'][41]['name']         = "Månbas";
$lang['info'][41]['description']  = "En måne har ingen atmosfär så månbasen måste byggas innan man kan utveckla vidare. Månbasen ger det nödvändiga som syre, gravitation och värme. Desto högre level på månbasen, desto mer biosfäryta blir det. 3 fält utvecklas på varje level till månens storlek har nåtts. Varje level använder 1 fält. När man väl har byggt månbasen kan man inte riva den. ";
$lang['info'][42]['name']         = "Phalanxradar";
$lang['info'][42]['description']  = "Högupplösningssensorer scannar hela strålningsspektrat vid radarstationen. Högpresterande datorer mäter mikroskopiska energiflöden från skepp på planeter långt borta. För scanningen krävs det att energi (i form av 5000 deuterium) finns tillgänglig på månen. Scanningen utförs genom att man går från månen till Galaxvyn och klickar på en motståndares planet innanför radarns räckvidd. ";
$lang['info'][43]['name']         = "Rymdportal";
$lang['info'][43]['description']  = "Rymdportaler är som stora sändare och mottagare, kapabla att skicka och ta emot t.o.m. de största flottorna helt utan tidsförluster. Själva sändningen och mottagningen konsumerar ingen deuterium, dock behöver porten kylas ned i en timme mellan användningarna för att inte överhettas. Denna otroligt komplexa teknologi klarar dock inte av att skicka resurser. ";
$lang['info'][44]['name']         = "Missilsilo";
$lang['info'][44]['description']  = "Missilsilos används till att lagra ock avfyra missiler. Fem Interplanetära Missiler eller 10 Anti-ballistiska Missiler kan lagras per level. En Interplanetär Missil tar upp lika mycket plats som två Anti-ballistiska Missiler. ";

// ----------------------------------------------------------------------------------------------------------
// Laboratory !
$lang['info'][106]['name']        = "Spionteknologi";
$lang['info'][106]['description'] = "Spionteknologi är ditt främsta underrättelse verktyg. Denna teknologin tillåter dig att undersöka dina fienders resurser, flottor, byggnader och forsknings nivåer med special designade sonder. När du skickar dessa spionsonder mot dina fiender, kommer dessa att skicka tillbaka krypterad information till din planet. Du får därefter informationen som sonden läst av i ett meddelande när det har dekrypterats. Med Spionteknologi är din nivå jämfört med ditt måls nivå, mycket kritiskt. Om ditt mål har högre nivå i Spion Teknologi än du, måste du skicka fler sonder för att kunna få tillräcklig information. Det leder dock till högre risk att dina sonder upptäcks, vilket resulterar i sondernas förstörelse. Å andra sidan, skulle du skicka för få sonder kommer detta resultera i bristande information som i sin tur kan leda till katastrofala följder för din flotta eller planeter.<br><br> Vid uppnåda specifika nivåer av Spion Teknologi, kommer nya varningssystem mot attacker att installeras:<br><br> Vid nivå <font color=red> 2</font>, Det totala antalet attackerande skepp kommer att visas tillsammans med en grundläggande attack varning.<br><br> Vid nivå <font color=red>4</font>, typen av dom attackerande skeppen inkluderat totala antalet skepp, kommer att visas.<br><br> Vid nivå <font color=red>8</font>, exakt antal skepp av varje typ kommer att visas.";
$lang['info'][108]['name']        = "Datorteknologi";
$lang['info'][108]['description'] = "När flottiljerna väl har skickats, kontrolleras dom främst av datorer från \"moderplaneten\". Dessa superdatorer kalkylerar exakt ankomst tid, korrigerar navigerings vid behov, kalkylerar missilbanor och reglerar flyghastigheter.<br><br>Efter varje utforskad nivå, uppgraderas flygdatorn med ytterligare en flottiljplats. Datorteknologi bör uppgraderas i takt med att ditt Imperium utökas.";
$lang['info'][109]['name']        = "Vapenteknologi";
$lang['info'][109]['description'] = "Vapenteknologi är en av dom primära teknologierna och din överlevnad hänger väldigt mycket på denna teknologin. Vid varje utforskad nivå, ökas effektiviteten på dina skepps vapensystem och även försvarssystem på dina planeter avsevärt. För varje nivå ökar din vapenstyrka med 10% av basvärdet.";
$lang['info'][110]['name']        = "Sköldteknologi";
$lang['info'][110]['description'] = "I med upptäckten av magnetosfärgeneratorn lärde sig vetenskapsmän att man kunde utveckla en artificiell sköld som kunde skydda besättningar på rymdskepp, men inte bara från strålning i rymden utan även från attacker från fiendeskepp. När så forskarna utvecklat och finslipat teknologin, installerades generatorn på samtliga skepp och försvarssystem.<br><br>För varje nivå teknologin avancerar, uppgraderas magnetosfär generatorn och ger ut ytterligare 10% styrka av basvärdet.";
$lang['info'][111]['name']        = "Bepansringsteknologi";
$lang['info'][111]['description'] = "Miljön i yttrerymden är mer än ogästvänlig. Piloter och besättningar på olika uppdrag, utsätts inte bara för solstrålning, de utsätts även för möjligheten att träffas av spillror från asteroider och annat skrot, eller till och med fiende eld. Vid upptäckten av en aluminum-lithium titankarbid legering, som fanns både lätt till vikt och beständig, detta gav besättningar en viss del av skydd. För varje utforskad nivå av Pansarteknologi produceras en nivå högre kvalitets legering, vilket utökar armeringen med 10%.";
$lang['info'][113]['name']        = "Energiteknologi";
$lang['info'][113]['description'] = "Då andra forskningsområden avancerade, upptäcktes det att energipförsörjningen inte var tillräcklig för att kunne begå specialiserad forskning. För varje utforskad nivå av Energiteknologi, kommer nya forskningsområden att låsas upp och kunna utvecklas, därmed även utveckling av större och bättre skepp och försvar.";
$lang['info'][114]['name']        = "Hyperrymdteknologi";
$lang['info'][114]['description'] = "Hyperrymdteknologin tillåter forskning av framdrivningssystem som kan driva mycket större fartyg och gör det också möjligt att resa mycket snabbare med bättre bränsleeffektivitet. Vid högre nivåer tillåter denna teknologin också datainformation att överföras omedelbart, vilket gör att flera planeter kan samarbeta i viktiga projekt.<br>När en viss nivå av Hyperrymdteknologin väl har utvecklats kommer inte hyperdrift längre vara enbart teori.";
$lang['info'][115]['name']        = "Förbränningsteknologi";
$lang['info'][115]['description'] = "Förbränningsteknologi är den äldsta av teknologierna, men den används fortfarande. <br><br>För varje utforskad nivå av Förbränningsteknologin, kommer hastigheten på Små och Stora Haulers, Lättare Freggater, Skördare och Spionsonder att öka med 10%.";
$lang['info'][117]['name']        = "Impulsdrift";
$lang['info'][117]['description'] = "Impulsdrift är i grunden en förstärkt fusionraket, består oftast av en fusionreaktor, accelerator, en komponentdriftspole och ett vridbart drivkraftsmunstycke för att rikta plasma flödet. Fusionsreaktorn genererar en ytterst stärkt plasma. Denna plasma, (\"electro-plasma\"), kan användas som drivkraft, den kan också riktas genom en EPS conduit som tar små mängder plasma från varp centralen eller impulskapacitetsmotorn och omdirigerar det igenom hela fartyget för användning för att driva andra system, såsom vapen och deflektorplåtar (sköldar).<br><br>För varje utforskad nivå av impulsdrift kommer hastigheten på Bombskepp, Kryssare, Tunga Freggater och Koloniseringsskepp att öka med 20% av basvärdet. Interplanetära missiler kommer också färdas fortare för varje nivå.";
$lang['info'][118]['name']        = "Hyperrymdsdrift";
$lang['info'][118]['description'] = "I och med avancerandet av Hypertymdteknologin har Hyperrymdsdrift möjliggjorts. Hyperrymden är en alternativ rymd för att kunna samexistera med vårt universum och vilket kan tillåtas genom att använda ett energifält eller liknande. Hyperrymddriften använder detta \"andra samexisterande område\" genom att förvränga rymd/tid kontinuum, vilket resulterar i hastigheter fortare än ljuset (också känt som FTL). Vid FTL resande är rymd och tid förvrängt så pass att en resa som skulle tagit 1000 ljusår avklaras på enbart 1 timme.<br><br>För varje utforskad nivå av Hyperrymddrift kommer hastigheten på Slagskepp, Slagkryssare, Jagare och Titaner att ökas med 30%.";
$lang['info'][120]['name']        = "Laserteknololgi";
$lang['info'][120]['description'] = "En laser är en anordning som avger ljus (elektromagnetisk strålning) genom en process som kallas stimulerad emission. Termen \"laser\" är en förkortning för Light Amplification genom stimulerad emission av strålning. Lasern har många användningsområden inom Imperiet, från att uppgradera datorkommunikationssystem till att tillverka nya vapen och rymdskepp.";
$lang['info'][121]['name']        = "Jonteknologi";
$lang['info'][121]['description'] = "Simply put, an ion is an atom or a group of atoms that has acquired a net electric charge by gaining or losing one or more electrons. Utilized in advanced weapons systems, a consentrated beam of Ions can cause considerable damage to objects that it strikes.";
$lang['info'][122]['name']        = "Plasmateknologi";
$lang['info'][122]['description'] = "In the universe, there exists four states of matter: solid, liquids, gas, and plasma. Being an advanced version of Ion technology, Plasma Technology expands on the destructive effect that Ion Technology delivered, and opens the door to create advanced weapons systems and ships. Plasma matter is created by superheating gas and compressing it with extreme high pressures to create a sphere of superheated plasma matter. The resulting plasma sphere causes considerable damage to the target in which the sphere is launched to.";
$lang['info'][123]['name']        = "Intergalaktiskt Forskningsnätverk";
$lang['info'][123]['description'] = "This is your deep space network to communicate researches to your colonies. With the IRN, faster research times can be achieved by linking the highest level research labs equal to the level of the IRN developed.<br><br>In order to function, each colony must be able to conduct the research independently.";
$lang['info'][124]['name']        = "Expeditionsteknologi";
$lang['info'][124]['description'] = "The Expedition Technology includes several scan researches and allows you to equip different spaceships with research modules to explore uncharted regions of the universe. Those include a database and a fully functional mobile laboratory.<br><br>To assure the security of the expedition fleet during dangerous research situations, the research modules have their own energy supplies and energy field generators which creates a powerful force field around the research module during emergency situations.";
$lang['info'][125]['name']        = "Alliansbaserat Forskningsnätverk";
$lang['info'][125]['description'] = "Detta är ditt främsta nätverk för att kommunicera inom din Allians. Med ABFn minskas forskningstiden genom att länka samman dina koloniers forskningslabb och det högst utvecklade ARN labbets nivå tillgodoräknas samtliga kolonier. <br /><br />För att fungera måste varje koloni kunna forska individuellt.";
$lang['info'][199]['name']        = "Gravitonteknologi";
$lang['info'][199]['description'] = "Gravitonen är budbärarpartikeln för gravitationskraften. Gravitonens vilomassa är lika med noll, dess spinn är 2 och den färdas i ljusets hastighet. Gravitonteknologi används enbart för en sak, att kunna producera den skräckinjagande Titanen.<br><br>Av alla teknologier att forska i, är det denna man löper störst risk för upptäckt vid framställning.";

// ----------------------------------------------------------------------------------------------------------
// Fleet !
$lang['info'][202]['name']        = "Liten Hauler";
$lang['info'][202]['description'] = "The first ship built by any emperor, the small cargo is an agile resource moving ship that has a cargo capacity of 5,000 resource units. This multi-use ship not only has the ability to quickly transport resources between your colonies, but also accompanies larger fleets on raiding missions on enemy targets. [Ship refitted with Impulse Drives once reached level 5]";
$lang['info'][203]['name']        = "Stor Hauler";
$lang['info'][203]['description'] = "As time evolved, the raids on colonies resulted in larger and larger amounts of resources being captured. As a result, Small Cargos were being sent out in mass numbers to compensate for the larger captures. It was quickly learned that a new class of ship was needed to maximize resources captured in raids, yet also be cost effective. After much development, the Large Cargo was born.<br><br>To maximize the resources that can be stored in the holds, this ship has little in the way of weapons or armor. Thanks to the highly developed combustion engine installed, it serves as the most economical resource supplier between planets, and most effective in raids on hostile worlds.";
$lang['info'][204]['name']        = "Lätt Fregatt";
$lang['info'][204]['description'] = "This is the first fighting ship all emperors will build. The light fighter is an agile ship, but vulnerable by themselves. In mass numbers, they can become a great threat to any empire. They are the first to accompany small and large cargo to hostile planets with minor defenses.";
$lang['info'][205]['name']        = "Tung Fregatt";
$lang['info'][205]['description'] = "In developing the heavy fighter, researchers reached a point at which conventional drives no longer provided sufficient performance. In order to move the ship optimally, the impulse drive was used for the first time. This increased the costs, but also opened new possibilities. By using this drive, there was more energy left for weapons and shields; in addition, high-quality materials were used for this new family of fighters. With these changes, the heavy fighter represents a new era in ship technology and is the basis for cruiser technology.<br><br>Slightly larger than the light fighter, the heavy fighter has thicker hulls, providing more protection, and stronger weaponry.";
$lang['info'][206]['name']        = "Kryssare";
$lang['info'][206]['description'] = "With the development of the heavy laser and the ion cannon, light and heavy fighters encountered an alarmingly high number of defeats that increased with each raid. Despite many modifications, weapons strength and armour changes, it could not be increased fast enough to effectively counter these new defensive measures. Therefore, it was decided to build a new class of ship that combined more armor and more firepower. As a result of years of research and development, the Cruiser was born.<br><br>Cruisers are armored almost three times of that of the heavy fighters, and possess more than twice the firepower of any combat ship in existence. They also possess speeds that far surpassed any spacecraft ever made. For almost a century, cruisers dominated the universe. However, with the development of Gauss cannons and plasma turrets, their predominance ended. They are still used today against fighter groups, but not as predominantly as before.";
$lang['info'][207]['name']        = "Slagskepp";
$lang['info'][207]['description'] = "Once it became apparent that the cruiser was losing ground to the increasing number of defense structures it was facing, and with the loss of ships on missions at unacceptable levels, it was decided to build a ship that could face those same type of defense structures with as little loss as possible. After extensive development, the Battleship was born. Built to withstand the largest of battles, the Battleship features large cargo spaces, heavy cannons, and high hyperdrive speed. Once developed, it eventually turned out to be the backbone of every raiding Emperors fleet.";
$lang['info'][208]['name']        = "KoloniseringsskeppColony Ship";
$lang['info'][208]['description'] = "In the 20th Century, Man decided to go for the stars. First, it was landing on the Moon. After that, a space station was built. Mars was colonized soon afterwards. It was soon determined that our growth depended on colonizing other worlds. Scientists and engineers all over the world gathered together to develop mans greatest achievement ever. The Colony Ship is born.<br><br>This ship is used to prepare a newly discovered planet for colonization. Once it arrives at the destination, the ship is instantly transformed into habital living space to assist in populating and mining the new world. 9 Planets maximum can be colonized.";
$lang['info'][209]['name']        = "Skördare";
$lang['info'][209]['description'] = "As space battles became larger and more fierce, the resultant debris fields became too large to gather safely by conventional means. Normal transporters could not get close enough without receiving substantial damage. A solution was developed to this problem. The Recycler.<br><br>Thanks to the new shields and specially built equipment to gather wreckage, gathering debris no longer presented a danger. Each Recycler can gather 20,000 units of debris.";
$lang['info'][210]['name']        = "Spionsond";
$lang['info'][210]['description'] = "Spy probes are small, agile drones that provide data on fleets and planets. Fitted with specially designed engines, it allows them to cover vast distances in only a few minutes. Once in orbit around the target planet, they quickly collect data and transmit the report back via your Deep Space Network for evaluation. But there is a risk to the intelligent gathering aspect. During the time the report is transmitted back to your network, the signal can be detected by the target and the probes can be destroyed.";
$lang['info'][211]['name']        = "Bombskepp";
$lang['info'][211]['description'] = "Over the centuries, as defenses were starting to get larger and more sophisticated, fleets were starting to be destroyed at an alarming rate. It was decided that a new ship was needed to break defenses to ensure maximum results. After years of research and development, the Bomber was created.<br><br>Using laser-guided targeting equipment and Plasma Bombs, the Bomber seeks out and destroys any defense mechanism it can find. As soon as the hyperspace drive is developed to Level 8, the Bomber is retrofitted with the hyperspace engine and can fly at higher speeds.";
$lang['info'][212]['name']        = "Solar Satellit";
$lang['info'][212]['description'] = "It quickly became apparent that more energy was needed to power larger mines then could be produced by conventional ground based solar planets and fusion reactors. Scientists worked on the problem and discovered a method of transmitting electrical energy to the colony using specially designed satellites in geosynchronous orbit.<br><br>Solar Satellites gather solar energy and transmit it to a ground station using advanced laser technology. The efficiency of a solar satellite depends on the strength of the solar radiation it receives. In principle, energy production in orbits closer to the sun is greater than for planets in orbits distant from the sun. Since the satellites primary goal is the transmission of energy, they lack shielding and weapons capability, and because of this they are usually destroyed in large numbers in a major battle. However they do possess a small self-defense mechanism to defend itself in an Spy mission from an enemy empire if the mission is detected.";
$lang['info'][213]['name']        = "Jagare";
$lang['info'][213]['description'] = "The Destroyer is the result of years of work and development. With the development of Titans, it was decided that a class of ship was needed to defend against such a massive weapon.Thanks to its improved homing sensors, multi-phalanx Ion cannons, Gauss Cannons and Plasma Turrets, the Destroyer turned out to be one of the most fearsome ships created.<br><br>Because the destroyer is very large, its maneuverability is severely limited, which makes it more of a battle station than a fighting ship. The lack of maneuverability is made up for by its sheer firepower, but it also costs significant amounts of deuterium to build and operate.";
$lang['info'][214]['name']        = "Titan";
$lang['info'][214]['description'] = "The Titan is the ultimate ship ever created. This moon sized ship is the only ship that can be seen with the naked eye on the ground. By the time you spot it, unfortunately, it is too late to do anything.<br><br>Armed with a gigantic graviton cannon, the most advanced weapons system ever created in the Universe, this massive ship has not only the capability of destroying entire fleets and defenses, but also has the capability of destroying entire moons. Only the most advanced empires have the capability to build a ship of this mammoth size.";
$lang['info'][215]['name']        = "Slagkryssare";
$lang['info'][215]['description'] = "This ship is one of the most advanced fighting ships ever to be developed, and is particularly deadly when it comes to destroying attacking fleets. With its improved laser cannons on board and advanced Hyperspace engine, the Battlecruiser is a serious force to be dealt with in any attack.<br><br>Due to the ships design and its large weapons system, the cargo holds had to be cut, but this is compensated for by the lowered fuel consumption.";
$lang['info'][216]['name']        = "Supernova";
$lang['info'][216]['description'] = "Detta skeppet är det ultimata planetförgöraren. Ett måste för alla Imperium. ";
$lang['info'][217]['name']        = "Moderskepp";
$lang['info'][217]['description'] = "Detta är egentligen inget skepp, det är en mindre planet. Det är långsamt och dyrt men handhar sådan eldkraft att ingen flotta kan vara utan. Dess massiva lastutrymme gör så att det kan försörja vilken flotta som helst oavsett antal skepp. ";

// ----------------------------------------------------------------------------------------------------------
// Defense !
$lang['info'][401]['name']        = "Raketramp";
$lang['info'][401]['description'] = "Dessa är det första och svagaste försvaret du kommer tillverka. Dessa består av simpla markbaserade avfyrningsrampers som skjuter konventionella stridsspetsar mot attackerande flottor. Då de är billiga att bygga och det behövs ingen forskning, så är dom utmärkta i sitt försvar mot räder, men är sämre med att försvara under längre pågående och ihållande strider som tex i krig.<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][402]['name']        = "Lätt Laser";
$lang['info'][402]['description'] = "När mer avancerade och sofistikerade skepp utvecklades, fastslogs det att försvar behövdes mot dessa. Då Laserteknologin utvecklades i allt mer rask takt, kunde man också utveckla bättre vapen att användas som försvar. För att göra dessa lasertorn mer konstnadseffektiva, utrustades de med ett förstärkt sköldsystem, dock med samma strukturella intergritet som Raketramperna.<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][403]['name']        = "Tung Laser";
$lang['info'][403]['description'] = "Den Tunga Lasern är en förbättrad och mer balanserad version av den Lätta Lasern. Den har uppgraderats med förstärkta komposit legeringar, starkare och tätare strålar, även ett bättre målsökningssystem.<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][404]['name']        = "Gausskanon";
$lang['info'][404]['description'] = "Är ett bra försvar mot fiendens armador. Det är dyrare än sina föregångare men också mycket mer effektiv när det gäller eldkraft och sköldstyrka. Det har jämförts med Plasmakanonen, har dock inte samma eldkraft mot dom största skeppen. Gausskanonen skjuter metall projektiler, som har en extremt tät massa, i en enorm hastighet.<br><br>Detta vapnet är så kraftfullt när det avfyras att det skapar en ljudknall som kan höras på flera mil, besättningen är tvingad att ta speciella motgärder mot den kraftfulla tryckvågen som skapas.";
$lang['info'][405]['name']        = "Jonkanon";
$lang['info'][405]['description'] = "En jonkanon är ett strålvapen som skjuter strålar av joner (partiklar, till exempel atomer som har manipulerats på så sätt att de fått en elektrisk laddning), det skapar ett fenomen som också kallas Elektromagnetisk Puls (EMP effekt). Denna kanonen har ett högt utvecklat sköldsystem och skyddar därför ditt försvar bättre.<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][406]['name']        = "Plasmakanon";
$lang['info'][406]['description'] = "Ett av dom mest avancerade vapensystemen någonsin tillverkade. Plasmakanonen avnänder en stor nukleär reaktor för att driva en elektromagnetisk accelerator som skickar en puls, eller toroid, av plasma. Inledningsfasen till avfyrandet börjar med att Plasmakanonen låser sitt mål, en plasma sfär skapas i kanonens kärna genom att utsätta gaser för extrem hetta och kompression, vilket tömmer dem på joner. Väl en sfär har skapats, skickas den vidare in i den elektromagnetiska acceleratorn. Acceleratorn aktiveras sedan och plasma sfären skickas då iväg i en extrem hastighet mot målet. Ur ditt måls perspektiv är den ankommande blåaktiga kulan av plasma väldigt imponerande, men när den väl träffar innebär det omedelbar förintelse.<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][407]['name']        = "Liten Sköldkupol";
$lang['info'][407]['description'] = "Kolonisering av nya världar innebar en ny fara, rymdskrot/skräp. En stor asteroid kunde lätt ödelägga en hel värld. Framsteg i utvecklandet av sköldteknologin gav vetenskapsmän ett sätt att forska fram ett skydd för en hel planet mot, inte bara rymdskrot/skräp, utan även fientliga attacker. Dock är skölden inget bra försvar i längre pågående attackar likt i krig, då den inte har likvärdig styrka att motstå påfrestning under en längre tid.<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][408]['name']        = "Stor Sköldkupol";
$lang['info'][408]['description'] = "Nästa steg i utvecklandet av planetära sköldar är den Stora Sköldkupolen. Den är byggd för att motstå större eldkraft under längre tid av starkare vapen<br><br>Efter en strid är det upp till 70% chans att felaktiga ramper kan användas igen.";
$lang['info'][409]['name']        = "Planet Försvar";
$lang['info'][409]['description'] = "Ultimata försvaret för en planet.";
// ----------------------------------------------------------------------------------------------------------
// Missiles !
$lang['info'][502]['name']        = "Anti-Ballistiska Missiler";
$lang['info'][502]['description'] = "Anti-Ballistiska Missiler (ABM) är ditt enda försvar gentemot Interplanetära Missiler (IPM). När en avfyrning av en IPM upptäcks, armeras ABM automatiskt och påbörjar en avfyrningssekvens i sina flygdatorer. Målet låses och missilen avfyras. Vid inflygning mot sitt mål spåras IPM konstant och kurskorrigeringar utförs realtid tills APM når sitt mål.<br><br>För varje uppgraderad nivå kan 10 ABMr, 5 IPMr eller en kombination av de 2, förvaras i missilsilon.";
$lang['info'][503]['name']        = "Interplanetära Missiler";
$lang['info'][503]['description'] = "Interplanetära Missiler (IPM) är det val av vapen för att förstöra dina fienders basförsvar. De använder senaste målsökningstekniken och varje missil har ett visst antal olika försvar att skydda sig med. Bestyckad med en antimateriabomb som levererar en så förgörande kraft att en sköld eller försvar som blir träffat, inte kan repareras igen. Enda åtgärden mot dessa missiler är APMr.<br><br>För varje uppgraderad nivå kan 10 ABMr, 5 IPMr eller en kombination av de 2, förvaras i missilsilon.";

// ----------------------------------------------------------------------------------------------------------
// Officiers !
$lang['info'][601]['name']        = "Geolog";
$lang['info'][601]['description'] = "Geologen är en expert i astro-mineralogi och kristallografi. Han assisterar sitt team i metallurgi och kemi, han tar också hand om den interplanetäriska kommunikationen optimerar användandet och raffineringen av råmaterial i emperiet. Användandet av den absolut senaste tekniska utrustningen för mätning och kartläggning, Geologen kan hitta dom optimala områdena för gruvdrift och utvinning av metall. <br><br><font color=red>+5% gruvdriftsutvinning per nivå. Max nivå: 20</font>";
$lang['info'][602]['name']        = "Amiral";
$lang['info'][602]['description'] = "Amiralen är en krigsveteran och fruktad strateg. Även när striden tycks outhärdlig är han kall och effektiv och har fullständig kontroll på flottan och Flottiljamiralerna under honom. <br><br><font color=red>+5% extra sköld per nivå. Max nivå. : 20</font>";
$lang['info'][603]['name']        = "Ingenjör";
$lang['info'][603]['description'] = "Ingenjören är specialiserad på energiproduktion/förbrukning. I fredstid maximeras effektiviteten mellan dom olika koloniernas energinätverk.<br><br><font color=red>+5% energi per nivå. Max nivå: 10</font>";
$lang['info'][604]['name']        = "Teknokrat";
$lang['info'][604]['description'] = "Teknokraternas samfund är erkända vetenskapliga geni. Dom finns där teknologiers gränser ställs på sin spets. Det finns ingen som kan dekryptera en Teknokrats kod, hans blotta närhet inspirerar forstkare i Imperiet.<br><br><font color=red>Ökar tillverkningshastigheten på skepp med 5% per nivå. Max nivå: 10</font>";
$lang['info'][605]['name']        = "Tillverkare";
$lang['info'][605]['description'] = "Tillverkaren är en ny typ av hantverkare. Hans DNA är modifierat så att han ges en enorm övermänsklig råstyrka. Endast dessa \"män\" kan bygga städer tillräckliga för ett Imperium.<br><br><font color=red>Ökar tillverkningshastigheten med 10% på byggnader per nivå. Max nivå: 3</font>";
$lang['info'][606]['name']        = "Forskare";
$lang['info'][606]['description'] = "Forskaren tillhör ett liknande samfund som Teknokraternas. Men Forskaren är mer involverade i att utveckla teknologier.<br><br><font color=red>Ökar forskningshastigheten med 10% per nivå. Max nivå: 3</font>";
$lang['info'][607]['name']        = "Lagerhållare";
$lang['info'][607]['description'] = "Lagerhållaren tillhör fd. \"Brödraskapet\" från planeten Hsac. Hans motto är \"den som spar han har\" men på grund av den anledningen behövs ett kunnande i resurshantering. Tillsammans med Tillverkaren använder dom sig av en avancerad logistik som möjliggör extra utrymme.<br><br><font color=red>Lagerkapaciteten ökas med +50% per nivå. Max nivå: 2</font>";
$lang['info'][608]['name']        = "Försvarare";
$lang['info'][608]['description'] = "Försvararen är medlem i den Imperialistiska Armén. Hans dedikering till sitt arbete gör att han kan bygga ett formidabelt försvar på kort tid.<br><br><font color=red>Ökar tillverkningshastigheten med 50% av försvarsmateriell per nivå. Max nivå: 2</font>";
$lang['info'][609]['name']        = "Bunker";
$lang['info'][609]['description'] = "Kejsaren är imponerad av ditt arbete du har gjort för Imperiet. För att tacka dig för dina insatser vill Kejsaren att du mottar hedersbetygelsen \"Bunker\". Bunkern är den högsta utmärkelsen i gruvdriftssekton av Imperialistka Armén.<br><br><font color=red>Låser upp Planetförsvar</font>";
$lang['info'][610]['name']        = "Spion";
$lang['info'][610]['description'] = "Spionen är en enigmatisk person. Ingen har sett hans sanna ansikte och överlevt. <br><br><font color=red>+5 Spionage per nivå. Max nivå: 2</font>";
$lang['info'][611]['name']        = "Kommendör";
$lang['info'][611]['description'] = "Kommendören i den imperialistiska flottan bemästrar konsten i hantering av flottiljer. Han kan räkna ut avancerade färdplaner på flera flottiljer samtidigt.<br><br><font color=red>+3 flottiljer platser per nivå. Max nivå: 2</font> ";
$lang['info'][612]['name']        = "Skarprättare";
$lang['info'][612]['description'] = "Skarprättaren är en hänsynslös officer. Han massakrerar hela planeter för sitt eget nöjes skull. Han håller i utvecklandet av Titaner.<br><br><font color=red>2 Titaner byggs istället för en.</font>";
$lang['info'][613]['name']        = "General";
$lang['info'][613]['description'] = "Den ärevördige Generalen är en person som har tjänstgjort i flottan under många år. Hantverkare och tillverkare av skepp arbetar fortare i hans närhet.<br><br><font color=red>Ökar tillverkningshastigheten med +25% av skeppsbyggandet per nivå. Max nivå: 3</font>";
$lang['info'][614]['name']        = "Imperialistisk Erövrare";
$lang['info'][614]['description'] = "Kejsaren erkänner otvivelaktigt dig som Imperialistisk Erövrare. Imperialistisk Erövrare är den högsta utmärkelsen inom Imperiet<br><br><font color=red>Låser upp SuperNovan</font>";
$lang['info'][615]['name']        = "Kejsare";
$lang['info'][615]['description'] = "Du har visat att du är den mäktigaste och största erövraren i Imperiet. Nu har tiden kommit för dig att ta din rättmätiga plats.<br><br><font color=red>Låser upp Moderskepp</font>";

?>