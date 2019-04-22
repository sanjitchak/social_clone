<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Social Network Register/Logn</title>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script src="assets/js/register.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
</head>

<body>
    <?php
    if (isset($_POST['register_button'])) {
        echo '<script>
$(document).ready(function() {
$("#first").hide();
$("#second").show();
});
    
</script>

    ';
    }
    ?>
    <div class="wrapper">
        <div class="login_box">
            <div class="login_header">
                <h1> Swirlfeed </h1>
                Login or Sign up Below
            </div>
            <div id="first">
                <form action="register.php" method="POST">
                    <input type="email" name="log_email" placeholder="Enter Email" required>
                    <br>
                    <input type="password" name="log_password" placeholder="Enter Password" required>
                    <br>
                    <input type="submit" name="login_button" value="Login">
                    <br>
                    <?php
                    if (in_array("Email or password wrong<br>", $error_array)) {
                        echo "Email or password wrong<br>";
                    }
                    ?>
                    <a href="#" id="signup" class="signup"> Need a account? SignUp here? </a>
                </form>
            </div>
            <div id="second">
                <form action="register.php" method="POST">
                    <input type="text" name="reg_fname" placeholder="First Name" value="<?php if (isset($_SESSION['reg_fname'])) {
                                                                                            echo $_SESSION['reg_fname'];
                                                                                        } ?>" required>
                    <br>
                    <?php
                    if (in_array("Your first name should be between 2 and 25 <br>", $error_array)) {
                        echo "Your first name should be between 2 and 25 <br>";
                    }
                    ?>
                    <input type="text" name="reg_lname" placeholder="Last Name" value="<?php if (isset($_SESSION['reg_lname'])) {
                                                                                            echo $_SESSION['reg_lname'];
                                                                                        } ?>" required>
                    <br>
                    <?php
                    if (in_array("Your last name should be between 2 and 25 <br>", $error_array)) {
                        echo "Your last name should be between 2 and 25 <br>";
                    }
                    ?>
                    <input type="email" name="reg_email" placeholder="Email" value="<?php if (isset($_SESSION['reg_email'])) {
                                                                                        echo $_SESSION['reg_email'];
                                                                                    } ?>" required>
                    <br>
                    <?php
                    if (in_array("Email is used   <br>", $error_array)) {
                        echo "Email is used   <br>";
                    }
                    if (in_array("Invalid Email  <br>", $error_array)) {
                        echo "Invalid Email  <br>";
                    }
                    ?>
                    <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if (isset($_SESSION['reg_email2'])) {
                                                                                                    echo $_SESSION['reg_email2'];
                                                                                                } ?>" required>
                    <br>
                    <?php
                    if (in_array("Email not match <br>", $error_array)) {
                        echo "Email not match <br>";
                    }
                    ?>

                    <input type="password" name="reg_password" placeholder="Password" required>
                    <br>
                    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
                    <br>
                    <?php
                    if (in_array("Type only letters or numbers in password<br>", $error_array)) {
                        echo "Type only letters or numbers in password<br>";
                    }
                    if (in_array("Password not matching <br>", $error_array)) {
                        echo "Password not matching <br>";
                    }
                    if (in_array("type password between 25 and 5 words <br>", $error_array)) {
                        echo "type password between 25 and 5 words <br>";
                    }
                    ?>
                    <input type="submit" name="register_button" value="Register">
                    <br>
                    <?php
                    if (in_array("<span style= 'color:#14C000;'>   You are done</span>", $error_array)) {
                        echo "<span style= 'color:#14C000;'>   You are done</span>";
                    }
                    ?>
                    <a href="#" id="signin" class="signin"> Already have a account? SignIn here </a>

                </form>
            </div>
        </div>
    </div>
</body>

</html>