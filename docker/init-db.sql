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
