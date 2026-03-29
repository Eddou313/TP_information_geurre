<?php
function connectDB(): ?PDO {
    $host = 'localhost';
    $port = '5432';
    $dbname = 'information_guerre';
    $user = 'postgres';
    $password = 'postgres';

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
