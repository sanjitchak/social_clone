 <?php
    if (isset($_POST['login_button'])) {
            $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
            $_SESSION['log_email'] = $email;
            $password = md5($_POST['log_password']);
            $check_database_query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password' ");
            $check_login_query = mysqli_num_rows($check_database_query);
            if ($check_login_query == 1) {
                    $row = mysqli_fetch_array($check_database_query);
                    $username = $row['username'];
                    $user_closed_query = mysqli_query($conn, "SELECT * from users WHERE email =  '$email' AND user_closed = 'yes' ");
                    if (mysqli_num_rows($user_closed_query) == 1) {
                            $user_open_update = mysqli_query($conn, "UPDATE  users SET user_closed = 'no' WHERE email =  '$email' ");
                        }

                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                } else {
                array_push($error_array, "Email or password wrong<br>");
            }
        }
    ?>