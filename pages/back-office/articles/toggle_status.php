<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Non autorise']);
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $result = toggleArticleStatus($id);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'ID invalide']);
}
