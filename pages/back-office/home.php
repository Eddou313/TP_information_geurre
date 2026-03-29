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
    <title>Tableau de bord - Back Office</title>
    <link rel="stylesheet" href="../../static/css/admin.css">
    <style>
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .dashboard-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .dashboard-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .dashboard-card h3 {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }
        .dashboard-card .number {
            font-size: 42px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-decoration: none;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        .action-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }
        .action-card .icon.articles { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .action-card .icon.images { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .action-card .icon.users { background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); }
        .action-card h4 {
            font-size: 16px;
        }
        .action-card p {
            font-size: 13px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <h1>Back Office</h1>
        <div class="nav-links">
            <a href="home.php" class="active">Tableau de bord</a>
            <a href="articles/list.php">Articles</a>
            <a href="logout.php" class="btn-logout">Deconnexion</a>
        </div>
    </nav>

    <div class="admin-container">
        <div class="page-header">
            <h2>Bienvenue, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="icon">&#128196;</div>
                <h3>Articles</h3>
                <div class="number"><?php echo $stats['articles']; ?></div>
            </div>
            <div class="dashboard-card">
                <div class="icon">&#128247;</div>
                <h3>Images</h3>
                <div class="number"><?php echo $stats['images']; ?></div>
            </div>
            <div class="dashboard-card">
                <div class="icon">&#128100;</div>
                <h3>Utilisateurs</h3>
                <div class="number"><?php echo $stats['users']; ?></div>
            </div>
        </div>

        <h3 style="margin-bottom:20px;color:#2c3e50;">Actions rapides</h3>
        <div class="quick-actions">
            <a href="articles/add.php" class="action-card">
                <div class="icon articles">+</div>
                <h4>Nouvel Article</h4>
                <p>Creer un nouvel article avec images</p>
            </a>
            <a href="articles/list.php" class="action-card">
                <div class="icon articles">&#128196;</div>
                <h4>Gerer les Articles</h4>
                <p>Voir, modifier, supprimer les articles</p>
            </a>
        </div>
    </div>

    <script src="../../static/js/admin.js"></script>
</body>
</html>
