<?php
require_once __DIR__ . '/../database.php';

define('ADMIN_ARTICLES_PER_PAGE', 10);

function getAllArticles(int $page = 1, ?string $dateFrom = null, ?string $dateTo = null, ?string $status = null): array {
    $pdo = connectDB();
    if (!$pdo) return ['articles' => [], 'total' => 0, 'totalPages' => 0, 'currentPage' => 1];

    try {
        $where = "WHERE 1=1";
        $params = [];

        if ($dateFrom) {
            $where .= " AND a.date_creation >= :dateFrom";
            $params['dateFrom'] = $dateFrom;
        }
        if ($dateTo) {
            $where .= " AND a.date_creation <= :dateTo";
            $params['dateTo'] = $dateTo . ' 23:59:59';
        }
        if ($status !== null && $status !== '') {
            $where .= " AND a.status = :status";
            $params['status'] = (int)$status;
        }

        // Count total
        $countSql = "SELECT COUNT(*) FROM articles a $where";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $totalPages = (int)ceil($total / ADMIN_ARTICLES_PER_PAGE);
        $page = max(1, min($page, $totalPages > 0 ? $totalPages : 1));
        $offset = ($page - 1) * ADMIN_ARTICLES_PER_PAGE;

        // Get articles
        $sql = "SELECT
                    a.id, a.titre, a.chapeau, a.status,
                    a.date_creation, a.date_publication,
                    u.username AS auteur,
                    i.chemin AS image_principale
                FROM articles a
                LEFT JOIN users u ON a.author_id = u.id
                LEFT JOIN images i ON a.image_id = i.id
                $where
                ORDER BY a.date_creation DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue('limit', ADMIN_ARTICLES_PER_PAGE, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'articles' => $stmt->fetchAll(),
            'total' => $total,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    } catch (PDOException $e) {
        error_log("Erreur getAllArticles: " . $e->getMessage());
        return ['articles' => [], 'total' => 0, 'totalPages' => 0, 'currentPage' => 1];
    }
}

function getArticleForEdit(int $id): ?array {
    $pdo = connectDB();
    if (!$pdo) return null;

    try {
        $sql = "SELECT a.*, i.chemin AS image_principale
                FROM articles a
                LEFT JOIN images i ON a.image_id = i.id
                WHERE a.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();

        if ($article) {
            $article['images'] = getArticleImages($id);
        }

        return $article ?: null;
    } catch (PDOException $e) {
        error_log("Erreur getArticleForEdit: " . $e->getMessage());
        return null;
    }
}

function getArticleImages(int $articleId): array {
    $pdo = connectDB();
    if (!$pdo) return [];

    try {
        $sql = "SELECT i.* FROM images i
                JOIN articles_images ai ON i.id = ai.image_id
                WHERE ai.article_id = :article_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erreur getArticleImages: " . $e->getMessage());
        return [];
    }
}

function createArticle(array $data, array $files): array {
    $pdo = connectDB();
    if (!$pdo) return ['success' => false, 'message' => 'Erreur de connexion'];

    try {
        $pdo->beginTransaction();

        // Upload image principale
        $imageId = null;
        if (isset($files['image_principale']) && $files['image_principale']['error'] === UPLOAD_ERR_OK) {
            $imageId = uploadImage($files['image_principale']);
        }

        // Insert article
        $sql = "INSERT INTO articles (titre, chapeau, contenu, image_id, author_id, date_publication, status)
                VALUES (:titre, :chapeau, :contenu, :image_id, :author_id, :date_publication, :status)
                RETURNING id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'titre' => $data['titre'],
            'chapeau' => $data['chapeau'],
            'contenu' => $data['contenu'],
            'image_id' => $imageId,
            'author_id' => $data['author_id'],
            'date_publication' => $data['status'] == 1 ? date('Y-m-d H:i:s') : null,
            'status' => $data['status']
        ]);
        $articleId = $stmt->fetchColumn();

        // Upload images supplementaires
        if (isset($files['images_supplementaires'])) {
            $images = $files['images_supplementaires'];
            for ($i = 0; $i < count($images['name']); $i++) {
                if ($images['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $images['name'][$i],
                        'type' => $images['type'][$i],
                        'tmp_name' => $images['tmp_name'][$i],
                        'error' => $images['error'][$i],
                        'size' => $images['size'][$i]
                    ];
                    $imgId = uploadImage($file);
                    if ($imgId) {
                        $pdo->prepare("INSERT INTO articles_images (article_id, image_id) VALUES (:article_id, :image_id)")
                            ->execute(['article_id' => $articleId, 'image_id' => $imgId]);
                    }
                }
            }
        }

        $pdo->commit();
        return ['success' => true, 'message' => 'Article cree avec succes', 'id' => $articleId];
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Erreur createArticle: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur lors de la creation'];
    }
}

function updateArticle(int $id, array $data, array $files): array {
    $pdo = connectDB();
    if (!$pdo) return ['success' => false, 'message' => 'Erreur de connexion'];

    try {
        $pdo->beginTransaction();

        // Upload nouvelle image principale si fournie
        $imageId = $data['current_image_id'] ?? null;
        if (isset($files['image_principale']) && $files['image_principale']['error'] === UPLOAD_ERR_OK) {
            $imageId = uploadImage($files['image_principale']);
        }

        // Update article
        $sql = "UPDATE articles SET
                    titre = :titre,
                    chapeau = :chapeau,
                    contenu = :contenu,
                    image_id = :image_id,
                    date_publication = :date_publication,
                    status = :status
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'titre' => $data['titre'],
            'chapeau' => $data['chapeau'],
            'contenu' => $data['contenu'],
            'image_id' => $imageId,
            'date_publication' => $data['status'] == 1 ? ($data['date_publication'] ?? date('Y-m-d H:i:s')) : null,
            'status' => $data['status']
        ]);

        // Upload nouvelles images supplementaires
        if (isset($files['images_supplementaires'])) {
            $images = $files['images_supplementaires'];
            for ($i = 0; $i < count($images['name']); $i++) {
                if ($images['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $images['name'][$i],
                        'type' => $images['type'][$i],
                        'tmp_name' => $images['tmp_name'][$i],
                        'error' => $images['error'][$i],
                        'size' => $images['size'][$i]
                    ];
                    $imgId = uploadImage($file);
                    if ($imgId) {
                        $pdo->prepare("INSERT INTO articles_images (article_id, image_id) VALUES (:article_id, :image_id)")
                            ->execute(['article_id' => $id, 'image_id' => $imgId]);
                    }
                }
            }
        }

        $pdo->commit();
        return ['success' => true, 'message' => 'Article mis a jour avec succes'];
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Erreur updateArticle: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur lors de la mise a jour'];
    }
}

function deleteArticle(int $id): array {
    $pdo = connectDB();
    if (!$pdo) return ['success' => false, 'message' => 'Erreur de connexion'];

    try {
        $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return ['success' => true, 'message' => 'Article supprime avec succes'];
    } catch (PDOException $e) {
        error_log("Erreur deleteArticle: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur lors de la suppression'];
    }
}

function deleteArticleImage(int $articleId, int $imageId): array {
    $pdo = connectDB();
    if (!$pdo) return ['success' => false, 'message' => 'Erreur de connexion'];

    try {
        $stmt = $pdo->prepare("DELETE FROM articles_images WHERE article_id = :article_id AND image_id = :image_id");
        $stmt->execute(['article_id' => $articleId, 'image_id' => $imageId]);
        return ['success' => true, 'message' => 'Image supprimee'];
    } catch (PDOException $e) {
        error_log("Erreur deleteArticleImage: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur'];
    }
}

function uploadImage(array $file): ?int {
    $pdo = connectDB();
    if (!$pdo) return null;

    $uploadDir = __DIR__ . '/../../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        try {
            $sql = "INSERT INTO images (nom_fichier, chemin) VALUES (:nom, :chemin) RETURNING id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nom' => $file['name'],
                'chemin' => 'uploads/' . $filename
            ]);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur uploadImage: " . $e->getMessage());
            return null;
        }
    }
    return null;
}

function toggleArticleStatus(int $id): array {
    $pdo = connectDB();
    if (!$pdo) return ['success' => false, 'message' => 'Erreur de connexion'];

    try {
        $stmt = $pdo->prepare("UPDATE articles SET status = CASE WHEN status = 1 THEN 0 ELSE 1 END,
                               date_publication = CASE WHEN status = 0 THEN NOW() ELSE date_publication END
                               WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return ['success' => true, 'message' => 'Statut modifie'];
    } catch (PDOException $e) {
        error_log("Erreur toggleStatus: " . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur'];
    }
}
