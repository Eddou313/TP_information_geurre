CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL
);

INSERT INTO users (username, passwords) VALUES ('admin', 'adminpassword');

CREATE TABLE IF NOT EXISTS images (
    id SERIAL PRIMARY KEY,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nom_fichier VARCHAR(255) NOT NULL,
    chemin VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS articles (
    id SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    chapeau VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    image_id INTEGER REFERENCES images(id),
    author_id INTEGER REFERENCES users(id),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_publication TIMESTAMP,
    status integer NOT NULL DEFAULT 0
);

