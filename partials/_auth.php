<?php
    session_start();
    $error = "";
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        include 'partials/_dbconnect.php';
        if(isset($_POST['name'])) {
            $username = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            if($password != $cpassword) {
                header("location: index.php?error=Password doesn\'t match");
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert_sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES ('$username', '$email', '$hash')";
                $result = mysqli_query($connection, $insert_sql);
                if($result) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['userId'] = mysqli_insert_id($connection);
                    $_SESSION['userName'] = $username;
                    header("location: index.php");
                } else {
                    header("location: index.php?error=Email or username already in use");
                }
            }
        } else if(isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            header("location: index.php");
        } else {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $select_sql = "SELECT * FROM `users` WHERE `user_email`='$email'";
            $result = mysqli_query($connection, $select_sql);
            $rows = mysqli_num_rows($result);
            if($rows == 1) {
                $row = mysqli_fetch_assoc($result);
                if(password_verify($password ,$row['user_password'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['userId'] = $row['user_id'];
                    $_SESSION['userName'] = $row['user_name'];
                    header("location: index.php");
                } else {
                    header("location: index.php?error=Invalid credentials");
                }
            } else {
                header("location: index.php?error=Invalid credentials");
            }
        }
    }
?>