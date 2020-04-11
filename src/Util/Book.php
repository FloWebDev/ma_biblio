<?php

namespace App\Util;

class Book {
    const BOOK = [
        [
            'title' => '1984',
            'img' => '1984.jpg',
            'description' => 'Année 1984 en Océanie. 1984 ? C’est en tout cas ce qu’il semble à Winston, qui ne saurait toutefois en jurer. Le passé a été oblitéré et réinventé, et les événements les plus récents sont susceptibles d’être modifiés. Winston est lui-même chargé de récrire les archives qui contredisent le présent et les promesses de Big Brother. Grâce à une technologie de pointe, ce dernier sait tout, voit tout. Il n’est pas une âme dont il ne puisse connaître les pensées. On ne peut se fier à personne et les enfants sont encore les meilleurs espions qui soient. Liberté est Servitude. Ignorance est Puissance. Telles sont les devises du régime de Big Brother. La plupart des Océaniens n’y voient guère à redire, surtout les plus jeunes qui n’ont pas connu l’époque de leurs grands-parents et le sens initial du mot "libre". Winston refuse cependant de perdre espoir. Il entame une liaison secrète et hautement dangereuse avec l’insoumise Julia et tous deux vont tenter d’intégrer la Fraternité, une organisation ayant pour but de renverser Big Brother. Mais celui-ci veille…</p>

            <p>Le célèbre et glaçant roman de George Orwell se redécouvre dans une nouvelle traduction, plus directe et plus dépouillée, qui tente de restituer la terreur dans toute son immédiateté mais aussi les tonalités nostalgiques et les échappées lyriques d’une œuvre brutale et subtile, équivoque et génialement manipulatrice.'
        ],
        [
            'title' => 'L\'étranger',
            'img' => 'l-etranger.jpg',
            'description' => '"Quand la sonnerie a encore retenti, que la porte du box s\'est ouverte, c\'est le silence de la salle qui est monté vers moi, le silence, et cette singulière sensation que j\'ai eue lorsque j\'ai constaté que le jeune journaliste avait détourné les yeux. Je n\'ai pas regardé du côté de Marie. Je n\'en ai pas eu le temps parce que le président m\'a dit dans une forme bizarre que j\'aurais la tête tranchée sur une place publique au nom du peuple français..."'
        ],
        [
            'title' => 'Le tour du monde en 80 jours',
            'img' => 'le-tour-du-monde-en-80-jours.jpg',
            'description' => 'En 1872, un riche gentleman londonien, Phileas Fogg, parie vingt mille livres qu\'il fera le tour du monde en quatre-vingts jours. Accompagné de son valet de chambre, le dévoué Passepartout, il quitte Londres pour une formidable course contre la montre. Au prix de mille aventures, notre héros va s\'employer à gagner ce pari.'
        ],
        [
            'title' => 'Harry Potter à l\'école des sorciers',
            'img' => 'harry-potter.jpeg',
            'description' => 'Le jour de ses onze ans, la vie de Harry Potter est bouleversée à jamais quand Rubeus Hagrid, un géant aux yeux brillants comme des scarabées, lui apporte une lettre ainsi que d\'incroyables nouvelles. Harry Potter n\'est pas un garçon comme les autres : c\'est un sorcier. Et une aventure extraordinaire est sur le point de commencer.'
        ],
        [
            'title' => 'Autre Monde - L\'alliance des trois (T1)',
            'img' => 'autre-monde.jpg',
            'description' => 'Personne ne l\'a vue venir.La Grande Tempête : un ouragan de vent et de neige qui plonge le pays dans l\'obscurité et l\'effroi.D\'étranges éclairs bleus rampent le long des immeubles, les palpent, à la recherche de leurs proies ... Quand les enfants se sont éveillés, la Terre n\'était plus la même. Désormais seuls, ils vont devoir s\'organiser. Pour comprendre. Pour survivre. À cet Autre-Monde.Après Le Seigneur des anneaux, La Croisée des mondes, Harry Potter ..., la naissance d\'un nouvel univers : Autre-Monde. Entre roman d\'aventure et fantasy, une série totalement originale que les adultes aimeront faire découvrir aux plus jeunes.'
        ],
        [
            'title' => 'Ravage',
            'img' => 'ravage.jpg',
            'description' => '«- Vous ne savez pas ce qui est arrivé ? Tous les moteurs d\'avions se sont arrêtés hier à la même heure, juste au moment où le courant flanchait partout. Tous ceux qui s\'étaient mis en descente pour atterrir sur la terrasse sont tombés comme une grêle. Vous n\'avez rien entendu, là-dessous ? Moi, dans mon petit appartement près du garage, c\'est bien un miracle si je n\'ai pas été aplati. Quand le bus de la ligne 2 est tombé, j\'ai sauté au plafond comme une crêpe... Allez donc jeter un coup d\'œil dehors, vous verrez le beau travail !»'
        ],
        [
            'title' => 'L\'Ecume des jours',
            'img' => 'l-ecume-des-jours.jpg',
            'description' => '« Le plus poignant des romans d’amour contemporain.» Raymond Queneau</p><p>« L’écume des jours, c’est Roméo et Juliette sans confl its familiaux, Tristan et Yseut qui n’ont pas besoin de philtre, Paul et Virginie à Saint-Germain-des-Prés, une Dame dont les Camélias sont remplacés par un Nénuphar, Héloïse sans castrer Abélard. Voilà un tournant : le moment, après la guerre, où le roman français se dit que ce qui importe, c’est de faire bouger le lecteur sur un air de be-bop. Boris Vian en a marre des académismes, il veut faire rire et swinguer la langue, il veut obtenir les larmes, il veut aussi faire rêver et proposer davantage qu’une romance: une fenêtre ouverte sur le merveilleux.» Frédéric Beigbeder'
        ],
        [
            'title' => 'Le vieil homme et la mer',
            'img' => 'le-vieil-homme-et-la-mer.jpg',
            'description' => 'À Cuba, voilà quatre-vingt-quatre jours que le vieux Santiago rentre bredouille de la pêche, ses filets désespérément vides. La chance l’a déserté depuis longtemps. À l’aube du quatre-vingt-cinquième jour, son jeune ami Manolin lui fournit deux belles sardines fraîches pour appâter le poisson, et lui souhaite bonne chance en le regardant s’éloigner à bord de son petit bateau. Aujourd’hui, Santiago sent que la fortune lui revient. Et en effet, un poisson vient mordre à l’hameçon. C’est un marlin magnifique et gigantesque. Débute alors le plus âpre des duels.<br>Combat de l’homme et de la nature, roman du courage et de l’espoir, Le vieil homme et la mer est un des plus grands livres de la littérature américaine.'
        ],
        [
            'title' => 'Fahrenheit 451',
            'img' => 'fahrenheit-451.jpg',
            'description' => 'Dans une société futuriste cauchemardesque, les pompiers n\'éteignent plus les incendies, mais sont chargés de brûler livres et bibliothèques. Un jour, l\'un d\'entre eux, Guy Montag, découvre le plaisir de la lecture, et entre ainsi en résistance... Une dystopie en forme d\'hommage à la littérature, et un grand roman de science-fiction, qui amène à réfléchir sur le pouvoir des médias et les dangers de la censure.'
        ],
        [
            'title' => 'Fahrenheit 451',
            'img' => 'dix-petits-negres.jpg',
            'description' => 'L’île du Nègre ! Elle est au cœur des histoires les plus folles… Selon certains elle viendrait d’être achetée par une star de Hollywood, l’Amirauté britannique y conduirait des expériences classées secret-défense… Aussi quand les dix invités d’un hôte mystérieux y sont conviés pour passer des vacances, tous s’y précipitent ! Le sinistre compte à rebours peut alors commencer…'
        ],
        [
            'title' => 'L\'attrape-cœurs',
            'img' => 'l-attrape-coeur.jpeg',
            'description' => 'Phénomène littéraire sans équivalent depuis les années 50, J. D. Salinger reste le plus mystérieux des écrivains contemporains, et son chef-d\'œuvre, "L\'attrape-cœurs", roman de l\'adolescence le plus lu du monde entier, est l\'histoire d\'une fugue, celle d\'un garçon de la bourgeoisie new-yorkaise chassé de son collège trois jours avant Noël, qui n\'ose pas rentrer chez lui et affronter ses parents. Trois jours de vagabondage et d\'aventures cocasses, sordides ou émouvantes, d\'incertitude et d\'anxiété, à la recherche de soi-même et des autres. L\'histoire éternelle d\'un gosse perdu qui cherche des raisons de vivre dans un monde hostile et corrompu.'
        ],
        [
            'title' => 'Le Petit Prince',
            'img' => 'le-petit-prince.jpeg',
            'description' => '"Le premier soir, je me suis donc endormi sur le sable à mille milles de toute terre habitée. J\'étais bien plus isolé qu\'un naufragé sur un radeau au milieu de l\'océan. Alors, vous imaginez ma surprise, au lever du jour, quand une drôle de petite voix m\'a réveillé. Elle disait : "S\'il vous plaît... dessine-moi un mouton !" J\'ai bien regardé. Et j\'ai vu ce petit bonhomme tout à fait extraordinaire qui me considérait gravement..."'
        ],
        [
            'title' => 'Le Meilleur des mondes',
            'img' => 'le-meilleur-des-mondes.jpg',
            'description' => 'Les expérimentations sur l\'embryon, l\'usage généralisé de la drogue. Ces questions d\'actualité ont été résolues dans l\'État mondial, totalitaire, imaginé par Huxley en 1932. Défi, réquisitoire, anti-utopie, ce chef-d\'oeuvre de la littérature d\'anticipation a fait de son auteur un des témoins les plus lucides de notre temps.'
        ],
        [
            'title' => 'Si c\'est un homme',
            'img' => 'si-c-est-un-homme.jpg',
            'description' => '" On est volontiers persuadé d\'avoir lu beaucoup de choses à propos de l\'holocauste, on est convaincu d\'en savoir au moins autant. Et, convenons-en avec une sincérité égale au sentiment de la honte, quelquefois, devant l\'accumulation, on a envie de crier grâce.
            C\'est que l\'on n\'a pas encore entendu Levi analyser la nature complexe de l\'état du malheur.
            Peu l\'ont prouvé aussi bien que Levi, qui a l\'air de nous retenir par les basques au bord du menaçant oubli : si la littérature n\'est pas écrite pour rappeler les morts aux vivants, elle n\'est que futilité. "
            Angelo Rinaldi</p><p>" Ce volume est aussi important que la Bible. Un Livre fonda une religion humaniste il y a des millénaires. Un autre Livre raconte la fin de l\'humanité au XXe siècle. " Frédéric Beigbeder'
        ],
        [
            'title' => 'Robinson Crusoé',
            'img' => 'robinson-crusoe.jpg',
            'description' => 'Robinson Crusoé aurait été inspiré par l\'histoire du marin écossais Alexandre Selkirk qui survécut quatre ans sur une île déserte. En 1659, alors qu\'il a vingt-huit ans, il se joint à une expédition partie à la recherche d\'esclaves africains, mais suite à une tempête il est naufragé sur une île à l\'embouchure de l\'Orénoque en Amérique du Sud. Tous ses compagnons étant morts, il parvient à récupérer des armes et des outils dans l\'épave. Il fait la découverte d\'une grotte. Il se construit une habitation et confectionne un calendrier en faisant des entailles dans un morceau de bois. Il chasse et cultive le blé. Il apprend à fabriquer de la poterie et élève des chèvres. Il lit la Bible et rien ne lui manque, si ce n\'est la compagnie des hommes. Source Wikipédia.
            Il s\'aperçoit que l\'île qu\'il a appelée « Désespoir » reçoit périodiquement la visite de cannibales, qui viennent y tuer et manger leurs prisonniers.'
        ],
        [
            'title' => 'Les Misérables',
            'img' => 'les-miserables.jpeg',
            'description' => 'Le destin de Jean Valjean, forçat échappé du bagne, est bouleversé par sa rencontre avec Fantine. Mourante et sans le sou, celle-ci lui demande de prendre soin de Cosette, sa fille confiée aux Thénardier. Ce couple d’aubergistes, malhonnête et sans scrupules, exploitent la fillette jusqu’à ce que Jean Valjean tienne sa promesse et l’adopte. Cosette devient alors sa raison de vivre. Mais son passé le rattrape et l’inspecteur Javert le traque…'
        ],
        [
            'title' => 'L\'Odyssée',
            'img' => 'l-odysee.jpg',
            'description' => 'Dans la petite île d\'Ithaque, Pénélope et son fils Télémaque attendent Ulysse, leur époux et père. Voilà vingt ans qu\'il est parti pour Troie et qu\'ils sont sans nouvelles de lui. De l\'autre côté des mers, Ulysse a pris le chemin du retour depuis longtemps déjà. Mais les tempêtes, les monstres, les géants, les dieux parfois, l\'arrêtent ou le détournent de sa route. Premier grand voyageur, Ulysse découvre l\'inconnu où naissent les rêves et les peurs des hommes depuis la nuit des temps; l\'Odyssée nous dit cette aventure au terme de laquelle le héros retrouve enfin, aux côtés de Pénélope, « la joie du lit ancien ».'
        ],
        [
            'title' => 'Stupeur Et Tremblements',
            'img' => 'stupeur-et-tremblements.jpg',
            'description' => 'En 1990, au Japon, Amélie est engagée comme interprète chez Yumimoto, une entreprise d\'import-export. Elle pense que son rêve de vivre comme une Japonaise va pouvoir se réaliser. Mais, très vite, elle sent bien que la réalité du système Yumimoto obéit à d\'autres lois que celles de son désir.</p><p>Stupeur et Tremblements est le récit rétrospectif d\'une expérience d\'aliénation vécue par Amélie Nothomb au sein d\'une entreprise japonaise. L\'auteur a choisi de traiter cet épisode romanesque sur un mode humoristique, parfois ironique amenant ainsi le lecteur à rire d\'événements pourtant traumatiques. Comment l\'individu peut-il réagir au processus d\'humiliation mené par un groupe ? Comment gérer la violence et la folie de l\'Autre ? Comment leur résister avec les mots ? Autant de questions que les élèves pourront approfondir, tout en réfléchissant aux différents modes de l\'expression de soi (récit, monologues intérieurs, dialogues argumentatifs) et au travail du style.
            L\'ouvrage propose également un regard sur l\'adaptation cinématographique d\'Alain Corneau, suivi d\'une interview exclusive d\'Amélie Nothomb et de Sylvie Testud.'
        ],
        [
            'title' => 'American Psycho',
            'img' => 'american-psycho.jpg',
            'description' => '"Patrick Bateman est, hélas, un des personnages de roman les plus intéressants qu\'on ait créés au cours des dix dernières années." Michel Braudeau, Le Monde.<br>
            "Le premier roman depuis des années à faire résonner des thèmes aussi profonds, dostoïevskiens... [Bret Easton Ellis] nous oblige à regarder en face l\'intolérable, ce que peu de romanciers ont le courage de faire." Norman Mailer.<br>
            "On entend rarement dire, dans la fureur des commentaires, que ce roman est une satire, une satire hilarante, écœurante, pince-sans-rire, consternante... Ellis est avant tout un moraliste. Dans ses romans, chaque mot prononcé d\'une voix laconique naît d\'une indignation intense, douloureuse, éprouvée au regard de notre condition spirituelle..." The Los Angeles Times.'
        ],
        [
            'title' => 'Bel-Ami',
            'img' => 'bel-ami.jpg',
            'description' => 'Georges Duroy, dit Bel-Ami, est un jeune homme au physique avantageux. Le hasard d\'une rencontre le met sur la voie de l\'ascension sociale. Malgré sa vulgarité et son ignorance, cet arriviste parvient au sommet par l\'intermédiaire de ses maîtresses et du journalisme. Cinq héroïnes vont tour à tour l\'initier aux mystères du métier, aux secrets de la mondanité et lui assurer la réussite qu\'il espère. Dans cette société parisienne en pleine expansion capitaliste et coloniale, que Maupassant dénonce avec force parce qu\'il la connaît bien, les femmes éduquent, conseillent, œuvrent dans l\'ombre. La presse, la politique, la finance s\'entremêlent. Mais derrière les combines politiques et financières, l\'érotisme intéressé, la mort est là qui veille, et avec elle, l\'angoisse que chacun porte au fond de lui-même.'
        ],
        [
            'title' => 'Sur la route',
            'img' => 'sur-la-route.jpg',
            'description' => 'Un gars de l\'Ouest, de la race solaire, tel était Dean. Ma tante avait beau me mettre en garde contre les histoires que j\'aurais avec lui, j\'allais entendre l\'appel d\'une vie neuve, voir un horizon neuf, me fier à tout ça en pleine jeunesse ; et si je devais avoir quelques ennuis, si même Dean devait ne plus vouloir de moi pour copain et me laisser tomber, comme il le ferait plus tard, crevant de faim sur un trottoir ou sur un lit d\'hôpital, qu\'est-ce que cela pouvait me foutre ?... Quelque part sur le chemin je savais qu\'il y aurait des filles, des visions, tout, quoi ; quelque part sur le chemin on me tendrait la perle rare.'
        ],
        [
            'title' => 'A l\'ouest rien de nouveau',
            'img' => 'a-l-ouest-rien-de-nouveau.jpg',
            'description' => '« Quand nous partons, nous ne sommes que de vulgaires soldats, maussades ou de bonne humeur et, quand nous arrivons dans la zone où commence le front, nous sommes devenus des hommes-bêtes… »<br>Témoignage d’un simple soldat allemand de la guerre de 1914-1918, À l’ouest rien de nouveau, roman pacifiste, réaliste et bouleversant, connut, dès sa parution en 1928, un succès mondial retentissant. Il reste l’un des ouvrages les plus forts dans la dénonciation de la monstruosité de la guerre.'
        ],
        [
            'title' => 'La Nuit du renard',
            'img' => 'la-nuit-du-renard.jpg',
            'description' => 'La Nuit du Renard... Un de ces livres à suspense qu\'il n\'est pas question de poser avant d\'être arrivé à la dernière page ! On serait même tenté, parfois, de regarder comment il finit pour pouvoir supporter la palpitante angoisse de tous ses rebondissements. Cependant l\'on suit pas à pas, dans leurs cheminements périlleux ou inquiétants, des personnages attachants auxquels on croit de la façon la plus absolue.
            </p><p>
            Steve Peterson a perdu sa jeune femme, étranglée par un inconnu dans leur maison du Connecticut. Tous les témoignages - notamment celui de Neil, leur petit garçon, qui était présent lors de l\'assassinat de sa mère et qui en garde une vision épouvantée - accablent Ronald Thompson, lequel est finalement condamné à la chaise électrique mais ne cesse de clamer son innocence.
            </p><p>
            On est à la veille de l\'exécution. Sharon, une jeune journaliste, a fait à l\'occasion du procès la connaissance de Steve, et tous deux sont tombés amoureux l\'un de l\'autre. Et voilà que ce jour-là Sharon et le petit Neil sont kidnappés par un déséquilibré, qui signe Renard les messages qu\'il lance par téléphone pour réclamer une rançon.
            </p><p>
            Renard cache ses prisonniers, ligotés et bâillonnés, dans une pièce souterraine au coeur de la gare centrale de New York. Il place près d\'eux une bombe, qui explosera à l\'heure même où Thompson sera exécuté...
            </p><p>
            Existe-t-il un lien entre ce rapt et la mort de Nina Peterson ? Thompson est-il vraiment coupable ? Sinon, sera-t-il sauvé in extremis de la chaise électrique ? Et qui est Renard ? Sera-t-il démasqué à temps pour que les innocents qu\'il a enlevés soient épargnés ?
            </p><p>
            Le rythme et la tension de ce roman sont véritablement hallucinants. Mary Higgins Clark crée un extraordinaire climat de terreur. Et le dénouement, saisissant, fait passer des frissons dans le dos.'
        ],
        [
            'title' => 'Elle s\'appelait Sarah',
            'img' => 'elle-s-appelait-sarah.jpg',
            'description' => 'Paris, juillet 1942 : Sarah, une fillette de dix ans qui porte l’étoile jaune, est arrêtée avec ses parents par la police française, au milieu de la nuit. Paniquée, elle met son petit frère à l’abri en lui promettant de revenir le libérer dès que possible. Paris, mai 2002 : Julia Jarmond, une journaliste américaine mariée à un Français, doit couvrir la commémoration de la rafle du Vél d’Hiv. Soixante ans après, son chemin va croiser celui de Sarah, et sa vie changer à jamais. Elle s’appelait Sarah, c’est l’histoire de deux familles que lie un terrible secret, c’est aussi l’évocation d’une des pages les plus sombres de l’Occupation. Un roman bouleversant sur la culpabilité et le devoir de mémoire, qui connaît un succès international, avec des traductions dans vingt pays.<br>Ce livre a obtenu le prix Chronos 2008, catégorie Lycéens, vingt ans et plus.'
        ],
        [
            'title' => 'Martiens, go home !',
            'img' => 'martiens-go-home.jpg',
            'description' => 'Enfermé dans une cabane en plein désert, Luke Devereaux, auteur de science-fiction en mal d\'invention, invoque désespérément sa muse - de toute évidence retenue ailleurs - quand soudain... on frappe à la porte. Et un petit homme vert, goguenard, apostrophe Luke d\'un désinvolte «Salut Toto !».Un milliard de Martiens, hâbleurs, exaspérants, mal embouchés, d\'une familiarité répugnante, révélant tous les secrets, clamant partout la vérité, viennent d\'envahir la Terre. Mais comment s\'en débarrasser ?'
        ],
        [
            'title' => 'La vérité sur l\'Affaire Harry Quebert',
            'img' => 'la-verite-sur-l-affaire-harry-quebert.jpg',
            'description' => 'À New York, au printemps 2008, alors que l Amérique bruisse des prémices de l élection présidentielle, Marcus Goldman, jeune écrivain à succès, est dans la tourmente : il est incapable d écrire le nouveau roman qu il doit remettre à son éditeur d ici quelques mois. Le délai est près d expirer quand soudain tout bascule pour lui : son ami et ancien professeur d université, Harry Quebert, l un des écrivains les plus respectés du pays, est rattrapé par son passé et se retrouve accusé d avoir assassiné, en 1975, Nola Kellergan, une jeune fille de 15 ans, avec qui il aurait eu une liaison. Convaincu de l innocence de Harry, Marcus abandonne tout pour se rendre dans le New Hampshire et mener son enquête. Il est rapidement dépassé par les événements : l enquête s enfonce et il fait l objet de menaces. Pour innocenter Harry et sauver sa carrière d écrivain, il doit absolument répondre à trois questions : Qui a tué Nola Kellergan ? Que s est-il passé dans le New Hampshire à l été 1975 ? Et comment écrit-on un roman à succès ? Sous ses airs de thriller à l américaine, La Vérité sur l Affaire Harry Quebert est une réflexion sur l Amérique, sur les travers de la société moderne, sur la littérature, sur la justice et sur les médias.'
        ],
        [
            'title' => 'La forêt des 29',
            'img' => 'la-foret-des-29.jpg',
            'description' => 'Inde du Nord, 1485. A la lisière du désert, les rajahs rivalisent de palais mirifiques. Pour les ériger, ils doivent alimenter les fours à chaux et abattent les arbres par milliers. Or, comme les Vieux l\'avaient prédit, une sécheresse effroyable se met à ravager la région. Au cœur de la catastrophe, un humble paysan se dresse : Djambo, jeune homme rejeté par les siens, a rejoint le peuple des pauvres. Dans sa longue errance, il a tout vécu, la faim, les deuils, la route, les mirages destructeurs de l\'orgueil et de la richesse, la douleur de l\'amour trahi. Mais il a surtout appris à connaître la Nature. Le premier, il comprend que la sécheresse n\'est pas une vengeance des dieux, mais celle de la nature maltraitée. Avec quelques hommes et femmes de bon sens, il fonde une communauté qui permet la survie de tous grâce à l\'application de 29 principes simples. La vénération des arbres est le pilier de cette communauté, dont les adeptes ont pris le nom de " 29 " en hindi : les Bishnoïs.
            La démarche de Djambo frappe les esprits et son efficacité fait école. Dès 1500, l\'Inde du Nord compte des centaines de villages de " 29 ". Gestion rationnelle de l\'eau, respect des femmes, protection des animaux sauvages, compassion envers tous les vivants, égalité des castes : les principes des Bishnoïs séduisent les hommes les plus divers. Les politiques les respectent et ils vivent en paix.
            Mais en 1730, le maharadjah de Jodhpur est pris à son tour de folie bâtisseuse. Venant à manquer de bois, il expédie son armée dans une forêt qui appartient à une femme Bishnoï, Amrita. " Plutôt mourir ! " déclare-t-elle aux soldats en s\'enlaçant à un arbre. Elle est décapitée. Ses filles l\'imitent et sont massacrées. D\'autres Bishnoïs prennent la suite, eux-mêmes trucidés. Ce massacre semble ne jamais devoir finir. Mais à la 363e victime, le chef de l\'armée, écœuré, renonce. Et le maharadjah, troublé, décide de protéger à jamais les " 29 ", leurs animaux et leurs forêts.
            Sur fond de steppes arides et de palais princiers, c\'est cette épopée historique méconnue que ressuscite Irène Frain, après une enquête au Rajasthan sur les pas du légendaire Djambo, puis chez les Bishnoïs eux-mêmes, qui font actuellement figure de pionniers de l\'écologie moderne, et donnent à ce roman flamboyant des allures de conte initiatique.'
        ],
        [
            'title' => '22/11/63',
            'img' => '22-11-63.jpg',
            'description' => 'Quand Jake Epping, professeur d\'anglais, accepte la mission insolite que son ami Al, mourant, veut lui confier - empêcher l\'assassinat de Kennedy le 22 novembre 1963 - il ne soupçonne pas à quoi il s\'engage. Une fissure temporelle ramène Jake en 1958, à l\'époque faste des Plymouth Fury, d\'Elvis, mais aussi de JFK et d\'un certain Lee Harvey Oswald. Il y rencontrera même l\'amour de sa vie. Mais altérer l\'Histoire - la grande ou la petite - n\'est pas sans conséquences...<br>
            Dans ce roman construit telle une uchronie menacée par l\'effet papillon, Stephen King revisite l\'Amérique des années 60, tout en soulignant les obsessions qui hantent, encore aujourd\'hui, la culture populaire américaine. Un jeu vertigineux avec le temps.'
        ],
        [
            'title' => 'Au revoir là-haut',
            'img' => 'au-revoir-la-haut.jpg',
            'description' => 'Sur les ruines du plus grand carnage du XXe siècle, deux rescapés des tranchées, passablement abîmés, prennent leur revanche en réalisant une escroquerie aussi spectaculaire qu\'amorale. Des sentiers de la gloire à la subversion de la patrie victorieuse, ils vont découvrir que la France ne plaisante pas avec ses morts...<br>
            Fresque d\'une rare cruauté, remarquable par son architecture et sa puissance d\'évocation, Au revoir là-haut est le grand roman de l\'après-guerre de 14, de l\'illusion de l\'armistice, de l\'État qui glorifie ses disparus et se débarrasse de vivants trop encombrants, de l\'abomination érigée en vertu.
            Dans l\'atmosphère crépusculaire des lendemains qui déchantent, peuplée de misérables pantins et de lâches reçus en héros, Pierre Lemaitre compose la grande tragédie de cette génération perdue avec un talent et une maîtrise impressionnants.'
        ],
        [
            'title' => 'La Défense Lincoln',
            'img' => 'la-defense-lincoln.jpeg',
            'description' => 'Installé à l’arrière de sa Lincoln, Mickey  Haller, avocat, défend bikers, dealers et  autres loosers. Habile, sans scrupule ou  presque, relativement méprisé du Barreau  de Californie, il vivote ainsi lorsqu’un riche  fils de famille accusé de meurtre fait  appel à  ses services. Enfin l’assurance d’être payé !  Et le client est innocent, c’est évident.
            Mais son enthousiasme vire rapidement à  l’inquiétude lorsqu’il comprend que l’affaire  n’est pas si simple et qu’il pourrait y laisser  la peau.'
        ],
        [
            'title' => 'La Gloire de mon père',
            'img' => 'la-gloire-de-mon-pere.jpg',
            'description' => 'Un petit Marseillais d\'il y a un siècle: l\'école primaire ; le cocon familial ; les premières vacances dans les collines, à La Treille ; la première chasse avec son père...
            </p><p>
            Lorsqu il commence à rédiger ses Souvenirs d\'enfance, au milieu des années cinquante, Marcel Pagnol est en train de s\'éloigner du cinéma., et le théâtre ne lui sourit plus.
            La Gloire de mon père, dès sa parution, en 1957, est salué comme marquant l\'avènement d\'un grand prosateur. Joseph, le père instituteur., Augustine, la timide maman., l\'oncle Jules, la tante Rosé, le petit frère Paul, deviennent immédiatement aussi populaires que Marius, César ou Panisse. Et la scène de la chasse à la bartavelle se transforme immédiatement en dictée d?école primaire...
            Les souvenirs de Pagnol sont un peu ceux de tous les enfants du monde. Plus tard, paraît-il, Pagnol aurait voulu qu\'ils deviennent un film. C\'est Yves Robert qui, longtemps après la mort de l\'écrivain, le réalisera.
            </p><p>
            « Je suis né dans la ville d\'Aubagne. sons le Garlaban couronné de chèvres au temps des derniers chevriers. »'
        ],
        [
            'title' => 'A la recherche du temps perdu',
            'img' => 'a-la-recherche-du-temps-perdu.jpg',
            'description' => 'À la recherche du temps perdu, couramment évoqué plus simplement sous le titre La Recherche, est un roman de Marcel Proust, écrit de 1906 à 1922 et publié de 1913 à 1927 en sept tomes, dont les trois derniers parurent après la mort de l’auteur. Plutôt que le récit d\'une séquence déterminée d\'événements, cette œuvre s\'intéresse non pas aux souvenirs du narrateur mais à une réflexion sur la littérature, sur la mémoire et sur le temps. Cependant, comme le souligne Jean-Yves Tadié dans Proust et le roman, tous ces éléments épars se découvrent reliés les uns aux autres quand, à travers toutes ses expériences négatives ou positives, le narrateur (qui est aussi le héros du roman), découvre le sens de la vie dans l\'art et la littérature au dernier tome.'
        ],
        [
            'title' => 'Charly 9',
            'img' => 'charly-9.jpg',
            'description' => 'Charles IX fut de tous nos rois de France l\'un des plus calamiteux.<br>
            À 22 ans, pour faire plaisir à sa mère, il ordonna le massacre de la Saint- Barthélemy, qui épouvanta l\'Europe entière. Abasourdi par l\'énormité de son crime, il sombra dans la folie. Courant le lapin et le cerf dans les salles du Louvre, fabriquant de la fausse monnaie pour remplir les caisses désespérément vides du royaume, il accumula les initiatives désastreuses.<br>
            Transpirant le sang par tous les pores de son pauvre corps décharné, Charles IX mourut à 23 ans, haï de tous.<br>
            Pourtant, il avait un bon fond.'
        ],
        [
            'title' => 'Les Fourmis',
            'img' => 'les-fourmis.jpg',
            'description' => 'Pendant les quelques secondes nécessaires pour lire cette seule phrase vont naître sur terre quarante humains mais surtout sept cents millions de fourmis. Depuis plus de cent millions d\'années avant nous, elles sont là, réparties en légions, en cités, en empires sur toute la surface du globe. EIles ont créé une civilisation parallèle, bâti de véritables royaumes, inventé les armes les plus sophistiquées, conçu tout un art de la guerre et de la cité que nous sommes loin d\'égaler, maîtrisé une technologie stupéfiante. Elles ont leur propre Attila, Christophe Colomb, Jules César, Machiavel ou Léonard de Vinci. Le jour des fourmis approche. Le roman pas comme les autres nous dit pourquoi et nous plonge de manière saisissante dans un univers de crimes, de monstruosités, de guerres tel que nous n\'en avons jamais connu. Au-delà de toute imagination. II nous fait entrer dans le monde des infra-terrestres. Attention où vous mettrez les pieds. Après avoir lu ce roman fascinant, vous risquez de ne plus regarder la réalité de la même manière.'
        ],
        [
            'title' => 'Je suis Pilgrim',
            'img' => 'je-suis-pilgrim.jpg',
            'description' => 'Une jeune femme assassinée dans un hôtel sinistre de Manhattan. Un père décapité en public sous le soleil cuisant d’Arabie Saoudite. Un chercheur torturé devant un laboratoire syrien ultrasecret. Un complot visant à commettre un effroyable crime contre l\'humanité. Et en fil rouge, reliant ces événements, un homme répondant au nom de Pilgrim. Pilgrim est le nom de code d’un individu qui n’existe pas officiellement. Il a autrefois dirigé une unité d’élite des Services secrets américains. Avant de se retirer dans l’anonymat le plus total, il a écrit le livre de référence sur la criminologie et la médecine légale. Mais son passé d’agent secret va bientôt le rattraper…'
        ],
        [
            'title' => 'La Nuit des enfants rois',
            'img' => 'la-nuit-des-enfants-rois.jpg',
            'description' => 'Cela se passe, une nuit, dans Central Park, à New York : sept adolescents sont sauvagement agressés, battus, violés. Mais ces sept-là ne sont pas comme les autres : ce sont des enfants génies.<br>
            De l\'horreur, ils vont tirer contre le monde une haine froide, mathématique, éternelle. Avec leur intelligence, ils volent des centaines de millions de dollars, ils accumulent les crimes parfaits. Car ces sept-là ne sont pas sept : ils sont un. 
            Ils sont un seul esprit, une seule volonté. Celui qui l\'a compris, Jimbo Farrar, lutte contre eux de toutes ses forces. A moins qu\'il ne soit de leur côté... Cela, personne ne le sait. Alors, si ces sept-là n\'étaient pas sept, mais huit ? S\'ils étaient huit, le monde serait à eux et ce serait la nuit, la longue nuit, LA NUIT DES ENFANTS ROIS.'
        ],
        [
            'title' => 'Demain, une oasis',
            'img' => 'demain-une-oasis.jpg',
            'description' => 'Médecin à Genève, vie tranquille, que pouvait-il craindre ? Deux limousines, un coup de frein, des portières qui claquent, un pistolet-mitrailleur, deux beignes, une cagoule et des jours dans une cave sous perfusion et somnifères... Un kidnapping. À son réveil, il se retrouve quelque part dans un village africain. Un commando humanitaire lui en confie la responsabilité. Sécheresse, famine, terrorisme : dans une Afrique qui se meurt, c\'est en cherchant le sens du mot justice qu\'il trouvera celui de sa vie.<br>
            Un classique du roman d\'anticipation, lauréat du Grand prix de l\'Imaginaire en 1992.'
        ],
        [
            'title' => 'Sa Majesté des Mouches',
            'img' => 'sa-majeste-des-mouches.jpg',
            'description' => 'Durant le Seconde Guerre mondiale, un avion s\'écrase sur une île du Pacifique. Il transportait des collégiens britanniques. Pas un seul adulte n\'a survécu. Rescapés de ce désastre, les enfants décident de s\'organiser et d\'abord d\'élire un chef. Ce sera Ralph, qui croit encore à la nécessité des lois pour survivre. Mais il a un rival, le chasseur Jack, qui, lui, s\'exalte d\'être enfin libre de toute autorité. Quand la nuit tombe, les cauchemars se déchaînent. Bruits étranges, visions effrayantes d\'un monstre. Et très vite, tout bascule. Entre le groupe de Ralph et celui de Jack, c\'est la guerre. Et elle sera sans merci. Cette adaptation de Nigel Williams, né en 1948, auteur de plusieurs romans et pièces de théâtre, a été saluée par William Golding.'
        ],
        [
            'title' => 'Lolita',
            'img' => 'lolita.jpeg',
            'description' => '«Ainsi donc, aucun de nous deux n\'est en vie au moment où le lecteur ouvre ce livre. Mais tant que le sang continue de battre dans cette main qui tient la plume, tu appartiens autant que moi à la bienheureuse matière, et je puis encore t\'interpeller d\'ici jusqu\'en Alaska. Sois fidèle à ton Dick. Ne laisse aucun autre type te toucher. N\'adresse pas la parole aux inconnus. J\'espère que tu aimeras ton bébé. J\'espère que ce sera un garçon. J\'espère que ton mari d\'opérette te traitera toujours bien, parce que autrement mon spectre viendra s\'en prendre à lui, comme une fumée noire, comme un colosse dément, pour le déchiqueter jusqu\'au moindre nerf. Et ne prends pas C.Q. en pitié. Il fallait choisir entre lui et H.H., et il était indispensable que H.H. survive au moins quelques mois de plus pour te faire vivre à jamais dans l\'esprit des générations futures. Je pense aux aurochs et aux anges, au secret des pigments immuables, aux sonnets prophétiques, au refuge de l\'art. Telle est la seule immortalité que toi et moi puissions partager, ma Lolita.»'
        ],
        [
            'title' => 'Born to Run',
            'img' => 'born-to-run.jpg',
            'description' => '«Pourquoi ai-je toujours mal aux pieds ?»<br>
            Comme la majorité des coureurs, Chris McDougall est hanté par cette question. Et quand ce ne sont pas les pieds ce sont les genoux, les hanches, les chevilles...<br>
            La quête de la réponse va entraîner le narrateur dans les aventures les plus folles, au coeur du Mexique, à la recherche de l\'homme qui courait comme les chevaux, surnommé Le Caballo blanco ; à la rencontre des Tarahumaras, une tribu de super-athlètes qui ont fait de la course à pied leur mode de vie et une source de joie permanente. Ils volent à petites foulées sur des terrains suicidaires. Personne ne peut les battre sur de très grandes distances. Les bobos, les maux de toutes sortes ? Disparus.<br>
            Leur secret ? Ce récit passionnant le dévoile dans un texte qui tient à la fois d\'Indiana Jones, de Tintin chez les coureurs de fond et d\'une démonstration époustouflante sur de nouvelles techniques de course à pied.<br>
            Un formidable récit d\'aventure, où tout est vrai.<br>
            Le lecteur est embarqué au coeur d\'une grande course dans les Copper Canyons, et dans un plaidoyer scientifique et convaincant sur une philosophie qui fait de plus en plus d\'adeptes dans le monde : la course minimaliste.'
        ],
        [
            'title' => 'Le Rouge et le noir',
            'img' => 'le-rouge-et-le-noir.jpg',
            'description' => 'En s’inspirant d’un fait divers tragique, Stendhal a écrit un roman culte qui marie chronique sociale et aventures amoureuses dans la société figée et mélancolique de la Restauration. Tranchant sur cette France où les idéaux des périodes révolutionnaire et napoléonienne n’ont plus cours, Julien Sorel apparaît comme la figure éternelle du héros porté par ses rêves d’ambition, ses désirs d’absolu et sa noblesse de cœur. Sa défaite inscrira son destin dans celui de toute une « génération perdue ».'
        ],
        [
            'title' => 'Madame Bovary',
            'img' => 'madame-bovary.jpg',
            'description' => 'Emma Rouault, adolescente, s’était bercée de rêves romanesques. Son mariage avec Charles Bovary, terne médecin de province, la confronte à une réalité prosaïque, dont elle cherche à s’évader par tous les moyens. Mais la maternité, l’ambition qu’elle nourrit pour Charles, le goût des belles choses qui l’entraîne à la dépense ne peuvent satisfaire cette jeune femme qui étouffe dans la société étriquée d’une petite ville normande dominée par la plate figure du pharmacien Homais. Si l’amour est son ultime espérance, sa soif d’idéal, de beauté, de grandeur, l’accule à un point de non-retour. L’histoire d’Emma Bovary, qui valut un procès à son auteur en 1857, s’inscrit dans un univers ordinaire, minutieusement dépeint par l’écriture très maîtrisée de Flaubert. Tout son art se déploie dans ce drame psychologique aux couleurs réalistes.'
        ],
        [
            'title' => 'Les raisins de la colère',
            'img' => 'les-raisins-de-la-colere.jpg',
            'description' => '"Le soleil se leva derrière eux, et alors... brusquement, ils découvrirent à leurs pieds l\'immense vallée. Al freina violemment et s\'arrêta en plein milieu de la route.<br>
            - Nom de Dieu ! Regardez ! s\'écria-t-il.<br>
            Les vignobles, les vergers, la grande vallée plate, verte et resplendissante, les longues files d\'arbres fruitiers et les fermes. Et Pa dit :<br>
            - Dieu tout-puissant !... J\'aurais jamais cru que ça pouvait exister, un pays aussi beau."'
        ],
        [
            'title' => 'La Vénus d\'Ille',
            'img' => 'la-venus-d-ille.jpg',
            'description' => '"Rien de plus suave, de plus voluptueux que ses contours" : c\'est ainsi qu\'un Parisien passionné d\'archéologie, venu recenser les merveilles du Roussillon, jauge la statue romaine déterrée par son hôte, M de Peyrehorade. Mais la beauté de cette Vénus est aussi prodigieuse que son sourire est cruel. "Prends garde à toi si elle t\'aime", peut-on lire sur son socle. L\'avertissement n\'a rien de rassurant. Pourtant, M de Peyrehorade place le mariage de son fils sous le patronage de cette étrange idole... Une décision qu\'il pourrait amèrement regretter : les événements troublants qui se produisent sont-ils le fait de cette statue maléfique ? Dans cette nouvelle, la figure de bronze est prétexte à une rêverie fantastique, véritable chef-d\'oeuvre du genre.'
        ],
        [
            'title' => 'Debout les morts',
            'img' => 'debout-les-morts.jpeg',
            'description' => 'Un hêtre peut-il pousser en une seule nuit dans un jardin sans que personne l\'ait planté ? Oui. Chez la cantatrice Sophie Simeonidis; et elle n\'en dort plus.
            </p><p>
            Nouveaux locataires de la vieille maison voisine, 3 historiens et un ancien flic, quatre hommes en perte de vitesse, vont se retrouver mêlés à cette sombre histoire lorsque la cantatrice leur fait part de son inquiétude. Et leur demande de creuser sous l\'arbre, en vain.
            </p><p>
            Puis elle disparaît et son époux n\'a pas l\'air de s\'en préoccuper. Après une série de meurtres sinistres, les "voisins" découvriront les racines du hêtre, vieilles de quinze ans, grasses de haine et de jalousie.'
        ],
        [
            'title' => 'Dracula',
            'img' => 'dracula.jpg',
            'description' => 'Écrit sous forme d\'extraits de journaux personnels et de lettre, ce roman nous conte les aventures de Jonathan Harker, jeune clerc de notaire envoyé dans une contrée lointaine et mystérieuse, la Transylvanie, pour rencontrer un client étranger, le comte Dracula, qui vient d\'acquérir une maison à Londres. Arrivé au château, lieu sinistre et inquiétant, Jonathan se rend vite compte qu\'il n\'a pas à faire à un client ordinaire... et qu\'il est en réalité retenu prisonnier par son hôte...Inutile de vous en dire plus, chacun sait qui est le terrible comte Dracula, le célèbre vampire... Le pauvre Jonathan, et ses amis, ne sont pas au bout de leurs peines...'
        ],
        [
            'title' => 'Pourquoi j\'ai mangé mon père',
            'img' => 'pourquoi-j-ai-mange-mon-pere.jpg',
            'description' => 'Une famille préhistorique ordinaire : Édouard, le père, génial inventeur qui va changer la face du monde en ramenant le feu ; Vania, l\'oncle réac, ennemi du progrès ; Ernest, le narrateur, un tantinet benêt ; Edwige, Griselda et d\'autres ravissantes donzelles...<br>
            Ces individus nous ressemblent : ils connaissent l\'amour, la drague, la bataille, la jalousie. Et découvrent l\'évolution.<br>
            Situations rocambolesques et personnages hilarants pour rire et réfléchir.<br>
            Un miroir à consulter souvent.'
        ],
        [
            'title' => 'Cyrano de Bergerac',
            'img' => 'cyrano-de-bergerac.jpg',
            'description' => 'Le nez de Cyrano s\'est mis en travers de son coeur. La belle Roxane aime ailleurs, en l\'espèce un cadet sans esprit mais de belle apparence, Christian de Neuvillette. La pièce de Rostand met en scène la tragique complicité entre deux moitiés d\'homme, et s\'achève sur une évidence en forme d\'espérance : sous les traits de Christian, ce n\'était pas moins que l\'âme de Cyrano qu\'aimait Roxane. Avec ce drame en cinq actes, au travers des reprises ou des adaptations cinématographiques, Rostand a connu et connaît un succès ininterrompu et planétaire. Pourquoi ? A cause des qualités d\'écriture, des vertus dramatiques ou de la réussite du personnage principal de la pièce ? Sans doute, pour une part. Mais la raison profonde tient à son art de caresser l\'un de nos plus anciens mythes : il n\'est pas de justice ici-bas, ni d\'amour heureux. Presque pas. Et tout est dans cette manière de nous camper sur cette frontière, entre rêve et réalité, entre lune et terre.'
        ],
        [
            'title' => 'Fatherland',
            'img' => 'fatherland.jpeg',
            'description' => 'Berlin, 1964. Les forces de l\'Axe ont gagné la guerre, la paix nazie règne sur l\'Europe. L\'Amérique a refusé le joug. Mais, dans quelques jours, le président Kennedy viendra conclure une alliance avec le Reich. Ce sera la fin du monde libre.<br>
            Deux meurtres viennent perturber les préparatifs. Les victimes sont d\'anciens S.S. de haut rang jouissant d\'une paisible retraite. Chargé de l\'affaire, l\'inspecteur March s\'interroge. S\'agit-il d\'un règlement de comptes entre dignitaires ? Pourquoi la Gestapo s\'intéresse-t-elle à l\'enquête ? Quelle est cette vérité indicible qui semble menacer les fondations du régime ? Dans Berlin pavoisé, les bourreaux guettent, prêts à tout pour étouffer les dernières lueurs de la liberté.'
        ],
        [
            'title' => 'La trilogie berlinoise',
            'img' => 'la-trilogie-berlinoise.jpg',
            'description' => 'L’été de cristal se situe en 1936, alors que l’on “nettoie” Berlin en prévision des J.O. Bernie Gunther, ancien membre de la Kripo devenu détective privé n’est pas sans ressembler à Philip Marlowe, le modèle culte de tous les privés. Son enquête (meurtre de la fille d’un industriel et disparition de bijoux) le conduit à se laisser interner au camp de Dachau… Dans La pâle figure, situé en 1938, il est victime d’un chantage de Heydrich qui veut le contraindre à réintégrer la police. Un requiem allemand, le plus noir des trois, commence en 1947 dans Berlin en ruine et divisé en secteurs d’occupation. La Trilogie berlinoise, tout en respectant les règles du genre policier, offre un portrait glaçant et puissamment évocateur de Berlin au quotidien à l’ère nazie.'
        ]
    ];
}
