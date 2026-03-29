<?php
require_once __DIR__ . '/../database.php';

function getStats(): array {
    $pdo = connectDB();

    if (!$pdo) {
        return [
            'articles' => 0,
            'images' => 0,
            'users' => 0
        ];
    }

    try {
        return [
            'articles' => $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn(),
            'images' => $pdo->query("SELECT COUNT(*) FROM images")->fetchColumn(),
            'users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn()
        ];
    } catch (PDOException $e) {
        error_log("Erreur stats: " . $e->getMessage());
        return [
            'articles' => 0,
            'images' => 0,
            'users' => 0
        ];
    }
}
