<?php

// セッション開始（初期化系はミドルウェア内部でも行うが、ここでも開始しておく）
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ルート定義を読み込む
$routes = require __DIR__ . '/routes.php';

// リクエストされたURLのパスを取得
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestFile = ltrim($requestPath, '/');  // 例: dashboard.php

// 対象のルートが定義されているかチェック
if (!isset($routes[$requestFile])) {
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

// 該当ルートの設定を取得
$route = $routes[$requestFile];

// Requestクラスを読み込み・インスタンス化
require_once __DIR__ . '/Http/Request.php';
$request = new Request();

// ミドルウェア実行
foreach ($route['middleware'] ?? [] as $middleware) {
    if (strpos($middleware, ':') !== false) {
        // 引数ありミドルウェア (例: RoleMiddleware:admin,user)
        [$name, $param] = explode(':', $middleware, 2);
        require_once __DIR__ . "/middleware/{$name}.php";

        if (class_exists($name)) {
            (new $name)->handle($request, $param);
        } elseif (function_exists($name)) {
            $name($param); // 旧方式対応（不要なら削除可）
        }
    } else {
        // 引数なしミドルウェア
        require_once __DIR__ . "/middleware/{$middleware}.php";

        if (class_exists($middleware)) {
            (new $middleware)->handle($request);
        } elseif (function_exists($middleware)) {
            $middleware(); // 旧方式対応（不要なら削除可）
        }
    }
}

// 対象のファイルを読み込む
require __DIR__ . '/' . $route['file'];
