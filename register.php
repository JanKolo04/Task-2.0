<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/register.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <title>Week planer - Register</title>
</head>
<body>

    <?php

        session_start();

        include("header.php");
        include("connection.php");

        $register = new Register();
        if(isset($_POST['create'])) {
            echo $register->add_user();
        }

        class Register {
            function get_random_color() {
                // array with chars of hex 
                $hex_array = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F'];
                // color
                $color = "";
                for($i=0; $i<6; $i++) {
                    // get random number from 0 to 14
                    $random = rand(0,14);
                    $color .= $hex_array[$random];
                }

                return $color;
            }

            function valid_email() {
                global $con;
                // check that user exist in db
                $sql = "SELECT * FROM users WHERE email='{$_POST['email']}'";
                $query = $con->query($sql);

                // if email will be find return False
                if($query->num_rows > 0) {
                    return False;
                }
                else {
                    return True;
                }
            }

            function add_user() {
                global $con;

                if($this->valid_email() == False) {
                    return "<p>User exist with this email</p>";
                }
                // current date
                $current_date = date("Y-m-d");
                // hash passwords
                $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                // background color
                $color = $this->get_random_color();

                $sql = "INSERT INTO users(name, surname, email, password, join_date, avatar) VALUES('{$_POST['name']}', '{$_POST['surname']}', '{$_POST['email']}', '$hash_password', '$current_date', '$color')";
                $query = $con->query($sql);

                if(!$query) {
                    return "<p>Error</p>";
                }
            }
        }
    
    ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Name...">
        <input tyle="text" name="surname" placeholder="Surname...">
        <input type="email" name="email" placeholder="Email...">
        <input type="password" name="password" placeholder="Password...">

        <button type="submit" name="create">Create</button>
    </form>

</body>
</html>