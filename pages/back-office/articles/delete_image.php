<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Non autorise']);
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';

$articleId = isset($_GET['article_id']) ? (int)$_GET['article_id'] : 0;
$imageId = isset($_GET['image_id']) ? (int)$_GET['image_id'] : 0;

if ($articleId > 0 && $imageId > 0) {
    $result = deleteArticleImage($articleId, $imageId);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Parametres invalides']);
}
