-- =========================
-- IMAGES
-- =========================
INSERT INTO images (nom_fichier, chemin) VALUES
('iran_contexte.jpg', 'uploads/iran_contexte.jpg'),
('iran_acteurs.jpg', 'uploads/iran_acteurs.jpg'),
('iran_humanitaire.jpg', 'uploads/iran_humanitaire.jpg');

-- =========================
-- ARTICLES (3 contenus détaillés)
-- =========================
INSERT INTO articles (titre, chapeau, contenu, image_id, author_id, date_publication, status) VALUES

(
'Origines et contexte du conflit en Iran',
'Analyse détaillée des causes historiques, politiques et économiques de la crise iranienne.',
'Le conflit en Iran s’inscrit dans un contexte historique complexe marqué par des tensions politiques internes et des pressions internationales. Depuis la révolution de 1979, le pays a connu des transformations profondes dans son système politique, entraînant des relations tendues avec plusieurs puissances occidentales.

Les sanctions économiques imposées au fil des années ont fortement impacté l’économie iranienne, provoquant inflation, chômage et baisse du pouvoir d’achat. Ces difficultés économiques ont alimenté le mécontentement social et des mouvements de contestation.

Par ailleurs, la position géopolitique stratégique de l’Iran au Moyen-Orient en fait un acteur clé dans plusieurs conflits régionaux. Les rivalités avec certains pays voisins et les interventions indirectes dans d’autres zones de guerre ont contribué à intensifier les tensions.

Ainsi, le conflit actuel est le résultat d’un enchevêtrement de facteurs historiques, économiques et géopolitiques qui rendent la situation particulièrement complexe à résoudre.',
1,
1,
NOW(),
1
),

(
'Les acteurs et les enjeux géopolitiques',
'Présentation des principaux acteurs impliqués et des intérêts en jeu dans le conflit.',
'
    <p><img src="https://www.franceinfo.fr/pictures/-evxJMu9Wb692fFnGGlM-LrR7B8/0x126:2433x1495/1024x576/filters:format(avif):quality(50)/2026/03/30/69ca6e4796723551094836.jpg" alt="" width="750" height="422"></p>
<p>De l'aveu m&ecirc;me de hauts grad&eacute;s du quartier g&eacute;n&eacute;ral du d&eacute;partement de la D&eacute;fense am&eacute;ricaine, joints par le&nbsp;<a href="https://www.washingtonpost.com/national-security/2026/03/28/trump-iran-ground-troops-marines/" target="_blank" rel="noopener" data-tooltip-url="https://www.washingtonpost.com/national-security/2026/03/28/trump-iran-ground-troops-marines/"><em>Washington Post</em><span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>, cela fait maintenant&nbsp;<em>"plusieurs semaines"&nbsp;</em>que le Pentagone&nbsp;<em>"se pr&eacute;pare &agrave; mener des op&eacute;rations terrestres en Iran".&nbsp;</em>Samedi, le centre de commandement am&eacute;ricain a fini par confirmer qu'<em>"environ 3&nbsp;500"</em>&nbsp;marines et soldats venaient d'arriver au Moyen-Orient. Dans leurs paquetages,&nbsp;<a href="https://x.com/CENTCOM/status/2037906827778682900/photo/1" target="_blank" rel="noopener" data-tooltip-url="https://x.com/CENTCOM/status/2037906827778682900/photo/1">d&eacute;crit le Centcom<span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>,&nbsp;<em>"des &eacute;l&eacute;ments d'assaut amphibie et tactiques."</em></p>
<p>Une pr&eacute;cision mat&eacute;rielle qui renforce encore l'hypoth&egrave;se d'une intervention au sol. Mais o&ugrave;, comment, et pourquoi faire&nbsp;? Lundi 30&nbsp;mars,&nbsp;<a href="https://truthsocial.com/@realDonaldTrump/posts/116317880658472708" target="_blank" rel="noopener" data-tooltip-url="https://truthsocial.com/@realDonaldTrump/posts/116317880658472708">sur son r&eacute;seau Truth Social<span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>, Donald Trump a continu&eacute; d'entretenir le flou sur ses plans, pr&eacute;f&eacute;rant &agrave; la place menacer de<em>&nbsp;"conclure&nbsp;</em>[son]&nbsp;<em>charmant s&eacute;jour en Iran en faisant exploser et en an&eacute;antissant compl&egrave;tement toutes leurs centrales &eacute;lectriques, leurs puits de p&eacute;trole et l'&icirc;le de Kharg"</em>, si les discussions avec T&eacute;h&eacute;ran n'aboutissaient pas<em>&nbsp;"rapidement".</em></p>
<p>&nbsp;</p>
<h2 class="subheader">"Au moins" 10&nbsp;000&nbsp;soldats am&eacute;ricains suppl&eacute;mentaires bient&ocirc;t sur zone</h2>
<p>Trois mille cinq cents militaires am&eacute;ricains, et bient&ocirc;t davantage&nbsp;: un haut responsable du d&eacute;partement am&eacute;ricain de la D&eacute;fense a confi&eacute; au site d'informations&nbsp;<a href="https://www.axios.com/2026/03/27/iran-war-trump-pentagon-more-troops-middle-east" target="_blank" rel="noopener" data-tooltip-url="https://www.axios.com/2026/03/27/iran-war-trump-pentagon-more-troops-middle-east">Axios<span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>&nbsp;que le contingent devrait encore se renforcer, avec le d&eacute;barquement d'<em>"au moins&nbsp;10&nbsp;000&nbsp;soldats"&nbsp;</em>suppl&eacute;mentaires&nbsp;<em>"dans les prochains jours"</em>&nbsp;pour porter<em>&nbsp;"le coup de gr&acirc;ce"</em>&nbsp;&agrave; l'Iran.</p>
<p>Les images d'entra&icirc;nement, diffus&eacute;es par le&nbsp;<a class="" href="https://www.wsj.com/video/series/on-the-news/us-sends-thousands-of-marines-to-the-middle-eastheres-what-we-know/35DF569C-87CF-41E0-AEE7-73A7608A644A" target="_blank" rel="noopener" data-tooltip-url="https://www.wsj.com/video/series/on-the-news/us-sends-thousands-of-marines-to-the-middle-eastheres-what-we-know/35DF569C-87CF-41E0-AEE7-73A7608A644A"><em>Wall Street Journal</em><span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>, montrent des militaires au profil bien particulier. On observe ainsi des troupes&nbsp;<em>"hautement entra&icirc;n&eacute;es"</em>&nbsp;capables de&nbsp;<em>"d&eacute;barquer sur des plages",&nbsp;</em>de&nbsp;<em>"se parachuter sur des &icirc;les",&nbsp;</em>ou d'<em>"embarquer sur des navires pour des op&eacute;rations de perquisition et de saisie"</em>, d&eacute;crit la journaliste du quotidien am&eacute;ricain<em>.</em></p>
<blockquote class="ftvi_content_quote">
<p class="ftvi_citation_quote">"Ces unit&eacute;s (&hellip;) peuvent effectuer des types de mission si diff&eacute;rentes qu'on les appelle souvent les 'couteaux suisses de l'arm&eacute;e'."</p>
<div><cite class="ftvi_citation_author">le "Wall Street Journal"</cite></div>
</blockquote>
<p><em>"L'arriv&eacute;e de ces troupes est une mani&egrave;re pour Washington de faire monter la pression",&nbsp;</em>d&eacute;crypte le g&eacute;n&eacute;ral J&eacute;r&ocirc;me Pellistrandi, &eacute;galement r&eacute;dacteur en chef de la revue&nbsp;<em>D&eacute;fense nationale. "Concr&egrave;tement, comme tout ne se passe pas comme pr&eacute;vu, le Pentagone a besoin de compl&eacute;ter sa bo&icirc;te &agrave; outils pour des op&eacute;rations sp&eacute;cifiques, au sol."</em></p>
<h2 class="subheader">L'option des raids cibl&eacute;s privil&eacute;gi&eacute;e&nbsp;?</h2>
<p>Les Etats-Unis, qui ont d&eacute;j&agrave; perdu treize&nbsp;soldats en un mois de conflit, semblent en tout cas avoir &eacute;cart&eacute; l'option d'une invasion &agrave; grande &eacute;chelle de l'Iran.&nbsp;<em>"M&ecirc;me pour les Etats-Unis, cette conqu&ecirc;te terrestre est absolument hors de port&eacute;e</em>, continue J&eacute;r&ocirc;me Pellistrandi.&nbsp;<em>Le pays est beaucoup trop grand, il fait trois fois la France. Il faudrait des centaines de milliers d'hommes, des chars&hellip; Et puis pour quoi faire&nbsp;? Pour quel but, quelle l&eacute;gitimit&eacute;&nbsp;?"</em></p>
<p>Pour rappel, 250&nbsp;000&nbsp;soldats am&eacute;ricains avaient &eacute;t&eacute; d&eacute;ploy&eacute;s en mars 2003, en Irak, un pays bien plus petit et bien moins peupl&eacute; que l'Iran.&nbsp;<em>"Quand on voit ce qu'ont donn&eacute; les op&eacute;rations en Irak ou en Afghanistan, je vois mal les Etats-Unis se lancer dans une invasion totale de l'Iran"</em>, confirme Etienne Marcuz, analyste &agrave; la Fondation pour la recherche strat&eacute;gique,</p>
<p>L'option la plus probable serait donc&nbsp;<em>"des op&eacute;rations ponctuelles, cibl&eacute;es, brutales, rapides",&nbsp;</em>confirme le g&eacute;n&eacute;ral J&eacute;r&ocirc;me Pellistrandi. Selon la pressen am&eacute;ricaine, ces raids cibl&eacute;s auraient l'avantage de pouvoir &ecirc;tre&nbsp;<em>"men&eacute;s par une combinaison de forces sp&eacute;ciales et de troupes d'infanterie conventionnelles".</em></p>
<h2 class="subheader">Plusieurs cibles dans le viseur</h2>
<p>A en croire le site d'informations Axios, le Pentagone planche sur plusieurs op&eacute;rations. La premi&egrave;re est&nbsp;<a href="https://www.franceinfo.fr/monde/iran/guerre-entre-les-etats-unis-israel-et-l-iran/pourquoi-l-ile-iranienne-de-kharg-frappee-par-les-etats-unis-est-elle-strategique-dans-la-guerre-menee-contre-l-iran-mais-aussi-pour-l-economie-mondiale_7867586.html" target="_self" rel="noopener noreferrer nofollow" data-tooltip-url="/monde/iran/guerre-entre-les-etats-unis-israel-et-l-iran/pourquoi-l-ile-iranienne-de-kharg-frappee-par-les-etats-unis-est-elle-strategique-dans-la-guerre-menee-contre-l-iran-mais-aussi-pour-l-economie-mondiale_7867586.html">la prise de l'&icirc;le de Kharg</a>. Cette toute petite bande de terre, principal terminal p&eacute;trolier d'Iran, est le v&eacute;ritable poumon &eacute;conomique de la R&eacute;publique islamique.</p>
<p>&nbsp;</p>
<p><img src="https://www.franceinfo.fr/pictures/6_hOYqwGovEKA9StT-gMEuJ2lts/0x0:1024x1024/fit-in/720x/filters:format(avif):quality(50)/2026/03/14/068-aa-12032026-2691602-69b595c89b8bc153329611.jpg" alt="" width="720" height="720"></p>
<p>&nbsp;</p>
<p>Autre piste &eacute;voqu&eacute;e&nbsp;: des raids sur des zones c&ocirc;ti&egrave;res proches du d&eacute;troit d'Ormuz,<em>&nbsp;"afin d'y localiser et d&eacute;truire des armes capables de cibler la navigation commerciale et militaire"</em>, rapporte le&nbsp;<a href="https://www.washingtonpost.com/national-security/2026/03/28/trump-iran-ground-troops-marines/" target="_blank" rel="noopener" data-tooltip-url="https://www.washingtonpost.com/national-security/2026/03/28/trump-iran-ground-troops-marines/"><em>Washington Post</em><span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a><em>.&nbsp;</em>L'&icirc;le de Larak serait alors dans le viseur, tout comme celle d'Abou Moussa. Selon les sources que le quotidien am&eacute;ricain a sollicit&eacute;es, ces offensives prendraient<em>&nbsp;"probablement des semaines",</em>&nbsp;voire&nbsp;<em>"plusieurs mois",&nbsp;</em>avant d'&ecirc;tre men&eacute;es &agrave; leur terme.</p>
<p>Surtout, ce type d'op&eacute;rations comporte&nbsp;<em>"un haut potentiel de risques pour les soldats d&eacute;ploy&eacute;s"</em>, pr&eacute;vient le g&eacute;n&eacute;ral J&eacute;r&ocirc;me Pellistrandi.&nbsp;<em>"Les Iraniens s'y pr&eacute;parent depuis des ann&eacute;es. Ils ont certainement mis en place des syst&egrave;mes d&eacute;fensifs importants."</em>&nbsp;Drones, tirs au sol, engins explosifs improvis&eacute;s&hellip; Les troupes am&eacute;ricaines pourraient trouver sur leur chemin une grande vari&eacute;t&eacute; de menaces.&nbsp;<em>"On peut tout &agrave; fait imaginer que les Iraniens ont anticip&eacute; ce sc&eacute;nario des raids isol&eacute;s, et que des infrastructures critiques soient pi&eacute;g&eacute;es"</em>, embraie Etienne Marcuz.</p>
<h2 class="subheader">Des troupes pour r&eacute;cup&eacute;rer l'uranium enrichi</h2>
<p>Le Pentagone &eacute;tudie &eacute;galement la possibilit&eacute; d'une op&eacute;ration militaire destin&eacute;e &agrave; r&eacute;cup&eacute;rer les 450&nbsp;kg d'uranium hautement enrichi que T&eacute;h&eacute;ran conserverait dans des installations nucl&eacute;aires souterraines. L&agrave; encore, les experts joints par franceinfo sont dubitatifs.&nbsp;<em>"A moins d'avoir un renseignement certain et la quasi-certitude de r&eacute;ussir, cela semble tr&egrave;s pi&eacute;geux,</em>&nbsp;alerte J&eacute;r&ocirc;me Pellistrandi.&nbsp;<em>Il suffirait qu'un h&eacute;licopt&egrave;re soit abattu avec des soldats am&eacute;ricains &agrave; bord pour que ce soit un &eacute;chec absolu pour Washington."</em></p>
<p>L'op&eacute;ration en elle-m&ecirc;me est p&eacute;rilleuse. Interrog&eacute;s par le&nbsp;<a href="https://www.wsj.com/politics/national-security/trump-weighs-military-operation-to-extract-irans-uranium-37427c8b" target="_blank" rel="noopener" data-tooltip-url="https://www.wsj.com/politics/national-security/trump-weighs-military-operation-to-extract-irans-uranium-37427c8b"><em>Wall Street Journal</em><span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>, d'anciens officiers militaires am&eacute;ricains la classent parmi les options les plus difficiles qui s'offrent &agrave; Donald Trump.&nbsp;<em>"Des unit&eacute;s am&eacute;ricaines devraient &ecirc;tre achemin&eacute;es par voie a&eacute;rienne vers les sites, probablement sous le feu de missiles sol-air et de drones iraniens,</em>&nbsp;anticipe le journal.&nbsp;<em>Une fois sur place, des troupes de combat devraient s&eacute;curiser les p&eacute;rim&egrave;tres afin que des ing&eacute;nieurs &eacute;quip&eacute;s d'engins de terrassement puissent fouiller les d&eacute;bris et rechercher mines et pi&egrave;ges explosifs."</em></p>
<blockquote class="ftvi_content_quote">
<p class="ftvi_citation_quote">"L'extraction de l'uranium n&eacute;cessiterait probablement une unit&eacute; d'&eacute;lite sp&eacute;cialement form&eacute;e &agrave; la manipulation de mati&egrave;res radioactives en zone de conflit."</p>
<div><cite class="ftvi_citation_author">le "Wall Street Journal"</cite></div>
</blockquote>
<p>De tels raids, m&ecirc;me localis&eacute;s et ponctuels, pourraient pousser les Etats-Unis dans<em>&nbsp;"une nouvelle phase dangereuse</em>" du conflit.<strong>&nbsp;</strong><em>"Si &ccedil;a ne fonctionne pas, eh bien&nbsp;: l'escalade, l'escalade, l'escalade&hellip;"</em>, appuie Etienne Marcuz.<strong>&nbsp;</strong><em>"Si ces op&eacute;rations ne suffisent pas ou tournent mal, on ne sait pas ce qui peut se passer apr&egrave;s",</em>&nbsp;pointe J&eacute;r&ocirc;me Pellistrandi.</p>
<p>Economiquement, comme politiquement, Donald Trump a conscience qu'il joue gros. Le 25&nbsp;mars dernier, un nouveau sondage, men&eacute; par&nbsp;<a href="https://apnorc.org/projects/most-say-the-united-states-recent-military-actions-against-iran-have-gone-too-far/" target="_blank" rel="noopener" data-tooltip-url="https://apnorc.org/projects/most-say-the-united-states-recent-military-actions-against-iran-have-gone-too-far/">l'Associated Press et l'universit&eacute; de Chicago<span class="sr-only">(Nouvelle fen&ecirc;tre)</span></a>, r&eacute;v&eacute;lait que 62% des Am&eacute;ricains s'opposaient fermement &agrave; un d&eacute;ploiement de troupes de combat&nbsp;sur le sol iranien.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
',
2,
1,
NOW(),
1
),

(
'Conséquences humanitaires et perspectives d’avenir',
'Étude des impacts du conflit sur la population civile et des solutions possibles.',
'Les conséquences du conflit en Iran sont particulièrement lourdes pour la population civile. L’instabilité politique et économique entraîne une dégradation des conditions de vie, avec un accès limité aux services essentiels comme la santé, l’éducation et l’alimentation.

On observe également une augmentation des migrations internes et externes, certaines populations cherchant à fuir les zones les plus touchées par les tensions. Les organisations humanitaires rencontrent souvent des difficultés à intervenir efficacement en raison des contraintes politiques et logistiques.

Sur le plan international, plusieurs initiatives diplomatiques ont été lancées pour tenter de désamorcer les tensions. Cependant, les négociations restent fragiles en raison du manque de confiance entre les parties.

À long terme, une solution durable nécessitera un dialogue inclusif, des réformes internes et une coopération internationale renforcée afin de stabiliser la région et améliorer les conditions de vie des populations.',
3,
1,
NOW(),
1
);