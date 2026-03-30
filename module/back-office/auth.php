<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: /TP_information_geurre/admins');
        exit;
    }
}

function getSessionUser(): ?array {
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username']
    ];
}

function logout(): void {
    session_destroy();
    header('Location: /TP_information_geurre/admins');
    exit;
}
