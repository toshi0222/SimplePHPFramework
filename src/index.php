<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$routes = require 'routes.php';
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestFile = ltrim($requestPath, '/');

// 該当ルートがあるか確認
if (!isset($routes[$requestFile])) {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

$route = $routes[$requestFile];

// ミドルウェアの適用
foreach ($route['middleware'] as $middleware) {
    if (strpos($middleware, ':') !== false) {
        // 引数付き (例: RoleMiddleware:admin,user)
        [$name, $param] = explode(':', $middleware, 2);
        require_once "middleware/{$name}.php";
        call_user_func($name, $param);
    } else {
        // 引数なし
        require_once "middleware/{$middleware}.php";
        call_user_func($middleware);
    }
}

// 最終的に対象のファイルを読み込む
require $route['file'];
