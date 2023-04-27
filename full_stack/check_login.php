<?php

    class CheckLogin {
        public static function checkLoginStatus() {
            if(!isset($_SESSION['email'])) {
                header("Location: login.php");
            }
        }
    }

    CheckLogin::checkLoginStatus();

?>