<?php


require_once __DIR__ . '/module/database.php';

function dropTables($pdo): bool {
    try {
        echo "Suppression des tables existantes...\n";
        
        $tables = [
            'articles_images',
            'articles',
            'images',
            'users'
        ];
        
        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS $table CASCADE");
            echo "   ✓ Table $table supprimée\n";
        }
        
        echo " Toutes les tables supprimées\n\n";
        return true;
    } catch (PDOException $e) {
        echo " Erreur lors de la suppression: " . $e->getMessage() . "\n";
        return false;
    }
}

function runMigrations($rebuild = false): bool {
    $pdo = connectDB();
    
    if (!$pdo) {
        echo " Erreur : Impossible de se connecter à la base de données\n";
        return false;
    }

    try {
        // Si --rebuild, supprimer les tables d'abord
        if ($rebuild) {
            if (!dropTables($pdo)) {
                return false;
            }
        }

        // Désactiver les contraintes de clés étrangères temporairement
        $pdo->exec("SET CONSTRAINTS ALL DEFERRED");

        // Migration 1: Créer la table users
        echo "Migration de la table users...\n";
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) NOT NULL UNIQUE,
                passwords VARCHAR(255) NOT NULL
            )
        ");
        
        // Vérifier si l'admin existe déjà
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
        $result = $stmt->fetch();
        
        if ($result['count'] == 0) {
            $pdo->exec("INSERT INTO users (username, passwords) VALUES ('admin', 'adminpassword')");
            echo "Table users créée et utilisateur admin inséré\n";
        } else {
            echo "Table users déjà existante\n";
        }

        // Migration 2: Créer la table images
        echo "Migration de la table images...\n";
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS images (
                id SERIAL PRIMARY KEY,
                date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                nom_fichier VARCHAR(255) NOT NULL,
                chemin VARCHAR(255) NOT NULL
            )
        ");
        echo "Table images créée/vérifiée\n";

        // Migration 3: Créer la table articles
        echo "Migration de la table articles...\n";
        $pdo->exec("
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
            )
        ");
        echo "Table articles créée/vérifiée\n";

        // Migration 4: Créer la table articles_images
        echo "Migration de la table articles_images...\n";
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS articles_images (
                id SERIAL PRIMARY KEY,
                article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
                image_id INTEGER REFERENCES images(id) ON DELETE CASCADE
            )
        ");
        echo "Table articles_images créée/vérifiée\n";

        echo "\n Migrations terminées avec succès!\n";
        return true;

    } catch (PDOException $e) {
        echo "Erreur lors de la migration: " . $e->getMessage() . "\n";
        return false;
    }
}

// Exécuter les migrations si le fichier est appelé directement
if (php_sapi_name() === 'cli' || (php_sapi_name() !== 'cli' && basename($_SERVER['SCRIPT_FILENAME']) === 'migrate.php')) {
    // Vérifier les arguments
    $rebuild = false;
    
    if (php_sapi_name() === 'cli') {
        // En ligne de commande
        global $argv;
        $rebuild = in_array('--rebuild', $argv);
        
        if ($rebuild) {
            echo "Mode REBUILD activé - Les tables existantes seront supprimées!\n\n";
        }
    } else {
        // Via navigateur, vérifier les paramètres GET
        $rebuild = isset($_GET['rebuild']) && $_GET['rebuild'] === 'true';
    }
    
    $success = runMigrations($rebuild);
    exit($success ? 0 : 1);
}

// Sinon, retourner juste la fonction
return true;
