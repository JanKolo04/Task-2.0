<?php

    // set namespace
    namespace Users;

    class User {
        public static function useRightMethod() {
            // check which class have to run
            if($_SERVER['REQUEST_METHOD'] == "GET") {
                // crate obj of class from AllUsers.php
                $users = new AllUsers();
                $users->chooseCorrectMethod();
            }
            else if($_SERVER['REQUEST_METHOD'] == "POST") {
                // create obj off class from AddUser.php
                $addUser = new AddUser();
                $addUser->add();
            }
        }
    }

    // run static method
    User::useRightMethod();

?>