<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // 簡易ユーザーDB（company_code は固定）
    $users = [
        'admin' => [
            'password' => 'pass',
            'role' => 'admin',
            'company_code' => 99,
        ],
        'user1' => [
            'password' => 'pass',
            'role' => 'user',
            'company_code' => 10,
        ],
        'user2' => [
            'password' => 'pass',
            'role' => 'user',
            'company_code' => 20,
        ],
    ];

    // 認証チェック
    if (isset($users[$user]) && $users[$user]['password'] === $pass) {
        $_SESSION['role'] = $users[$user]['role'];
        $_SESSION['company_code'] = $users[$user]['company_code'];

        header('Location: /pages/dashboard.php'); // service_code はURLクエリで渡す必要あり
        exit;
    } else {
        $errorMessage = 'ユーザー名またはパスワードが間違っています。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン画面</h1>

    <?php if (!empty($errorMessage)): ?>
        <p style="color:red;"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">ログイン</button>
    </form>
</body>
</html>
