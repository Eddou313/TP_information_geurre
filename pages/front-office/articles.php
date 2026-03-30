<?php
require_once __DIR__ . '/../../module/front-office/articles.php';

// Dates par defaut : semaine actuelle
$defaultDateFrom = date('Y-m-d', strtotime('-7 days'));
$defaultDateTo = date('Y-m-d');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$showAll = isset($_GET['all']) && $_GET['all'] === '1';

if ($showAll) {
    $dateFrom = null;
    $dateTo = null;
} else {
    $dateFrom = isset($_GET['date_from']) && $_GET['date_from'] !== '' ? $_GET['date_from'] : $defaultDateFrom;
    $dateTo = isset($_GET['date_to']) && $_GET['date_to'] !== '' ? $_GET['date_to'] : $defaultDateTo;
}

$result = getPublishedArticles($page, $dateFrom, $dateTo);
$articles = $result['articles'];
$total = $result['total'];
$totalPages = $result['totalPages'];
$currentPage = $result['currentPage'];

function buildQueryString(array $params): string {
    return http_build_query(array_filter($params, fn($v) => $v !== null && $v !== ''));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Consultez les derniers articles publies sur Information Guerre, avec filtrage par date et pagination.">
    <meta name="robots" content="index, follow">
    <title>Articles - Information Guerre</title>
    <link rel="stylesheet" href="/TP_information_geurre/static/css/articles.css">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <div class="container">
        <h2 class="page-title">Nos Articles</h2>

        <form class="filter-form" method="GET" action="">
            <div class="filter-group">
                <label for="date_from">Du</label>
                <input type="date" id="date_from" name="date_from"
                       value="<?php echo htmlspecialchars($dateFrom ?? ''); ?>">
            </div>
            <div class="filter-group">
                <label for="date_to">Au</label>
                <input type="date" id="date_to" name="date_to"
                       value="<?php echo htmlspecialchars($dateTo ?? ''); ?>">
            </div>
            <button type="submit" class="btn-filter">Filtrer</button>
            <?php if ($showAll): ?>
                <a href="articles.php" class="btn-filter">Cette semaine</a>
            <?php else: ?>
                <a href="articles.php?all=1" class="btn-reset">Tous les articles</a>
            <?php endif; ?>
        </form>

        <?php if (empty($articles)): ?>
            <div class="no-articles">
                <h2>Aucun article disponible</h2>
                <p>Les articles seront bientot publies.</p>
            </div>
        <?php else: ?>
            <div class="articles-grid">
                <?php foreach ($articles as $article): ?>
                    <article class="article-card">
                        <?php if ($article['image_chemin']): ?>
                               <img src="/TP_information_geurre/<?php echo htmlspecialchars($article['image_chemin']); ?>"
                                 alt="<?php echo htmlspecialchars($article['titre']); ?>"
                                 class="article-image">
                        <?php else: ?>
                            <div class="article-image-placeholder">
                                &#9998;
                            </div>
                        <?php endif; ?>

                        <div class="article-content">
                            <h3 class="article-title">
                                <a href="article.php?id=<?php echo $article['id']; ?>">
                                    <?php echo htmlspecialchars($article['titre']); ?>
                                </a>
                            </h3>
                            <p class="article-chapeau">
                                <?php echo htmlspecialchars($article['chapeau']); ?>
                            </p>
                            <div class="article-meta">
                                <span class="article-author">Par <?php echo htmlspecialchars($article['auteur']); ?></span>
                                <span class="article-date">
                                    <?php echo date('d/m/Y', strtotime($article['date_publication'])); ?>
                                </span>
                            </div>
                            <a href="articles/view-<?php echo $article['id']; ?>-<?php echo $article['titre']; ?>" class="btn-lire">Lire la suite</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <?php $progressPercent = ($currentPage / $totalPages) * 100; ?>
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        <span>Page</span>
                        <span class="current"><?php echo $currentPage; ?> / <?php echo $totalPages; ?></span>
                        <span>|</span>
                        <span><?php echo $total; ?> articles</span>
                    </div>

                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?<?php echo buildQueryString(['page' => $currentPage - 1, 'date_from' => $dateFrom, 'date_to' => $dateTo]); ?>"
                               class="btn-page">
                                <span class="arrow">&#8592;</span>
                                <span>Precedent</span>
                            </a>
                        <?php endif; ?>

                        <div class="page-numbers">
                            <?php
                            $start = max(1, $currentPage - 2);
                            $end = min($totalPages, $currentPage + 2);

                            if ($start > 1): ?>
                                <a href="?<?php echo buildQueryString(['page' => 1, 'date_from' => $dateFrom, 'date_to' => $dateTo]); ?>"
                                   class="page-number"><span>1</span></a>
                                <?php if ($start > 2): ?>
                                    <span class="page-dots">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <?php if ($i === $currentPage): ?>
                                    <span class="page-number active"><span><?php echo $i; ?></span></span>
                                <?php else: ?>
                                    <a href="?<?php echo buildQueryString(['page' => $i, 'date_from' => $dateFrom, 'date_to' => $dateTo]); ?>"
                                       class="page-number"><span><?php echo $i; ?></span></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($end < $totalPages): ?>
                                <?php if ($end < $totalPages - 1): ?>
                                    <span class="page-dots">...</span>
                                <?php endif; ?>
                                <a href="?<?php echo buildQueryString(['page' => $totalPages, 'date_from' => $dateFrom, 'date_to' => $dateTo]); ?>"
                                   class="page-number"><span><?php echo $totalPages; ?></span></a>
                            <?php endif; ?>
                        </div>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?<?php echo buildQueryString(['page' => $currentPage + 1, 'date_from' => $dateFrom, 'date_to' => $dateTo]); ?>"
                               class="btn-page">
                                <span>Suivant</span>
                                <span class="arrow">&#8594;</span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="pagination-progress">
                        <div class="pagination-progress-bar" style="width: <?php echo $progressPercent; ?>%"></div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="/TP_information_geurre/static/js/articles.js"></script>
</body>
</html>
