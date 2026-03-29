-- Table pour les images multiples par article
CREATE TABLE IF NOT EXISTS articles_images (
    id SERIAL PRIMARY KEY,
    article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
    image_id INTEGER REFERENCES images(id) ON DELETE CASCADE
);
