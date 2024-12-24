<?php
session_start();
header("Content-Type: application/json");

try {

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $userOtp = $_POST['otp'];
    
        // Check if OTP session data exists and is valid
        if (isset($_SESSION['otp'], $_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
            if ($userOtp == $_SESSION['otp']) {
                unset($_SESSION['otp'], $_SESSION['otp_expiry']);
    
                // Generate JWT
                require_once 'jwt_manager.php';
                generate_cookie($_SESSION['user_id']);
    
                echo json_encode(["success" => true, "message" => "Authentication successful!"]);
                exit;
            } else {
                echo json_encode(["success" => false, "message" => "Invalid OTP."]);
                exit;
            }
        } else {
            echo json_encode(["success" => false, "message" => "OTP expired. Please log in again."]);
            exit;
        }
    }

} catch (Exception $e) {
    error_log("Error in verify_otp.php: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An error occurred. Please try again."]);
    exit;
}