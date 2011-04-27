<?php

// ----------------------------------------------------------------------------------------------------------
// Interface !
$lang['nfo_page_title']  = "Informação";
$lang['nfo_title_head']  = "Informação relativa";
$lang['nfo_name']        = "Nome";
$lang['nfo_destroy']     = "Destruir";
$lang['nfo_level']       = "Nível";
$lang['nfo_range']       = "Alcance";
$lang['nfo_used_energy'] = "Consumo de energia";
$lang['nfo_used_deuter'] = "Consumo de deutério";
$lang['nfo_prod_energy'] = "Produção de energia";
$lang['nfo_difference']  = "Diferença";
$lang['nfo_prod_p_hour'] = "Produção por hora";
$lang['nfo_needed']      = "Necessita";
$lang['nfo_dest_durati'] = "Duração da destruição";

$lang['nfo_struct_pt']   = "Pontos de edifícios";
$lang['nfo_shielf_pt']   = "Pontos de defesas";
$lang['nfo_attack_pt']   = "Valor do ataque";
$lang['nfo_rf_again']    = "RapidFire contra";
$lang['nfo_rf_from']     = "RapidFire de";
$lang['nfo_capacity']    = "Capacidade da frota";
$lang['nfo_units']       = "Unidades";
$lang['nfo_base_speed']  = "Velocidade base";
$lang['nfo_consumption'] = "Consumo de deutério";

// ----------------------------------------------------------------------------------------------------------
// Interface porte de saut
$lang['gate_start_moon'] = "Lua de partida";
$lang['gate_dest_moon']  = "Lua de destino:";
$lang['gate_use_gate']   = "Utilizar o portal de salto quântico";
$lang['gate_ship_sel']   = "Selécção da frota";
$lang['gate_ship_dispo'] = "disponível";
$lang['gate_jump_btn']   = "Saltar";
$lang['gate_jump_done']  = "O salto foi efectuado com sucesso. Próximo salto disponível em: ";
$lang['gate_wait_dest']  = "Os carregadores de energia do portal de salto quântico de destino ainda não recarregaram! Tempo de espera: ";
$lang['gate_no_dest_g']  = "Não existe portal de salto quântico no planeta de destino!";
$lang['gate_wait_star']  = "Os carregadores de energia do portal de salto quântico de origem ainda não recarregaram! Tempo de espera: ";
$lang['gate_wait_data']  = "Erro: não existe portal de salto quântico!";

// ----------------------------------------------------------------------------------------------------------
// Batiments Mines!
$lang['info'][1]['name']          = "Mina de Metal";
$lang['info'][1]['description']   = "As minas de metal constituem o principal produtor de matéria-prima para a construção de edifícios e de naves espaciais. O metal é o material mais barato mas também o mais utilizado. A produção de metal necessita pouca energia. O metal encontra-se a grandes profundidades na maioria dos planetas. A evolução de uma mina de metal tornará a mina maior, mais profunda, aumentando a produção.";
$lang['info'][2]['name']          = "Mina de Cristal";
$lang['info'][2]['description']   = "As minas de cristal constituem o principal produtor de matéria-prima para a elaboração de circuitos eléctricos e na estrutura dos componentes de ligas. A produção de cristal necessita o dobro da energia comparado com a produção de metal, assim o cristal é um material mais caro. Todos os edifícios e naves espaciais utilizam cristal, infelizmente o cristal é raro e só se encontra em grandes profundidades. Para aumentar a produção de cristal e assim obter cristais maiores e mais puros é indispensável evoluir as minas de cristal.";
$lang['info'][3]['name']          = "Extractor de Deutério";
$lang['info'][3]['description']   = "O deutério é água pesada - o núcleo do hidrogénio contém um neutrão adicional, sendo um excelente combustível para as naves devido ao elevado rendimento energético da reacção. O deutério pode ser encontrado frequentemente no mar profundo devido ao seu peso molecular. Evoluir o extractor de deutério permite recolher maior quantidade deste recurso.";

// ----------------------------------------------------------------------------------------------------------
// Batiments Energie!
$lang['info'][4]['name']          = "Planta de Energia Solar";
$lang['info'][4]['description']   = "Para fornecer a energia necessária ao bom funcionamento das minas, são necessárias grandes plantas de energia solar. A planta de energia solar é uma das maneiras para criar energia. A superfície das células fotovoltaicas, capazes de transformar a energia solar em energia eléctrica, aumenta com a evolução da planta de energia solar. A planta de energia solar é uma estrutura indispensável para o estabelecimento e uso de energia num planeta.";
$lang['info'][12]['name']         = "Planta de Fusão";
$lang['info'][12]['description']  = "Em plantas de fusão, os núcleos de hidrogénio são fundidos em núcleos de hélio sobre uma enorme temperatura e pressão, libertando uma quantidade enorme de energia. Para cada grama de Deutério consumido, pode ser produzido até 41,32*10^-13 joules de energia; Com 1g és capaz de produzir 172MWh de energia.<br/><br/>Maiores reactores usam mais deutério e podem produzir mais energia por hora. O efeito da energia pode ser aumentado pesquisando a tecnologia de energia.<br/><br/>A produção de energia da planta de fusão é calculada da seguinte forma:</br>30 * [Nível da planta de fusão] * (1,05 + [Nível da tecnologia de energia] * 0,01) ^ [Nível da planta de fusão]";

// ----------------------------------------------------------------------------------------------------------
// Edifícios normais!
$lang['info'][14]['name']         = "Fábrica de Robots";
$lang['info'][14]['description']  = "A fábrica de robots fornece unidades baratas e competentes na construção que podem ser usadas para construir ou promover toda a estrutura planetária. Cada evolução para o nível superior desta fábrica aumenta a eficiência e o número das unidades que ajudam e diminuem o tempo de construção.";
$lang['info'][15]['name']         = "Fábrica de Nanites";
$lang['info'][15]['description']  = "Os nanites são unidades robóticas minúsculas com um tamanho médio apenas de alguns nanómetros. Estes micróbios mecânicos são ligados entre si e programados para uma tarefa da construção, oferecendo assim uma velocidade de construção única. Os nanites operam a nível molecular, cada evolução reduz para metade o tempo de construção dos edifícios, das naves espaciais e das estruturas planetárias de defesa.";
$lang['info'][21]['name']         = "Hangar";
$lang['info'][21]['description']  = "O hangar é responsável pela construção de naves espaciais e de sistemas de defesa. A evolução do hangar permite a produção de uma mais larga variedade de naves e de sistemas de defesa e a diminuição do tempo de construção.";
$lang['info'][22]['name']         = "Armazém de Metal";
$lang['info'][22]['description']  = "Cada evolução do armazém de metal permite o aumento da capacidade de armazenamento. Se a capacidade máxima do armazém é atingida, a produção de metal é interrompida.";
$lang['info'][23]['name']         = "Armazém de Cristal";
$lang['info'][23]['description']  = "Cada evolução do armazém de cristal permite o aumento da capacidade de armazenamento. Se a capacidade máxima do armazém é atingida, a produção de cristal é interrompida.";
$lang['info'][24]['name']         = "Tanque de Deutério";
$lang['info'][24]['description']  = "Os tanques de deutério são tanques de armazenamento enormes. Estes tanques encontram-se frequentemente perto dos hangares planetários, sendo o deutério usado como combustível. Uma vez que a capacidade máxima de tanque é atingida, a produção de deutério é interrompida.";
$lang['info'][31]['name']         = "Laboratório de Pesquisas";
$lang['info'][31]['description']  = "Para ser capaz de pesquisar e evoluir na área das tecnologias, é necessária a construção de um laboratório de pesquisas. A evolução do nível do laboratório aumenta a velocidade de aprendizagem das tecnologias, mas abre também ao ensino e pesquisa de novas tecnologias. De maneira a poder realizar a pesquisa o mais rapidamente possível, os científicos escolhem o planeta mais evoluído e regressam depois ao planeta de origem com o conhecimento. De esta forma, é possível introduzir as novas tecnologias em todos os planetas do império e oferece novas pesquisas.";
$lang['info'][33]['name']         = "Terra-Formador";
$lang['info'][33]['description']  = "O Terra-Formador permite aumentar o número de áreas disponíveis para construção do planeta. Graças a este processo, um planeta pode aumentar a sua capacidade, e espaço. Com o tempo, o espaço tende a ser insuficiente e vários métodos já utilizados eram insuficientes ou inúteis a longo prazo.<br/>Um grupo de cientistas e nano-tecnicos encontraram uma solução: Criar e formar Terra (Terra-Formador).<br/>Com muita energia, é possivel criar continentos inteiros!<br/>Nanitas especiais são produzidos neste edifício para assegurar a qualidade e a usabilidade das áreas formadas pelo Terra-Formador.";
$lang['info'][34]['name']         = "Depósito da Aliança";
$lang['info'][34]['description']  = "O depósito da aliança permite às frotas da aliança a possibilidade de reabastecer. Cada evolução do depósito fornece às frotas em órbita 10.000 unidades adicionais de deutério por hora.";

// ----------------------------------------------------------------------------------------------------------
// Edifícios especiais!
$lang['info'][41]['name']         = "Base Lunar";
$lang['info'][41]['description']  = "Sabendo que uma lua não possui atmosfera, uma base lunar é necessaria para criar um espaço habitável. A base lunar fornece oxigenio mas também gravitação artificial, e proteção. Cada evolução da base lunar aumenta o tamanho da área para construção de estruturas. Cada nível fornece 3 campos lunares, até a lua estar cheia.";
$lang['info'][42]['name']         = "Sensor Phalanx";
$lang['info'][42]['description']  = "Um dispositivo de alta resolução do sensor é utilizado para espiar um espectro de frequência. As variações de energia mostram informações sobre o movimento de frotas. Para realizar uma varredura é necessária uma quantidade de energia sob forma de deutério disponível na lua.";
$lang['info'][43]['name']         = "Portal de Salto Quântico";
$lang['info'][43]['description']  = "O Portal de Salto Quântico é um transceptor enorme capaz de transportar instantaneamente uma frota inteira para outro portal de salto. O transmissor não necessita de Deutério para funcionar, mas precisa de arrefecer durante 1 hora entre saltos. Não é possível transportar recursos pelo portal. Todo o equipamento é feito de tecnologia de ponta.";

$lang['info'][44]['name']         = "Silo de Mísseis";
$lang['info'][44]['description']  = "O silo de mísseis é a estrutura de lançamento e armazenamento dos mísseis. Tem o espaço para 5 mísseis interplanetários ou 10 mísseis de intercepção por cada nível evoluído.";

// ----------------------------------------------------------------------------------------------------------
// Laboratoire !
$lang['info'][106]['name']        = "Tecnologia de Espionagem";
$lang['info'][106]['description'] = "A tecnologia de espionagem resulta de pesquisas sobre sensores de dados, equipamento e conhecimento da inteligência de que um império necessita para se proteger de ataques, mas também para dirigir ataques contra o inimigo. A evolução desta tecnologia aumenta os detalhes, e informações obtidos.<br/><br/>O resultado de espionagem depende também da força e do nível de espionagem do jogador adverso. A evolução do nível da tecnologia de espionagem define também o nível dos detalhes sobre uma frota que se aproxima do teu planeta:<br/>- Nível 2 adiciona o número de naves à informação sobre a frota;<br/>- Nível 4 adiciona o tipo das naves que se aproximam;<br/>- Nível 8 adiciona finalmente detalhes sobre o tipo e o número de naves que se aproximam.</br><br/>Em geral, a tecnologia de espionagem é muito importante para um império, seja ele agressivo ou amigável. Conselho: começar a pesquisar esta área tecnológica logo depois de ter à sua disposição as primeiras naves de transporte.";
$lang['info'][108]['name']        = "Tecnologia de Computadores";
$lang['info'][108]['description'] = "A informática é utilizada para construir processos de dados cada vez mais evoluídos e controlar unidades. Cada evolução desta tecnologia aumenta o número de frotas que podem ser comandadas em mesmo tempo. Aumentando esta tecnologia, permite mais actividade e assim um melhor rendimento, isso tomando em conta as frotas militares assim como transportes de carga e espionagem. Será uma boa ideia aumentar constantemente a pesquisa nesta área para fornecer uma flexibilidade adequada ao império.";
$lang['info'][109]['name']        = "Tecnologia de Armas";
$lang['info'][109]['description'] = "A tecnologia de armas trata do desenvolvimento dos sistemas de armas existentes. é focalizada principalmente no aumento do poder e da eficiência das armas.<br/>Com esta tecnologia, e aumentando o seu nível, a mesma arma tem mais poder e causa mais danos - cada nível aumenta o poder de fogo em 10%.<br/>A tecnologia de armas é importante permanecer a um nível elevado, para não facilitar a tarefa dos inimigos.";
$lang['info'][110]['name']        = "Tecnologia de Escudo";
$lang['info'][110]['description'] = "A tecnologia de escudo é utilizada para criar um escudo protector. Cada evolução do nível desta tecnologia aumenta a protecção em 10%. O nível do melhoramento aumenta basicamente a quantidade de energia que o escudo pode absorver antes de ser destruido. Esta tecnologia não só aumenta a qualidade dos escudos das naves, como também do escudo protector planetário.";
$lang['info'][111]['name']        = "Tecnologia de Blindagem";
$lang['info'][111]['description'] = "Para uma dada liga que provou ser eficaz, a estrutura molecular pode ser alterada de maneira a manipular o seu comportamento numa situação de combate e incorporar as realizações tecnológicas. Cada evolução do nível desta tecnologia aumenta a blindagem em 10%.";
$lang['info'][113]['name']        = "Tecnologia de Energia";
$lang['info'][113]['description'] = "A tecnologia da energia trata do conhecimento das fontes de energia, das soluções de armazenamento e das tecnologias que fornecem o que é mais básico: Energia. São necessários determinados níveis de evolução desta tecnologia para permitir o acesso a novas tecnologias que confiam no conhecimento da energia.";
$lang['info'][114]['name']        = "Tecnologia de Hiperespaço";
$lang['info'][114]['description'] = "A tecnologia de hiperespaço fornece o conhecimento para as viagens no hiperespaço utilizadas por muitas naves de guerra. é uma nova e complicada espécie de tecnologia que requer um equipamento caro de laboratório e facilidades de testes.";
$lang['info'][115]['name']        = "Motor de Combustão";
$lang['info'][115]['description'] = "Os motores de combustão pertencem aos motores antigos e são baseados na repulsão. As partículas são aceleradas deixando o motor criar uma força repulsiva que move a nave no sentido oposto. A eficiência destes motores de combustão é baixa, mas são baratos e de confiança.<br/>Pesquisar e evoluir esta tecnologia aumenta a velocidade de combustão dos motores e assim a velocidade das naves, cada evolução aumenta a velocidade em 10%. Esta tecnologia é de grande importância para um império emergente, e deve ser pesquisado o mais cedo possível.";
$lang['info'][117]['name']        = "Motor de Impulsão";
$lang['info'][117]['description'] = "Uma grande parte de matéria repulsada resulta em restos e lixo, criados pela fusão nuclear. Cada evolução desta tecnologia aumenta em 20% a velocidade das naves mais pesadas como o cruzador, bombardeiro, caça pesado e nave de colonização. Os motores de impulsão são um desenvolvimento adicional aos motores de combustão, aumentam a eficiência e abaixam o consumo de combustível relativo à velocidade.";
$lang['info'][118]['name']        = "Motor Propulsor de Hiperespaço";
$lang['info'][118]['description'] = "O motor propulsor é baseado na curvatura do espaço-tempo. Desta maneira, o ambiente das naves que utilizam este motor propulsor comprime-se, permitindo que as naves percorram grandes distâncias em muito pouco tempo. A evolução do motor propulsor aumenta a velocidade de algumas naves em 30%. Requesitos: Tecnologia de Hiperespaço (Nível 3) Laboratório de Pesquisa (Nível 7).";
$lang['info'][120]['name']        = "Tecnologia Laser";
$lang['info'][120]['description'] = "O laser (amplificação de luz pela emissão estimulada da radiação) cria um raio intenso de luz, que concentra uma grande quantidade de energia. O laser tem várias áreas de aplicação como os sistemas ópticos de computadores, e as armas com alto poder destructivo. O conhecimento desta tecnologia é fundamental para a investigação de novas armas.<br/>Requisitos: Laboratório de Pesquisas (Nível 1) Tecnologia de Energia (Nível 2).";
$lang['info'][121]['name']        = "Tecnologia de Iões";
$lang['info'][121]['description'] = "Ao acelerar iões um raio letal é criado, e causa danos importantes aos objectos que atinge.";
$lang['info'][122]['name']        = "Tecnologia de Plasma";
$lang['info'][122]['description'] = "Tecnologia mais avançada que a tecnologia de iões, em vez de acelerar iões, acelera-se o plasma com um grande poder energético, desta forma cria-se um raio que ocasiona danos enormes aos objectos que atinge.";
$lang['info'][123]['name']        = "Rede Intergaláctica de Pesquisas";
$lang['info'][123]['description'] = "Os cientistas dos teus planetas podem comunicar uns com os outros graças a esta rede.<br/>No nível 0, terás apenas o benefício de ligar o satélite ao teu laboratório de pesquisas mais evoluído. Com o nível 1, ligarás os 2 laboratórios mais evoluídos. Cada nível acrescenta mais um laboratório. Desta maneira, as pesquisas serão efectuadas com a máxima velocidade.";
$lang['info'][124]['name']        = "Tecnologia de Exploração Espacial";
$lang['info'][124]['description'] = "A tecnologia de Exploração Espacial inclui formas de pesquisa à distância e permite o uso de módulos de pesquisa nas naves, estes últimos são compostos por uma base de dados funcional num laboratório móvel. Para assegurar a segurança destas naves durante situações de pesquisa extremas, o módulo contém o seu próprio sistema de energia que cria um poderoso campo de forças à volta do módulo durante uma emergência.";
$lang['info'][199]['name']        = "Tecnologia de Gravitação";
$lang['info'][199]['description'] = "Um gráviton é uma partícula elementar responsável pelos efeitos da gravitação. Com o aceleramento de partículas gravitacionais, um campo gravitacional artificial é criado com uma força atractiva que pode não só destruir naves mas também luas inteiras. De maneira a produzir a quantidade necessária de partículas de gravitação, o planeta tem que poder criar uma quantidade maciça de energia. Requisitos: Laboratório de Pesquisas (Nível 12).";

// ----------------------------------------------------------------------------------------------------------
// Flotte !
$lang['info'][202]['name']        = "Cargueiro Pequeno";
$lang['info'][202]['description'] = "Estas naves são aproximadamente do tamanho de uma nave de combate, mas não são equipadas nem com motores nem com armamento de combate, para deixar mais espaço para os recursos a transportar. O cargueiro pequeno pode transportar até 5.000 unidades de recursos.<br/>A velocidade básica dos teus cargueiros pequenos é aumentada logo que a tecnologia de impulsão nível 5 for pesquisada, já que ficam equipados com motores de impulsão.";
$lang['info'][203]['name']        = "Cargueiro Grande";
$lang['info'][203]['description'] = "Esta nave não deve atacar sozinha, pois a sua estrutura não lhe permite resistrir muito tempo aos sistemas de defesa. O seu motor de combustão altamente sofisticado permite-lhe ser um fornecedor rápido do recursos. Normalmente, acompanha as frotas em invasões a planetas para capturar e roubar recursos ao inimigo.";
$lang['info'][204]['name']        = "Caça Ligeiro";
$lang['info'][204]['description'] = "Considerando a sua estrutura, agilidade e alta velocidade, o caça ligeiro pode ser definido como uma boa arma no principio do jogo, e um bom acompanhante para as naves mais sofisticadas e poderosas.";
$lang['info'][205]['name']        = "Caça Pesado";
$lang['info'][205]['description'] = "Durante a evolução do caça ligeiro os investigadores chegaram ao ponto onde a tecnologia convencional alcança os seus limites. De maneira a fornecer agilidade ao novo caça, um poderoso motor de impulsão foi usado pela primeira vez. Apesar dos custos e da complexidade adicionais, novas possibilidades tornaram-se disponíveis. Com o uso da tecnologia de impulsão e a integridade estrutural aumentada, foi possível dar ao caça pesado um sistema de armas e uma resistência necessitando mais energia transformando a nave numa verdadeira ameaça para o inimigo.";
$lang['info'][206]['name']        = "Cruzador";
$lang['info'][206]['description'] = "Com os lasers pesados e os canhões do iões que emergem nos campos de batalha, as naves básicas de combate encontravam cada vez mais em dificuldade. Apesar de muitas modificações nos sistemas de arma estas naves não podiam ser aumentadas ou evoluidas bastante para poder rivalizar com os novos sistemas de defesa.<br/>Por esta razão, foi decidido desenvolver uma nova nave, poderosa e com sistemas de armas devastadores. Nasceu então o cruzador.<br/>Os cruzadores possuem um sistema de armas três vezes mais poderoso do que aquele encontrado no caça pesado e uma velocidade de tiro aumentada. A velocidade do cruzador é a mais rápida já vista. Infelizmente, com o aparecimento mais tarde dos novos e mais fortes sistemas de defesa como os canhões de Gauss e os lançadores de plasma, o domínio dos cruzadores acabou. O cruzador tem RapidFire(10) contra os lançadores de mísseis e contra os caças ligeiros, isso quer dizer que um cruzador destrói sempre mais de um míssil ou caça ligeiro a cada round.";
$lang['info'][207]['name']        = "Nave de Batalha";
$lang['info'][207]['description'] = "As naves de batalha constituem a espinha dorsal de qualquer frota militar. Os sistemas de armas poderosos e a resistência inigualável da nave de batalha adicionados à alta velocidade e à capacidade de carga importante fazem desta nave um perigo constante, em qualquer situação e contra qualquer oponente.";
$lang['info'][208]['name']        = "Nave de Colonização";
$lang['info'][208]['description'] = "Esta nave permite colonizar novos planetas, outros mundos, onde nenhum homem ainda se aventurou no passado. Um império pode possuir até 8 colónias. As naves de colonização têm dupla utilização. Podem servir como cargueiros (não recomendado pela sua lentidão), e como naves de colonização. Se pretendes colonizar um planeta, não envies recursos com a nave de colonização, pois estes serão perdidos.";
$lang['info'][209]['name']        = "Reciclador";
$lang['info'][209]['description'] = "Os combates no espaço parecem tornar-se cada vez mais impressionantes onde numa única batalha milhares de naves podem ser destruídas, e os restos perdidos para sempre. Os cargueiros não têm os meios para recolher esses recursos valiosos.<br/>Com o desenvolvimento das naves espaciais, veio a ser possível recolher aqueles campos de ruínas. Um reciclador é do tamanho de um cargueiro grande e tem uma capacidade de armazenamento limitada de 20.000 unidades.";
$lang['info'][210]['name']        = "Sonda de Espionagem";
$lang['info'][210]['description'] = "As sondas de espionagem são drones com uma rapidez impressionante de propulsão utilizados para espiar os inimigos. Com um sistema de comunicação altamente avançado as sondas podem emitir dados a grande distância.<br/>Quando chegam ao planeta alvo, as sondas permanecem na orbita de maneira a recolher os dados do planeta. Durante esse período é relativamente fácil detectá-las. Uma vez detectadas, devido à fraqueza da sua estrutura, as sondas não podem resistir muito tempo aos tiros dos sistemas de defesa, e são rapidamente destruidas.<br/>Para que o tempo de permanencia em órbita seja o mais reduzido possível, é conveniente ter uma Tecnologia de Espionagem bem desenvolvida.";
$lang['info'][211]['name']        = "Bombardeiro";
$lang['info'][211]['description'] = "O bombardeiro é uma nave espacial desenvolvida para destruir os sistemas de defesa planetários mais recentes e poderosos. Dotado de um sistema de escolha de alvo guiado ao laser, e de bombas de plasma, o bombardeiro é uma arma destrutiva.<br/>A velocidade básica dos teus bombardeiros é aumentada assim que seja pesquisado o motor de hiperespaço nível 8, já que ficam equipadas com o motor de hiperespaço.";
$lang['info'][212]['name']        = "Satélite Solar";
$lang['info'][212]['description'] = "Os satélites solares são satélites simples situados na órbita de um planeta, equipados de células fotovoltaicas, capazes de transferir energia para o planeta. A energia é transmitida ao planeta graças a um feixe de laser especial.<br/>Estes satélites são uma ajuda ao nível da procura de energia, mas não resistem aos tiros das naves inimigas, e desta maneira a perda de os satélites pode ser fatal para a sobrevivência energética do teu planeta.";
$lang['info'][213]['name']        = "Destruidor";
$lang['info'][213]['description'] = "Com o destruidor, a mãe de todas as naves entra na arena. O sistema de armas desta nave é constituído por canhões de ion-plasma e canhões de Gauss, adicionando um sistema de detecção e escolha de alvo, a nave pode destruir caças ligeiros voando em plena velocidade com 99% de probabilidade. A agilidade deste monstro de guerra é evidentemente embora a velocidade seja um grande ponto negativo, mas o destruidor pode ser considerado mais como uma estação de combate do que uma nave, com uma capacidade de transporte importante, acompanha as naves de batalha e dá uma ajudinha decisiva.";
$lang['info'][214]['name']        = "Estrela da Morte";
$lang['info'][214]['description'] = "Uma embarcação deste tamanho e deste poder necessita uma quantidade gigantesca de recursos e mão de obra que podem ser fornecidos somente pelos impérios mais importantes de todo o universo.";
$lang['info'][215]['name']        = "Interceptor";
$lang['info'][215]['description'] = "Esta nave, uma filigrana tecnológica, é mortal na altura de destruir frotas inimigas. Com os seus canhões de laser aperfeiçoados, mantém uma posição privilegiada entre as naves pesadas, onde pode destruir bastantes em menos de nada. Devido ao seu pequeno design e ao seu enorme poderio de armas, a capacidade de carga é mínima, mas isto é compensado com um consumo baixo de combustível do motor de hiperespaço embutido.";

// ----------------------------------------------------------------------------------------------------------
// Defenses !
$lang['info'][401]['name']        = "Lançador de Mísseis";
$lang['info'][401]['description'] = "O lançador de mísseis é um sistema de defesa simples e barato. Tornam-se muito eficazes em número e podem ser construídos sem pesquisa específica porque é uma arma de balística simples. Os custos de fabricação baixos fazem desta arma defensiva um adversário apropriado para frotas pequenas.<br/>Em geral, os sistemas de defesa desactivam-se ao alcançar parâmetros operacionais críticos de maneira a fornecer uma possibilidade de reparação. 70% da defesa planetária destruída pode ser reparada depois dum combate.";
$lang['info'][402]['name']        = "Laser Ligeiro";
$lang['info'][402]['description'] = "Para acompanhar o ritmo com a velocidade sempre crescente do desenvolvimento das tecnologias de naves espaciais, os cientistas tiveram que criar um tipo novo de sistema da defesa capaz de destruír as naves mais fortes.<br/>Rapidamente, o laser ligeiro foi inventado, este pode disparar um feixe de laser altamente concentrado no alvo e criar danos muito mais elevados do que o impacto de mísseis balísticos. Um preço baixo da unidade era um objetivo essencial do projeto, por isso a estrutura basica não foi melhorada comparada ao lançador de mísseis.";
$lang['info'][403]['name']        = "Laser Pesado";
$lang['info'][403]['description'] = "O laser pesado é uma evolução directa do laser ligeiro, a integridade estrutural foi evoluída e aumentada e materiais novos foram adoptados. Com os novos sistemas de energia e novos computadores, muito mais energia pode ser utilizada e dirigida para disparar fogo sobre o inimigo.";
$lang['info'][404]['name']        = "Canhão de Gauss";
$lang['info'][404]['description'] = "Durante muito tempo pensou-se que as armas de projécteis iam ser como a tecnologia de fusão e de energia, o desenvolvimento da propulsão de hiperespaço e o desenvolvimento de protecções melhoradas ficando antigas até que a tecnologia de energia, que a tinha posta de lado naquele tempo, as fez renascer. O princípio já era conhecido no século XX - o princípio de aceleração de partículas. Um canhão de gauss (canhão eletromagnético) não é nada mais que um acelerador de partículas, onde os projécteis com um peso de várias toneladas começam a ser acelerados. Mesmo as protecções modernas, a blindagem ou os escudos têm dificuldades em resistir a esta força, acabando um projéctil por atravessar completamente o objecto. Os sistemas de defesa desactivam-se quando estão demasiado estragados. Depois de uma batalha, 70% dos sistemas danificados podem ser reparados.";
$lang['info'][405]['name']        = "Canhão de Iões";
$lang['info'][405]['description'] = "No século XXI existiu algo com o nome de PEM. O PEM era um pulso eletromagnético que causava uma tensão adicional em cada circuito, o que provocava muitos incidentes de obstrução nos instrumentos mais sensíveis. O PEM foi baseado em mísseis e bombas, e também em relação às bombas atómicas. O PEM foi depois evoluído para fazer objectos incapazes de agir sem serem destruidos. Hoje, o canhão de iões é a versão mais moderna do PEM que lança uma onda de iões contra um objecto (naves), destabilizando-lhe desta maneira as protecções e a electrónica. A força cinética não é significativa. Os cruzadores também utilizam esta tecnologia. é interessante não destruir uma embarcação mas paralizá-la. Depois de uma batalha 70% dos sistemas danificados podem ser reparados.";
$lang['info'][406]['name']        = "Canhão de Plasma";
$lang['info'][406]['description'] = "A tecnologia de laser foi melhorada, a tecnologia de iões alcançou a sua fase final. Pensou-se que seria impossível criar sistemas de armas mais eficazes. A possibilidade de combinar os dois sistemas mudou este pensamento. Sabia-se já que a tecnologia de fusão, das partículas dos lasers (geralmente deutério) faz aumentar a temperatura até milhões de graus. A tecnologia de iões permite o carregamento elétrico das partículas, a ligação em redes de estabilidade e a aceleração das partículas. Assim nasce o plasma. A esfera de plasma é azul e visualmente atractiva, mas é difícil pensar que um grupo de embarcações fique muito feliz de a ver. O canhão de plasma é uma das armas mais poderosas, embora seja uma tecnologia é muito cara. Depois de uma batalha, 70% dos sistemas danificados podem ser reparados.";
$lang['info'][407]['name']        = "Pequeno Escudo Planetário";
$lang['info'][407]['description'] = "Muito tempo antes da instalação dos escudos em embarcações, os geradores já existiam na superfície dos planetas. Cobriam os planetas e eram capazes de absorver quantidades enormes de danos antes de serem destruídos. Os ataques com frotas ligeiras falhavam frequentemente quando se encontravam com estes geradores. Mais tarde, foi imaginado a criação de um enorme escudo planetário. Para cada planeta um escudo planetário.";
$lang['info'][408]['name']        = "Grande Escudo Planetário";
$lang['info'][408]['description'] = "O grande escudo planetário cobre o planeta para absorver quantidades enormes de tiros. A sua resistência é muito maior daquela encontrada no pequeno escudo planetário e francamente resistente contra o RapidFire das naves de combate.";

// ----------------------------------------------------------------------------------------------------------
// Missiles !
$lang['info'][502]['name']        = "Míssil de Intercepção";
$lang['info'][502]['description'] = "O míssil de intercepção destrói os mísseis interplanetários atacantes. Cada míssil de intercepção pode destruir um míssil interplanetário lançado em ataque.";
$lang['info'][503]['name']        = "Míssil Interplanetário";
$lang['info'][503]['description'] = "O míssil interplanetário destrói os sistemas de defesa do inimigo. Os sistemas destruidos desta maneira não podem ser reparados.";

// ----------------------------------------------------------------------------------------------------------
// Officiers !
$lang['info'][601]['name']        = "Geólogo";
$lang['info'][601]['description'] = "O Geólogo é um experiente astromineralogista e cristalografista. Ele assiste as suas equipas de metalurgia e química e cuida das comunicações interplanetárias optimizando o seu uso e a refinação das matérias-primas por todo o império<br /><br /><font color=\"red\">+5% da produção.<br /> Nível máx. : 20</font>";
$lang['info'][602]['name']        = "Almirante";
$lang['info'][602]['description'] = "O Almirante de frota é um experiente veterano de guerra e um estratega. Nos combates mais difíceis, ele é capaz de definir uma estratégia e transmiti-la aos seus subordinados. Um sábio imperador pode confiar no seu suporte em batalhas e poderá adicionar mais slots de frota para o combate.<br /><br /><font color=\"red\">+5% de defesa, protecção de frota e armamento na frota.<br /> Nível Max.: 20</font>";
$lang['info'][603]['name']        = "Engenheiro";
$lang['info'][603]['description'] = "O engenheiro é especialista na gestão de energia. Em épocas de paz, aumenta a energia de todas as tuas colónias. Em caso de ataque, assegura a fonte de energia aos canhões defensivos evitando uma eventual sobrecarga, reduzindo deste modo as perdas na batalha.<br /><br /><font color=\"red\">+5% de energia.<br /> Nível Max.: 10</font>";
$lang['info'][604]['name']        = "Tecnocrata";
$lang['info'][604]['description'] = "Os tecnocratas são cientistas geniais. Eles são encontrados em áreas onde a tecnologia está prestes a atingir os seus limites. Ninguém consegue decifrar a criptografia de um tecnocrata e a sua simples presença inspira investigadores em todo o império.<br /><br /><font color=\"red\">-5% de tempo de construção em toda a frota.<br /> Nível Max : 10</font>";
$lang['info'][605]['name']        = "Construtor";
$lang['info'][605]['description'] = "O fabricante é um novo tipo de construtor. O seu DNA foi modificado para lhe dar uma força extraordinária. Apenas um desses \"homem\" pode construir uma cidade inteira.<br /><br /><font color=\"red\">-10% de tempo de construção.<br /> Nível Max.: 3</font>";
$lang['info'][606]['name']        = "Cientista";
$lang['info'][606]['description'] = "A Ordem dos cientistas é composta por grandes génios. Podes encontrá-los sempre a discutir questões que desafiariam a lógica de qualquer pessoa. Nenhuma pessoa normal conseguirá descobrir o código desta ordem e é a sua presença que inspira todos investigadores no Império a conseguir mais e melhor.<br /><br /><font color=\"red\">-10% de tempo nas pesquisas.<br /> Nível Max.: 3</font>";
$lang['info'][607]['name']        = "Armazenista";
$lang['info'][607]['description'] = "O armazenista fez parte da antiga Irmandade do planeta Hsac. O seu lema é ganhar o máximo, mas, por esta razão, necessita de espaço de armazenamento. é por isso que o fabricante desenvolveu uma nova técnica de armazenamento.<br /><br /><font color=\"red\">+50% de armazenamento.<br /> Nível Max.: 2</font>";
$lang['info'][608]['name']        = "Defensor";
$lang['info'][608]['description'] = "O defensor é um membro do exército imperial. O seu zelo pelo trabalho permite-lhe construir uma formidável defesa, num curto espaço de tempo nas colónias hostis.<br /><br /><font color=\"red\">-50% de tempo de construção das defesas.</font>";
$lang['info'][609]['name']        = "Bunker";
$lang['info'][609]['description'] = "O imperador tem notado o impressionante trabalho que tem prestado ao seu império. Para agradecer-lhe da-lhe a hipótese de se tornar Bunker. Ser Bunker é o maior prémio da Mineração do exército imperial.<br /><br /><font color=\"red\">Limpar o protector planetário</font> ";
$lang['info'][610]['name']        = "Espião";
$lang['info'][610]['description'] = "O espião é uma pessoa enigmática. Ninguém viu o seu verdadeiro rosto, a menos que já tivesse morto.<br /><br />+5 de<br /> Nível de espionagem.<br /> Nível Max.: 2<font color=\"red\"></font>";
$lang['info'][611]['name']        = "Comandante";
$lang['info'][611]['description'] = "O comandante do exército imperial domina a arte de lidar com frotas. O seu cérebro pode calcular as trajetórias de várias frotas, muito acima de um normal humano.<br /><br />+3 slots de frota.<br /> Nível Max.: 3<font color=\"red\"></font> ";
$lang['info'][612]['name']        = "Destruidor";
$lang['info'][612]['description'] = "O Destruidor é um funcionário sem misericórdia. Ele massacra todo o planeta apenas por prazer. Está actualmente a desenvolver um novo método de produção de estrelas da morte<br /><br />2 EDM construidas ao invés de uma.<br /> Nível Max.: 1<font color=\"red\"></font>";
$lang['info'][613]['name']        = "General";
$lang['info'][613]['description'] = "O General é uma pessoa que tem servido muitos anos no exército. O fabricante de navios produz mais rápido na sua presença.<br /><br />+25% de velocidade no fabrico de frota.<br /> Nível Max.: 3<font color=\"red\"></font>";
$lang['info'][614]['name']        = "Rigidez";
$lang['info'][614]['description'] = "O imperador detectou-lhe qualidades inegáveis de conquista. Propõe que se torne Rigido. A Rigidez é grau mais elevado do ramo das rigidezes do exército imperial<br /><br />Desbloquear a SuperNova<font color=\"red\"></font>";
$lang['info'][615]['name']        = "Emperador";
$lang['info'][615]['description'] = "Você tem mostrado que é o maior conquistador do universo. Este lugar deve ser seu.<br /><br />Desbloquear o destruidor planetário<font color=\"red\"></font>";

?>