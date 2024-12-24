<?php
    session_start();
    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //check CSRF token
        if(!isset($_POST["csrf_token"]) || $_POST["csrf_token"] != $_SESSION["csrf_token"]) {
            echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
            exit;
        }
        
        if (isset($_POST['email']) && isset($_POST['password'])) {

            require_once 'config.php';
            require_once 'email_manager.php';

            // XSS prevention
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'];

            // SQL Injection prevention
            $stmt = $mysqli->prepare("SELECT id, password_hash FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $storedPasswordHash = $user["password_hash"];

                if (password_verify($password, $storedPasswordHash)) {
                    try {
                        // 2fa: generate OTP and send it via email
                        $_SESSION['user_id'] = $user['id'];
                        $otp = random_int(100000, 999999);
                        send_email($email, 'Your OTP is', $otp);
                        $_SESSION['otp'] = $otp;
                        $_SESSION['otp_expiry'] = time() + 180; // 3 minutes
                        echo json_encode(["success" => true, "message" => "Please check your email"]);
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                } else {
                    echo json_encode(["success" => false, "message" => "Invalid email or password."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Invalid email or password."]);
            }

            $stmt->close();
            $mysqli->close();

            exit;
        }
    }
?>
