<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /TP_information_geurre/admins');
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
    header('Location: /TP_information_geurre/admins/articles?msg=' . ($result['success'] ? 'deleted' : 'error'));
    exit;
}

// Filters - valeurs par defaut: semaine actuelle
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
$status = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : null;

$result = getAllArticles($page, $dateFrom, $dateTo, $status);
$articles = $result['articles'];
$total = $result['total'];
$totalPages = $result['totalPages'];
$currentPageNum = $result['currentPage'];

function buildQueryString(array $params): string {
    return http_build_query(array_filter($params, fn($v) => $v !== null && $v !== ''));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion de la liste des articles Back Office avec filtres, statut de publication et actions d'administration.">
    <!-- <meta name="robots" content="noindex, nofollow"> -->
    <title>Gestion des Articles - Back Office</title>
    <link rel="stylesheet" href="/TP_information_geurre/static/css/admin.css">
    <style>
        .filter-bar {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .filter-bar form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .filter-group label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
        }
        .filter-group input,
        .filter-group select {
            padding: 10px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-width: 150px;
        }
        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        .filter-actions {
            display: flex;
            gap: 10px;
        }
        .btn-filter {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-filter:hover {
            opacity: 0.9;
        }
        .btn-reset {
            padding: 10px 20px;
            background: #95a5a6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-reset:hover {
            background: #7f8c8d;
        }
        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 0 5px;
        }
        .results-info span {
            font-size: 14px;
            color: #666;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }
        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .pagination a {
            background: #f5f5f5;
            color: #555;
        }
        .pagination a:hover {
            background: #667eea;
            color: white;
        }
        .pagination span.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .pagination span.dots {
            background: transparent;
            color: #999;
        }
        .pagination .btn-nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .pagination .btn-nav:hover {
            opacity: 0.9;
        }
        .pagination .btn-nav svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filter-bar form {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-group {
                width: 100%;
            }
            .filter-group input,
            .filter-group select {
                width: 100%;
                min-width: auto;
            }
            .filter-actions {
                flex-direction: column;
                width: 100%;
            }
            .filter-actions .btn-filter,
            .filter-actions .btn-reset {
                width: 100%;
                justify-content: center;
            }
            .results-info {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            .admin-table {
                font-size: 12px;
            }
            .admin-table th:nth-child(3),
            .admin-table td:nth-child(3),
            .admin-table th:nth-child(4),
            .admin-table td:nth-child(4) {
                display: none;
            }
            .pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="page-header">
                <h2>Gestion des Articles</h2>
                <a href="/TP_information_geurre/admins/articles/add" class="btn btn-primary">
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

            <!-- Filters -->
            <div class="filter-bar">
                <form method="GET" action="">
                    <div class="filter-group">
                        <label>Date debut</label>
                        <input type="date" name="date_from" value="<?php echo htmlspecialchars($dateFrom ?? ''); ?>">
                    </div>
                    <div class="filter-group">
                        <label>Date fin</label>
                        <input type="date" name="date_to" value="<?php echo htmlspecialchars($dateTo ?? ''); ?>">
                    </div>
                    <div class="filter-group">
                        <label>Statut</label>
                        <select name="status">
                            <option value="">Tous</option>
                            <option value="1" <?php echo $status === '1' ? 'selected' : ''; ?>>Publie</option>
                            <option value="0" <?php echo $status === '0' ? 'selected' : ''; ?>>Brouillon</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Filtrer
                        </button>
                        <?php if ($showAll): ?>
                            <a href="/TP_information_geurre/admins/articles" class="btn-filter" style="background:#27ae60;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Cette semaine
                            </a>
                        <?php else: ?>
                            <a href="/TP_information_geurre/admins/articles?all=1<?php echo $status !== null ? '&status=' . $status : ''; ?>" class="btn-reset">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                                Tous les articles
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Liste des articles</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($articles)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <h3>Aucun article trouve</h3>
                            <p>Aucun article ne correspond a vos criteres.</p>
                        </div>
                    <?php else: ?>
                        <div class="results-info">
                            <span>Affichage <?php echo (($currentPageNum - 1) * ADMIN_ARTICLES_PER_PAGE) + 1; ?> - <?php echo min($currentPageNum * ADMIN_ARTICLES_PER_PAGE, $total); ?> sur <?php echo $total; ?> articles</span>
                        </div>

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
                                                    <img src="/TP_information_geurre/<?php echo htmlspecialchars($article['image_principale']); ?>" alt="Miniature de l'article <?php echo htmlspecialchars($article['titre']); ?>" class="thumbnail">
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
                                                    <a href="/TP_information_geurre/admins/articles/view-<?php echo $article['id']; ?>" class="btn btn-sm btn-secondary" title="Voir">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </a>
                                                    <a href="/TP_information_geurre/admins/articles/edit-<?php echo $article['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    </a>
                                                    <a href="/TP_information_geurre/admins/articles/delete-<?php echo $article['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Etes-vous sur de vouloir supprimer cet article ?" title="Supprimer">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="pagination">
                                <?php if ($currentPageNum > 1): ?>
                                    <a href="?<?php echo buildQueryString(['page' => $currentPageNum - 1, 'date_from' => $showAll ? null : $dateFrom, 'date_to' => $showAll ? null : $dateTo, 'status' => $status, 'all' => $showAll ? '1' : null]); ?>" class="btn-nav">
                                        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                                    </a>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $currentPageNum - 2);
                                $end = min($totalPages, $currentPageNum + 2);

                                if ($start > 1): ?>
                                    <a href="?<?php echo buildQueryString(['page' => 1, 'date_from' => $showAll ? null : $dateFrom, 'date_to' => $showAll ? null : $dateTo, 'status' => $status, 'all' => $showAll ? '1' : null]); ?>">1</a>
                                    <?php if ($start > 2): ?>
                                        <span class="dots">...</span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php for ($i = $start; $i <= $end; $i++): ?>
                                    <?php if ($i === $currentPageNum): ?>
                                        <span class="current"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <a href="?<?php echo buildQueryString(['page' => $i, 'date_from' => $showAll ? null : $dateFrom, 'date_to' => $showAll ? null : $dateTo, 'status' => $status, 'all' => $showAll ? '1' : null]); ?>"><?php echo $i; ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($end < $totalPages): ?>
                                    <?php if ($end < $totalPages - 1): ?>
                                        <span class="dots">...</span>
                                    <?php endif; ?>
                                    <a href="?<?php echo buildQueryString(['page' => $totalPages, 'date_from' => $showAll ? null : $dateFrom, 'date_to' => $showAll ? null : $dateTo, 'status' => $status, 'all' => $showAll ? '1' : null]); ?>"><?php echo $totalPages; ?></a>
                                <?php endif; ?>

                                <?php if ($currentPageNum < $totalPages): ?>
                                    <a href="?<?php echo buildQueryString(['page' => $currentPageNum + 1, 'date_from' => $showAll ? null : $dateFrom, 'date_to' => $showAll ? null : $dateTo, 'status' => $status, 'all' => $showAll ? '1' : null]); ?>" class="btn-nav">
                                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>

    <script src="/TP_information_geurre/static/js/admin.js"></script>
</body>
</html>
