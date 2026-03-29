<?php
require_once 'module/database.php';

echo "<h1>Test de connexion PostgreSQL</h1>";

$pdo = connectDB();

if ($pdo) {
    echo "<p style='color: green;'>Connexion reussie!</p>";

    // Test d'une requete simple
    try {
        $stmt = $pdo->query("SELECT version()");
        $version = $stmt->fetchColumn();
        echo "<p><strong>Version PostgreSQL:</strong> $version</p>";

        // Liste des tables
        $stmt = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
        $tables = $stmt->fetchAll();

        if ($tables) {
            echo "<p><strong>Tables disponibles:</strong></p><ul>";
            foreach ($tables as $table) {
                echo "<li>" . htmlspecialchars($table['tablename']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucune table trouvee dans le schema public.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de la requete: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color: red;'>Echec de la connexion a la base de donnees.</p>";
}
