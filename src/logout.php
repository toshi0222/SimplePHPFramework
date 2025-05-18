<?php
// セッションを開始（既に開始されている場合もあるので安全に）
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// セッション変数をすべて削除
$_SESSION = [];

// セッションクッキーを削除（クッキーが使われていれば）
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// セッション自体を破棄
session_destroy();

// ログインページにリダイレクト
header('Location: /login.php');
exit;
