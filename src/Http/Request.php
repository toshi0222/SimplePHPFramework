<?php
class Request {
    public function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function all(): array {
        return array_merge($_GET, $_POST);
    }

    public function method(): string {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function uri(): string {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }
}
