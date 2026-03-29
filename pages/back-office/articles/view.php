<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';

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
            <h2>Apercu de l'Article</h2>
            <div style="display:flex;gap:10px;">
                <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-warning">&#9998; Modifier</a>
                <a href="list.php" class="btn btn-secondary">&#8592; Retour</a>
            </div>
        </div>

        <div class="article-view card">
            <?php if ($article['image_principale']): ?>
                <div class="article-header">
                    <img src="../../../<?php echo htmlspecialchars($article['image_principale']); ?>"
                         alt="<?php echo htmlspecialchars($article['titre']); ?>">
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
                            <img src="../../../<?php echo htmlspecialchars($img['chemin']); ?>"
                                 alt="<?php echo htmlspecialchars($img['nom_fichier']); ?>">
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
    </div>

    <script src="../../../static/js/admin.js"></script>
</body>
</html>
