<?php
    session_start();
    if(isset($_POST["recovery_email"]) && $_POST["action"] == "receive") {
        require_once 'config.php';
        require_once 'email_manager.php';
        $_SESSION['email'] = $_POST["recovery_email"];
        //generate otp and send email
        $otp = random_int(100000, 999999);
        send_email($_POST["recovery_email"], 'Your OTP is', $otp);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + 180;
        echo "
        <script>
            alert('please check your email');
        </script>
        ";
    }
    if($_POST["action"] == "check" && isset($_POST['otp'])) {
        $userOtp = $_POST['otp'];
    
        // Check if OTP session data exists and is valid
        if (isset($_SESSION['otp'], $_SESSION['otp_expiry']) && time() < $_SESSION['otp_expiry']) {
            if ($userOtp == $_SESSION['otp']) {
                unset($_SESSION['otp'], $_SESSION['otp_expiry']);
                header("Location: new_password.php");
                exit;
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .otp-button {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #1a75ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .otp-text {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 200px;
            text-align: center;
            font-size: 30px;
        }
    </style>    
</head>
<body>
    <div class="wrapper" style="text-align: center; margin-bottom: 0;">
        <div class="title-text" style="margin-bottom: 20px;">
            <div class="title login">Enter the OTP that you have received</div>
        </div>
        <form id="otpForm" method="POST" action="" style="display: inline-block; text-align: center; margin-bottom: 0;">
            <input type="hidden" name="action" value="check">
            <input type="text" name="otp" placeholder="Enter OTP" class="otp-text" required>
            <br>
            <button type="submit" class="otp-button">Verify</button>
        </form>
    </div>
</body>
</html>