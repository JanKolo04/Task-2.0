<?php

    namespace Plan;

    use Themplates\AllOrChoosed;

    class Plan {
        public static function useRightMethod() {
            // check which class have to run
            if($_SERVER['REQUEST_METHOD'] == "GET") {
                // crate obj of class from ../Themplates/AllOrChoosed.php
                // AllOrChoosed('table', 'id_name')
                // table - table from which will be geting data
                // id_name - column name with id in 'table'
                $plans = new AllOrChoosed("plans", "plan_id");
                $plans->chooseCorrectMethod();
            }
            /*
            else if($_SERVER['REQUEST_METHOD'] == "POST") {
                // create obj off class from AddUser.php
                $addUser = new Option\AddUser();
                $addUser->add();
            }
            */
        }
    }

    // run static method
    Plan::useRightMethod();


?>