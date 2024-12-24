<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Welcome</title>
    <style>
        .next-button {
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

        .welcome-wrapper {
            overflow: hidden;
            max-width: 100%;
            padding: 30px;
            border-radius: 15px;
            max-width: 750px;
            text-align: center;
            background: #fff;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="welcome-wrapper">
        <h1 style="font-family: bradley hand, cursive; font-size: 55px; font-style: oblique;">Enter your email address</h1>
        <br>
        <form action="password_reset.php" method="POST">
            <input type="hidden" name="action" value="receive">
            <input type="text" name="recovery_email" placeholder="Recovery Email" style="font-size: 40px; text-align: center" required> 
            <br><br>
            <button type="submit" class="next-button">Next</button>
        </form>
    </div>
</body>

</html>