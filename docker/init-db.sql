-- =============================================
-- Script d'initialisation de la base de donnees
-- Information Guerre - Docker
-- =============================================

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL
);

-- Utilisateur admin par defaut
INSERT INTO users (username, passwords) VALUES ('admin', 'adminpassword')
ON CONFLICT (username) DO NOTHING;

-- Table des images
CREATE TABLE IF NOT EXISTS images (
    id SERIAL PRIMARY KEY,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nom_fichier VARCHAR(255) NOT NULL,
    chemin VARCHAR(255) NOT NULL
);

-- Table des articles
CREATE TABLE IF NOT EXISTS articles (
    id SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    chapeau VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    image_id INTEGER REFERENCES images(id),
    author_id INTEGER REFERENCES users(id),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_publication TIMESTAMP,
    status INTEGER NOT NULL DEFAULT 0
);

-- Table pour les images supplementaires (multi-images)
CREATE TABLE IF NOT EXISTS articles_images (
    id SERIAL PRIMARY KEY,
    article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
    image_id INTEGER REFERENCES images(id) ON DELETE CASCADE
);

-- =============================================
-- Donnees de demonstration
-- =============================================

-- Images de demonstration
INSERT INTO images (nom_fichier, chemin) VALUES
('iran_contexte.jpg', 'uploads/iran_contexte.jpg'),
('iran_acteurs.jpg', 'uploads/iran_acteurs.jpg'),
('iran_humanitaire.jpg', 'uploads/iran_humanitaire.jpg')
ON CONFLICT DO NOTHING;

-- Articles de demonstration
INSERT INTO articles (titre, chapeau, contenu, image_id, author_id, date_publication, status) VALUES
(
    'Origines et contexte du conflit en Iran',
    'Analyse detaillee des causes historiques, politiques et economiques de la crise iranienne.',
    'Le conflit en Iran s''inscrit dans un contexte historique complexe marque par des tensions politiques internes et des pressions internationales. Depuis la revolution de 1979, le pays a connu des transformations profondes dans son systeme politique, entrainant des relations tendues avec plusieurs puissances occidentales.

Les sanctions economiques imposees au fil des annees ont fortement impacte l''economie iranienne, provoquant inflation, chomage et baisse du pouvoir d''achat. Ces difficultes economiques ont alimente le mecontentement social et des mouvements de contestation.

Par ailleurs, la position geopolitique strategique de l''Iran au Moyen-Orient en fait un acteur cle dans plusieurs conflits regionaux. Les rivalites avec certains pays voisins et les interventions indirectes dans d''autres zones de guerre ont contribue a intensifier les tensions.

Ainsi, le conflit actuel est le resultat d''un enchevetrement de facteurs historiques, economiques et geopolitiques qui rendent la situation particulierement complexe a resoudre.',
    1, 1, NOW(), 1
),
(
    'Les acteurs et les enjeux geopolitiques',
    'Presentation des principaux acteurs impliques et des interets en jeu dans le conflit.',
    'Le conflit en Iran implique une diversite d''acteurs aux interets souvent divergents. A l''interieur du pays, le gouvernement central fait face a des groupes d''opposition qui contestent sa legitimite et ses politiques.

A l''echelle internationale, plusieurs puissances jouent un role indirect mais determinant. Certaines soutiennent le gouvernement iranien pour des raisons strategiques, tandis que d''autres cherchent a limiter son influence dans la region.

Les enjeux sont multiples : controle des ressources energetiques, influence politique au Moyen-Orient, securite regionale et equilibre des puissances. L''Iran, disposant de vastes reserves de petrole et de gaz, represente un acteur economique majeur, ce qui renforce l''interet des puissances etrangeres.

Les alliances et les rivalites internationales rendent toute resolution du conflit difficile, car chaque acteur cherche a preserver ses propres interets avant tout.',
    2, 1, NOW(), 1
),
(
    'Consequences humanitaires et perspectives d''avenir',
    'Etude des impacts du conflit sur la population civile et des solutions possibles.',
    'Les consequences du conflit en Iran sont particulierement lourdes pour la population civile. L''instabilite politique et economique entraine une degradation des conditions de vie, avec un acces limite aux services essentiels comme la sante, l''education et l''alimentation.

On observe egalement une augmentation des migrations internes et externes, certaines populations cherchant a fuir les zones les plus touchees par les tensions. Les organisations humanitaires rencontrent souvent des difficultes a intervenir efficacement en raison des contraintes politiques et logistiques.

Sur le plan international, plusieurs initiatives diplomatiques ont ete lancees pour tenter de desamorcer les tensions. Cependant, les negociations restent fragiles en raison du manque de confiance entre les parties.

A long terme, une solution durable necessitera un dialogue inclusif, des reformes internes et une cooperation internationale renforcee afin de stabiliser la region et ameliorer les conditions de vie des populations.',
    3, 1, NOW(), 1
)
ON CONFLICT DO NOTHING;
