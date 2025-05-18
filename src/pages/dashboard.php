<?php
// セッションスタート（index.php 経由なら不要）
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ロール確認（index.php 側ミドルウェアで済んでいればここでは不要）
$role = htmlspecialchars($_SESSION['role'] ?? 'unknown', ENT_QUOTES, 'UTF-8');

// service_code 表示用（渡されたもの）
$serviceCode = $_POST['service_code'] ?? $_GET['service_code'] ?? '(なし)';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ダッシュボード</title>
</head>
<body>
    <h1>ダッシュボード</h1>

    <p>ようこそ。あなたのロールは「<?= $role ?>」です。</p>
    <p>指定されたサービスコード：<strong><?= htmlspecialchars($serviceCode) ?></strong></p>

    <?php if (!empty($_SESSION['error_message'])): ?>
        <p style="color:red;">⚠ <?= htmlspecialchars($_SESSION['error_message']) ?></p>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <p><a href="/logout.php">ログアウト</a></p>
</body>
</html>
