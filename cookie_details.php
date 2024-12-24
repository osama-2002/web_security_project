<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Welcome</title>
    <style>
        .cookie-wrapper {
            overflow: hidden;
            max-width: 100%;
            padding: 30px;
            border-radius: 15px;
            max-width: 750px;
            text-align: center
        }
    </style>
</head>

<body>
<?php
    require_once 'vendor/autoload.php'; 
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    if (isset($_COOKIE['auth_token'])) {
        echo "<div class='cookie-wrapper'><h1>Cookie Details:<h1><br><br>";
        try {
            $decoded = JWT::decode($_COOKIE['auth_token'], new Key('MyAbsolutelySecretKey', 'HS256'));
            echo "<h2>Authenticated as user ID: " . $decoded->user_id."</h2></div>";
        } catch (Exception $e) {
            echo "Invalid or expired token.";
        }
    } else {
        echo "No cookie found.";
    }
?>
</body>

</html>
