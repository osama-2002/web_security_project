<?php
    session_start();
    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // check CSRF token
        if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] != $_SESSION["csrf_token"]) {
            echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
            exit;
        }

        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {

            require_once 'config.php';

            // XSS prevention
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["success" => false, "message" => "Invalid email format."]);
                exit;
            }

            //check password confirmation
            if($_POST['password'] != $_POST['confirm_password']) {
                echo json_encode(["success" => false, "message" => "Passwords don't match."]);
                exit;
            }

            // validate password strength
            if (!preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$/", $_POST['password'])) {
                echo json_encode(["success" => false, "message" => "Your password must contain at least 1 number, 1 capital letter, and be at least 6 characters long."]);
                exit;
            }

            // password hashing
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // check if the email already exists
            $stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?"); // SQL Injection Prevention
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo json_encode(["success" => false, "message" => "Email already registered."]);
                $stmt->close();
                exit;
            }
            $stmt->close();

            // insert the new user
            $stmt = $mysqli->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)"); // SQL Injection Prevention
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];
                $otp = random_int(100000, 999999);
                send_email($email, 'Your OTP is', $otp);
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_expiry'] = time() + 180; // 3 minutes
                echo json_encode(["success" => true, "message" => "Please check your email"]);
                echo json_encode(["success" => true, "message" => "Registration successful!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Registration failed."]);
            }

            $stmt->close();
            $mysqli->close();

            exit;
        }
    }
?>
