<?php
require_once __DIR__ . '/../../module/front-office/articles.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = getArticleById($id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lecture detaillee d'un article Information Guerre avec son chapeau, son contenu et ses informations de publication.">
    <meta name="robots" content="index, follow">
    <title><?php echo $article ? htmlspecialchars($article['titre']) : 'Article non trouve'; ?> - Information Guerre</title>
    <link rel="stylesheet" href="/TP_information_geurre/static/css/article-detail.css">
</head>
<body>
    <nav class="navbar">
        <h1>Information Guerre</h1>
        <a href="../">Retour aux articles</a>
    </nav>

    <div class="article-container">
        <?php if (!$article): ?>
            <div class="not-found">
                <h2>Article non trouve</h2>
                <p>L'article que vous recherchez n'existe pas ou n'est plus disponible.</p>
                <a href="articles.php">Voir tous les articles</a>
            </div>
        <?php else: ?>
            <div class="article-header">
                <?php if ($article['image_chemin']): ?>
                    <img src="/TP_information_geurre/<?php echo htmlspecialchars($article['image_chemin']); ?>"
                         alt="<?php echo htmlspecialchars($article['titre']); ?>">
                <?php endif; ?>

                <div class="article-header-content">
                    <h1><?php echo htmlspecialchars($article['titre']); ?></h1>
                    <p class="article-chapeau"><?php echo htmlspecialchars($article['chapeau']); ?></p>
                    <div class="article-meta">
                        <span class="article-author">Par <?php echo htmlspecialchars($article['auteur']); ?></span>
                        <span>Publie le <?php echo date('d/m/Y', strtotime($article['date_publication'])); ?></span>
                    </div>
                </div>
            </div>

            <div class="article-body">
                <?php echo $article['contenu']; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
