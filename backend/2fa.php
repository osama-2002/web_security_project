<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Welcome</title>
    <script>
        function handleOtpSubmission() {
            const form = document.getElementById('otpForm');
            const formData = new FormData(form);

            fetch('verify_otp.php', {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "../welcome.php";
                    }
                    alert(data.message);
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });

            return false;
        }
    </script>
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
        <form id="otpForm" method="POST" onsubmit="return handleOtpSubmission();" style="display: inline-block; text-align: center; margin-bottom: 0;">
            <input type="text" name="otp" placeholder="Enter OTP" class="otp-text" required>
            <br>
            <button type="submit" class="otp-button">Verify</button>
        </form>
    </div>
</body>

</html>