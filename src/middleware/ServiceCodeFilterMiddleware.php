<?php
class ServiceCodeFilterMiddleware {
    public function handle(Request $request): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $companyCode = $_SESSION['company_code'] ?? null;
        $serviceCode = $request->input('service_code');

        // service_codeの許可リストをcompay_code別に配列に記載。
        // ここでは静的に記載しているが、DBから生成する方がベター
        $allowed = [
            10 => ['A10', 'A20'],
            20 => ['A20', 'B10'],
            99 => '*', // 全て許可
        ];

        if ($companyCode === null || $serviceCode === null) {
            $_SESSION['error_message'] = 'サービスコードが指定されていません。';
            return;
        }

        if ($allowed[$companyCode] === '*') {
            return; // 制限なし
        }

        if (!in_array($serviceCode, $allowed[$companyCode] ?? [], true)) {
            $_SESSION['error_message'] = "許可されていないサービスコード: {$serviceCode}";
        } else {
            unset($_SESSION['error_message']);
        }
    }
}
