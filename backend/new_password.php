<?php 
    session_start();
    if(isset($_POST["action"]) && $_POST["action"] == "update") {
        if($_POST['new_password'] != $_POST['confirm_new_password']) {
            echo "
            <script>
                alert('Passwords don't match');
            </script>
            ";
        }
        require_once 'config.php';
        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        $stmt->bind_param("ss", $password, $_SESSION["email"]);
        $stmt->execute();
    
        if($stmt->affected_rows > 0) {
            echo "
            <script>
                alert('Password Updated');
                window.location.href = '../index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Something went wrong');
            </script>
            ";
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
        .update-button {
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
        .update-text {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 350px;
            text-align: center;
            font-size: 28px;
        }
    </style>    
</head>
<body>
    <div class="wrapper" style="text-align: center; margin-bottom: 0; max-width: 700px">
        <div class="title-text" style="margin-bottom: 20px;">
            <div class="title login">Enter your new password</div>
        </div>
        <form id="otpForm" method="POST" action="" style="display: inline-block; text-align: center; margin-bottom: 0;">
            <input type="hidden" name="action" value="update">
            <input type="password" name="new_password" placeholder="New Password" class="update-text" required>
            <br>
            <input type="password" name="confirm_new_password" placeholder="Confirm New Password" class="update-text" required>
            <br>
            <button type="submit" class="update-button">Update</button>
        </form>
    </div>
</body>
</html>