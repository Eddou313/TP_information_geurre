<?php

/**
 * Connexion a la base de donnees PostgreSQL
 * Supporte les variables d'environnement Docker
 * @return PDO|null Instance PDO ou null en cas d'erreur
 */
function connectDB(): ?PDO {
    // Utiliser les variables d'environnement si disponibles (Docker)
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'information_guerre';
    $user = getenv('DB_USER') ?: 'postgres';
    $password = getenv('DB_PASSWORD') ?: 'postgres';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erreur de connexion PostgreSQL: " . $e->getMessage());
        return null;
    }
}
