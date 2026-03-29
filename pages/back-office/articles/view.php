<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';
require_once __DIR__ . '/../../../module/back-office/auth.php';

$user = getSessionUser();
$currentPage = 'articles-view';
$basePath = '../';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = getArticleForEdit($id);

if (!$article) {
    header('Location: list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['titre']); ?> - Back Office</title>
    <link rel="stylesheet" href="../../../static/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="page-header">
                <h2>Apercu de l'Article</h2>
                <div style="display:flex;gap:10px;">
                    <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-warning">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Modifier
                    </a>
                    <a href="list.php" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Retour
                    </a>
                </div>
            </div>

            <div class="article-view card">
                <?php if ($article['image_principale']): ?>
                    <div class="article-header">
                        <img src="../../../<?php echo htmlspecialchars($article['image_principale']); ?>" alt="<?php echo htmlspecialchars($article['titre']); ?>">
                    </div>
                <?php endif; ?>

                <div class="article-body">
                    <div style="margin-bottom:20px;">
                        <?php if ($article['status'] == 1): ?>
                            <span class="badge badge-success">Publie</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Brouillon</span>
                        <?php endif; ?>
                    </div>

                    <h1><?php echo htmlspecialchars($article['titre']); ?></h1>

                    <p class="chapeau"><?php echo htmlspecialchars($article['chapeau']); ?></p>

                    <div class="content">
                        <?php
                        $paragraphs = explode("\n\n", $article['contenu']);
                        foreach ($paragraphs as $paragraph):
                            if (trim($paragraph)):
                        ?>
                            <p><?php echo nl2br(htmlspecialchars($paragraph)); ?></p>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>

                    <?php if (!empty($article['images'])): ?>
                        <h3 style="margin-top:40px;margin-bottom:20px;">Galerie d'images</h3>
                        <div class="gallery">
                            <?php foreach ($article['images'] as $img): ?>
                                <img src="../../../<?php echo htmlspecialchars($img['chemin']); ?>" alt="<?php echo htmlspecialchars($img['nom_fichier']); ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="meta">
                        <span><strong>Date de creation:</strong> <?php echo date('d/m/Y H:i', strtotime($article['date_creation'])); ?></span>
                        <?php if ($article['date_publication']): ?>
                            <span><strong>Date de publication:</strong> <?php echo date('d/m/Y H:i', strtotime($article['date_publication'])); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../../../static/js/admin.js"></script>
</body>
</html>
