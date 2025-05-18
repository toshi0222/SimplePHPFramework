<?php
class AuthMiddleware {
    public function handle(Request $request): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role'])) {
            header('Location: /login.php');
            exit;
        }
    }
}
