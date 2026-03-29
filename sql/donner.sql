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
'Le conflit en Iran implique une diversité d’acteurs aux intérêts souvent divergents. À l’intérieur du pays, le gouvernement central fait face à des groupes d’opposition qui contestent sa légitimité et ses politiques.

À l’échelle internationale, plusieurs puissances jouent un rôle indirect mais déterminant. Certaines soutiennent le gouvernement iranien pour des raisons stratégiques, tandis que d’autres cherchent à limiter son influence dans la région.

Les enjeux sont multiples : contrôle des ressources énergétiques, influence politique au Moyen-Orient, sécurité régionale et équilibre des puissances. L’Iran, disposant de vastes réserves de pétrole et de gaz, représente un acteur économique majeur, ce qui renforce l’intérêt des puissances étrangères.

Les alliances et les rivalités internationales rendent toute résolution du conflit difficile, car chaque acteur cherche à préserver ses propres intérêts avant tout.',
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