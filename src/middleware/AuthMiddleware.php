<?php
function AuthMiddleware() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['role'])) {
        header('Location: /login.php');
        exit;
    }
}
