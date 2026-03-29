<?php
require_once __DIR__ . '/../database.php';

define('ARTICLES_PER_PAGE', 6);

function getPublishedArticles(int $page = 1, ?string $dateFrom = null, ?string $dateTo = null): array {
    $pdo = connectDB();

    if (!$pdo) {
        return ['articles' => [], 'total' => 0, 'totalPages' => 0];
    }

    try {
        $where = "WHERE a.status = 1";
        $params = [];

        if ($dateFrom) {
            $where .= " AND a.date_publication >= :dateFrom";
            $params['dateFrom'] = $dateFrom;
        }
        if ($dateTo) {
            $where .= " AND a.date_publication <= :dateTo";
            $params['dateTo'] = $dateTo . ' 23:59:59';
        }

        // Count total
        $countSql = "SELECT COUNT(*) FROM articles a $where";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $totalPages = (int)ceil($total / ARTICLES_PER_PAGE);
        $page = max(1, min($page, $totalPages > 0 ? $totalPages : 1));
        $offset = ($page - 1) * ARTICLES_PER_PAGE;

        // Get articles
        $sql = "SELECT
                    a.id,
                    a.titre,
                    a.chapeau,
                    a.contenu,
                    a.date_publication,
                    a.status,
                    i.nom_fichier AS image_nom,
                    i.chemin AS image_chemin,
                    u.username AS auteur
                FROM articles a
                LEFT JOIN images i ON a.image_id = i.id
                LEFT JOIN users u ON a.author_id = u.id
                $where
                ORDER BY a.date_publication DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue('limit', ARTICLES_PER_PAGE, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'articles' => $stmt->fetchAll(),
            'total' => $total,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    } catch (PDOException $e) {
        error_log("Erreur articles: " . $e->getMessage());
        return ['articles' => [], 'total' => 0, 'totalPages' => 0, 'currentPage' => 1];
    }
}

function getArticleById(int $id): ?array {
    $pdo = connectDB();

    if (!$pdo) {
        return null;
    }

    try {
        $sql = "SELECT
                    a.id,
                    a.titre,
                    a.chapeau,
                    a.contenu,
                    a.date_publication,
                    a.status,
                    i.nom_fichier AS image_nom,
                    i.chemin AS image_chemin,
                    u.username AS auteur
                FROM articles a
                LEFT JOIN images i ON a.image_id = i.id
                LEFT JOIN users u ON a.author_id = u.id
                WHERE a.id = :id AND a.status = 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    } catch (PDOException $e) {
        error_log("Erreur article: " . $e->getMessage());
        return null;
    }
}
