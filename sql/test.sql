-- =========================
-- SUPPRESSION (optionnel si tu recrées)
-- =========================
DROP TABLE IF EXISTS articles_images CASCADE;
DROP TABLE IF EXISTS articles CASCADE;
DROP TABLE IF EXISTS images CASCADE;

-- =========================
-- TABLE DES IMAGES
-- =========================
CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nom_fichier VARCHAR(255) NOT NULL,
    chemin VARCHAR(255) NOT NULL
);

-- =========================
-- TABLE DES ARTICLES
-- =========================
CREATE TABLE articles (
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

-- =========================
-- TABLE DES IMAGES SUPPLEMENTAIRES
-- =========================
CREATE TABLE articles_images (
    id SERIAL PRIMARY KEY,
    article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
    image_id INTEGER REFERENCES images(id) ON DELETE CASCADE
);

-- =========================
-- RESET DES SEQUENCES (IMPORTANT)
-- =========================
ALTER SEQUENCE images_id_seq RESTART WITH 1;
ALTER SEQUENCE articles_id_seq RESTART WITH 1;
ALTER SEQUENCE articles_images_id_seq RESTART WITH 1;