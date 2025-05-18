<?php
function RoleMiddleware($allowedRolesStr) {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $allowedRoles = explode(',', $allowedRolesStr);
    $currentRole = $_SESSION['role'] ?? '';

    if (!in_array($currentRole, $allowedRoles, true)) {
        header('Location: /error.php');
        exit;
    }
}
