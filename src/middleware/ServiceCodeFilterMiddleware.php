<?php
function ServiceCodeFilterMiddleware() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $companyCode = $_SESSION['company_code'] ?? null;
    $serviceCode = $_POST['service_code'] ?? $_GET['service_code'] ?? null;

    $allowedServiceCodes = [
        10 => ['A10', 'A20'],
        20 => ['A20', 'B10'],
        99 => '*',
    ];

    // company_code or service_code が未定義
    if ($companyCode === null || $serviceCode === null) {
        $_SESSION['error_message'] = 'service_codeが指定されていません。';
        return;
    }

    if ($allowedServiceCodes[$companyCode] === '*') {
        return; // 99 は無制限
    }

    if (!in_array($serviceCode, $allowedServiceCodes[$companyCode] ?? [], true)) {
        $_SESSION['error_message'] = "許可されていないサービスコード: {$serviceCode}";
        return;
    }

    // エラーメッセージを一度リセット（有効なアクセス時）
    unset($_SESSION['error_message']);
}
