<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';

// Handle delete
if (isset($_GET['delete'])) {
    $result = deleteArticle((int)$_GET['delete']);
    header('Location: list.php?msg=' . ($result['success'] ? 'deleted' : 'error'));
    exit;
}

$articles = getAllArticles();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Articles - Back Office</title>
    <link rel="stylesheet" href="../../../static/css/admin.css">
</head>
<body>
    <nav class="admin-navbar">
        <h1>Back Office</h1>
        <div class="nav-links">
            <a href="../home.php">Tableau de bord</a>
            <a href="list.php" class="active">Articles</a>
            <a href="../logout.php" class="btn-logout">Deconnexion</a>
        </div>
    </nav>

    <div class="admin-container">
        <div class="page-header">
            <h2>Gestion des Articles</h2>
            <a href="add.php" class="btn btn-primary">+ Nouvel Article</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'created'): ?>
                <div class="alert alert-success">Article cree avec succes!</div>
            <?php elseif ($_GET['msg'] === 'updated'): ?>
                <div class="alert alert-success">Article mis a jour avec succes!</div>
            <?php elseif ($_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-success">Article supprime avec succes!</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3>Liste des articles (<?php echo count($articles); ?>)</h3>
            </div>
            <div class="card-body">
                <?php if (empty($articles)): ?>
                    <div class="empty-state">
                        <div class="icon">&#128196;</div>
                        <h3>Aucun article</h3>
                        <p>Commencez par creer votre premier article.</p>
                        <a href="add.php" class="btn btn-primary">Creer un article</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articles as $article): ?>
                                    <tr>
                                        <td>
                                            <?php if ($article['image_principale']): ?>
                                                <img src="../../../<?php echo htmlspecialchars($article['image_principale']); ?>"
                                                     alt="" class="thumbnail">
                                            <?php else: ?>
                                                <div class="thumbnail" style="background:#eee;display:flex;align-items:center;justify-content:center;">-</div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($article['titre']); ?></strong>
                                            <br>
                                            <small style="color:#888;"><?php echo htmlspecialchars(substr($article['chapeau'], 0, 60)); ?>...</small>
                                        </td>
                                        <td><?php echo htmlspecialchars($article['auteur'] ?? 'N/A'); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($article['date_creation'])); ?></td>
                                        <td>
                                            <?php if ($article['status'] == 1): ?>
                                                <span class="badge badge-success">Publie</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Brouillon</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="view.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-secondary" title="Voir">&#128065;</a>
                                                <a href="edit.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">&#9998;</a>
                                                <a href="list.php?delete=<?php echo $article['id']; ?>"
                                                   class="btn btn-sm btn-danger"
                                                   data-confirm="Etes-vous sur de vouloir supprimer cet article ?"
                                                   title="Supprimer">&#128465;</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="../../../static/js/admin.js"></script>
</body>
</html>
