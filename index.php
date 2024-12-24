<?php
    session_start();
    if(!isset($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    }
?>

<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Web Security</title>
    <script>
        function handleFormSubmission(formId, url) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);

            fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if(formId === "signupForm") {
                        alert(data.message);
                    }
                    window.location.href = "backend/2fa.php";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            });

            return false;
        }
    </script>
</head>

<body>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const loginText = document.querySelector(".title-text .login");
            const loginForm = document.querySelector("form.login");
            const loginRadio = document.querySelector("#login");
            const signupRadio = document.querySelector("#signup");
            const signupLink = document.querySelector("form .signup-link a");

            signupRadio.addEventListener("click", () => {
                loginForm.style.marginLeft = "-50%";
                loginText.style.marginLeft = "-50%";
            });

            loginRadio.addEventListener("click", () => {
                loginForm.style.marginLeft = "0%";
                loginText.style.marginLeft = "0%";
            });

            signupLink.addEventListener("click", (e) => {
                signupRadio.checked = true;
                signupRadio.dispatchEvent(new Event("click"));
                e.preventDefault();
            });
        });
    </script>
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
        </div>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form id="signupForm" onsubmit="return handleFormSubmission('signupForm', 'backend/login.php');" class="login" method="POST">
                    <!-- login form -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                    <div class="field">
                        <input type="text" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="pass-link"><a href="backend/forgot_password.php">Forgot password?</a></div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Login">
                    </div>
                    <div class="signup-link">Not a member? <a href="">Signup now</a></div>
                </form>
                <form id="loginForm" onsubmit="return handleFormSubmission('loginForm', 'backend/sign_up.php');" class="signup" method="POST">
                    <!-- sign up form -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                    <div class="field">
                        <input type="text" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Confirm password" name="confirm_password" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Signup">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>