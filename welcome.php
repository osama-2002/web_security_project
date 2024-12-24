<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Welcome</title>
    <style>
        .welcome-button {
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
            text-align: center
        }
    </style>
</head>

<body>
    <div class="welcome-wrapper">
        <h1 style="font-family: bradley hand, cursive; font-size: 55px; font-style: oblique;">Welcome the most secure website in the world!</h1>
        <br>
        <form action="cookie_details.php" method="get">
            <button type="submit" class="welcome-button">See JWT Cookie Details</button>
        </form>
        <br>
        <form action="backend/logout.php" method="get">
            <button type="submit" class="welcome-button">Logout</button>
        </form>
    </div>
</body>

</html>