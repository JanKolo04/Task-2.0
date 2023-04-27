<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/login.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <title>Week planer - Login</title>
</head>
<body>

    <?php

        session_start();

        include("header.php");
        include("connection.php");

        class Login {
            function check_user() {
                global $con;
                // find user by email
                $sql = "SELECT * FROM users WHERE email='{$_POST['email']}'";
                $query = $con->query($sql);
                // check results
                if($query->num_rows > 0) {
                    $row = $query->fetch_assoc();
                    // verify password
                    if(password_verify($_POST['password'], $row['password'])) {
                        // set session variable
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['email'] = $row['email'];
                        header("Location: index.php");
                    }
                }
                else {
                    echo "User with this email doesn't exist";
                }
            }
        }
    
    ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email...">
        <input type="password" name="password" placeholder="Password...">

        <button type="submit" name="login">Create</button>

        <?php
            $login = new Login();
            if(isset($_POST['login'])) {
                echo $login->check_user();
            }
        ?>
    </form>

</body>
</html>