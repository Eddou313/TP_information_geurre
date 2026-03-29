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
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>Back Office</h1>
                <span>Gestion de contenu</span>
            </div>

            <nav class="sidebar-nav">
                <a href="home.php" class="nav-link active">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Tableau de bord
                </a>

                <div class="nav-item open">
                    <a href="#" class="nav-link" onclick="toggleDropdown(this.parentElement); return false;">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Articles
                        <span class="arrow">
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </a>
                    <div class="nav-dropdown">
                        <a href="articles/list.php" class="nav-link">
                            <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            Liste
                        </a>
                        <a href="articles/add.php" class="nav-link">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Creer
                        </a>
                    </div>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <h4><?php echo htmlspecialchars($user['username']); ?></h4>
                        <span>Administrateur</span>
                    </div>
                </div>
                <a href="logout.php" class="btn-logout-sidebar">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Deconnexion
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h2>Tableau de bord</h2>
                    <p>Bienvenue, <?php echo htmlspecialchars($user['username']); ?>!</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon articles">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['articles']; ?></h3>
                        <p>Articles</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon images">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['images']; ?></h3>
                        <p>Images</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon users">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['users']; ?></h3>
                        <p>Utilisateurs</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <h3 class="section-title">Actions rapides</h3>
            <div class="actions-grid">
                <a href="articles/add.php" class="action-card">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div class="action-text">
                        <h4>Nouvel Article</h4>
                        <p>Creer un nouvel article avec images</p>
                    </div>
                </a>
                <a href="articles/list.php" class="action-card">
                    <div class="action-icon">
                        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </div>
                    <div class="action-text">
                        <h4>Gerer les Articles</h4>
                        <p>Voir, modifier, supprimer</p>
                    </div>
                </a>
            </div>
        </main>
    </div>

    <script>
        function toggleDropdown(element) {
            element.classList.toggle('open');
        }
    </script>
</body>
</html>
