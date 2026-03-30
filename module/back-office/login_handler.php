<?php
require_once __DIR__ . '/../database.php';

function authenticateUser(string $username, string $password): ?array {
    $pdo = connectDB();

    if (!$pdo) {
        return null;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, username, passwords FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && $password === $user['passwords']) {
            return [
                'id' => $user['id'],
                'username' => $user['username']
            ];
        }

        return null;
    } catch (PDOException $e) {
        error_log("Erreur authentification: " . $e->getMessage());
        return null;
    }
}

function processLogin(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: login.php');
        exit;
    }

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: login.php?error=empty');
        exit;
    }

    $user = authenticateUser($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;

        header('Location: home');
        exit;
    } else {
        header('Location: login-error-invalid');
        exit;
    }
}
        
