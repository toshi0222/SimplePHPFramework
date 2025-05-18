<?php

return [
    // ログインページ（未認証ユーザーもアクセス可能）
    'login.php' => [
        'file' => 'login.php',
        'middleware' => [],
    ],

    // ログアウトページ（ログインしている必要あり）
    'logout.php' => [
        'file' => 'logout.php',
        'middleware' => [
            'AuthMiddleware'    // ログイン必須
        ],
    ],

    // ダッシュボード（認証 + ロール + サービスコードチェック）
    'pages/dashboard.php' => [
        'file' => 'pages/dashboard.php',
        'middleware' => [
            'AuthMiddleware',   // ログイン必須
            'RoleMiddleware:admin,user',    // 権限（role）チェック
            'ServiceCodeFilterMiddleware',  // ServiceCodeチェック
        ],
    ],

    // エラーページ（誰でもアクセス可能）
    'error.php' => [
        'file' => 'error.php',
        'middleware' => [],
    ],

    // 必要に応じて他のページもここへ追加
    // 'settings.php' => [
    //     'file' => 'pages/settings.php',
    //     'middleware' => [
    //         'AuthMiddleware',
    //         'RoleMiddleware:admin'
    //         'ServiceCodeFilterMiddleware',
    //     ],
    // ],
];
