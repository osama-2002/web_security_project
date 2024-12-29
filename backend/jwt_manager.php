<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use Firebase\JWT\JWT;

    function generate_cookie($id) {
        $secretKey = 'MyAbsolutelySecretKey';
        $payload = ['user_id' => $id, 'exp' => time() + 3600];
        $jwt = JWT::encode($payload, $secretKey, 'HS256');
        error_log("Generated JWT: $jwt");
        if (headers_sent()) {
            throw new Exception("Headers already sent. Cannot set cookie.");
        }
        setcookie('auth_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => 'sites.local',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        setcookie('auth_token', $jwt, [
            'expires' => time() + 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        error_log("Cookie set: " . ($_COOKIE['auth_token'] ?? 'Not Set'));
    }
?>