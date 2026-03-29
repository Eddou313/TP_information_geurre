<?php
require_once __DIR__ . '/../../module/back-office/auth.php';
requireAuth();

$user = getSessionUser();

require_once __DIR__ . '/../../module/back-office/stats.php';
$stats = getStats();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Back Office</title>
    <link rel="stylesheet" href="../../static/css/home.css">
</head>
<body>
    <nav class="navbar">
        <h1>Back Office</h1>
        <div class="user-info">
            <span>Bienvenue, <?php echo htmlspecialchars($user['username']); ?></span>
            <a href="logout.php">Deconnexion</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h2>Connexion reussie!</h2>
            <p>Vous etes connecte en tant que <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
            <p>ID utilisateur: <?php echo $user['id']; ?></p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>Articles</h3>
                <div class="number"><?php echo $stats['articles']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Images</h3>
                <div class="number"><?php echo $stats['images']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Utilisateurs</h3>
                <div class="number"><?php echo $stats['users']; ?></div>
            </div>
        </div>
    </div>

    <script src="../../static/js/home.js"></script>
</body>
</html>
