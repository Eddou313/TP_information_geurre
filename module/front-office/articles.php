<?php
require_once __DIR__ . '/../database.php';

define('ARTICLES_PER_PAGE', 6);

/**
 * Generate a URL-friendly slug from a string
 */
function generateSlug(string $text): string {
    // Convert to lowercase
    $slug = mb_strtolower($text, 'UTF-8');

    // Replace accented characters
    $accents = [
        'à' => 'a', 'â' => 'a', 'ä' => 'a', 'á' => 'a', 'ã' => 'a',
        'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'é' => 'e',
        'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'í' => 'i',
        'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'ó' => 'o', 'õ' => 'o',
        'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ú' => 'u',
        'ý' => 'y', 'ÿ' => 'y',
        'ñ' => 'n', 'ç' => 'c',
        'œ' => 'oe', 'æ' => 'ae'
    ];
    $slug = strtr($slug, $accents);

    // Replace non-alphanumeric characters with hyphens
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    // Remove leading/trailing hyphens and multiple consecutive hyphens
    $slug = trim($slug, '-');
    $slug = preg_replace('/-+/', '-', $slug);

    return $slug;
}

/**
 * Generate article URL
 */
function getArticleUrl(int $id, string $titre): string {
    $slug = generateSlug($titre);
    return '/TP_information_geurre/article/' . $id . '-' . $slug;
}

function getPublishedArticles(int $page = 1, ?string $dateFrom = null, ?string $dateTo = null): array {
    $pdo = connectDB();

    if (!$pdo) {
        return ['articles' => [], 'total' => 0, 'totalPages' => 0, 'currentPage' => 1];
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
        $article = $stmt->fetch();

        if (!$article) {
            return null;
        }

        // Load supplementary images linked through articles_images.
        $imagesSql = "SELECT i.id, i.nom_fichier, i.chemin
                      FROM images i
                      JOIN articles_images ai ON ai.image_id = i.id
                      WHERE ai.article_id = :article_id";
        $imagesStmt = $pdo->prepare($imagesSql);
        $imagesStmt->execute(['article_id' => $id]);
        $article['images'] = $imagesStmt->fetchAll();

        return $article;
    } catch (PDOException $e) {
        error_log("Erreur article: " . $e->getMessage());
        return null;
    }
}
