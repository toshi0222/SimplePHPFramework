<?php

class RoleMiddleware {
    /**
     * @param Request $request リクエストインスタンス（$_GET/$_POST統合ラッパー）
     * @param string $allowedRolesStr 許可されたロールをカンマ区切りで指定（例: "admin,user"）
     */
    public function handle(Request $request, string $allowedRolesStr): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $currentRole = $_SESSION['role'] ?? null;
        $allowedRoles = explode(',', $allowedRolesStr);

        if (!in_array($currentRole, $allowedRoles, true)) {
            header('Location: /error.php');
            exit;
        }
    }
}
