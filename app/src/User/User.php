<?php

    // set namespace
    namespace User;

    use Themplates\AllOrChoosed;

    class User {
        public static function useRightMethod() {
            // check which class have to run
            if($_SERVER['REQUEST_METHOD'] == "GET") {
                // crate obj of class from ../Themplates/AllOrChoosed.php
                // AllOrChoosed('table', 'id_name')
                // table - table from which will be geting data
                // id_name - column name with id in 'table'
                $users = new AllOrChoosed("users", "user_id");
                $users->chooseCorrectMethod();
            }
            else if($_SERVER['REQUEST_METHOD'] == "POST") {
                // create obj off class from Option/AddUser.php
                $addUser = new Option\AddUser();
                $addUser->add();
            }
        }
    }

    // run static method
    User::useRightMethod();

?>