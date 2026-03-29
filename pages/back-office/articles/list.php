<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';
require_once __DIR__ . '/../../../module/back-office/auth.php';

$user = getSessionUser();
$currentPage = 'articles-list';
$basePath = '../';

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
    <div class="admin-layout">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="page-header">
                <h2>Gestion des Articles</h2>
                <a href="add.php" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nouvel Article
                </a>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <?php if ($_GET['msg'] === 'created'): ?>
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Article cree avec succes!
                    </div>
                <?php elseif ($_GET['msg'] === 'updated'): ?>
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Article mis a jour avec succes!
                    </div>
                <?php elseif ($_GET['msg'] === 'deleted'): ?>
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Article supprime avec succes!
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3>Liste des articles (<?php echo count($articles); ?>)</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($articles)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <h3>Aucun article</h3>
                            <p>Commencez par creer votre premier article.</p>
                            <a href="add.php" class="btn btn-primary" style="margin-top:15px;">Creer un article</a>
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
                                                    <img src="../../../<?php echo htmlspecialchars($article['image_principale']); ?>" alt="" class="thumbnail">
                                                <?php else: ?>
                                                    <div class="thumbnail" style="background:#eee;display:flex;align-items:center;justify-content:center;color:#999;">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($article['titre']); ?></strong>
                                                <br>
                                                <small style="color:#888;"><?php echo htmlspecialchars(substr($article['chapeau'], 0, 50)); ?>...</small>
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
                                                    <a href="view.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-secondary" title="Voir">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </a>
                                                    <a href="edit.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    </a>
                                                    <a href="list.php?delete=<?php echo $article['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Etes-vous sur de vouloir supprimer cet article ?" title="Supprimer">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    </a>
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
        </main>
    </div>

    <script src="../../../static/js/admin.js"></script>
</body>
</html>
