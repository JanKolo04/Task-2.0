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
                $correct_method = $plans->chooseCorrectMethod();
                echo $correct_method;
            }
            else if($_SERVER['REQUEST_METHOD'] == "POST") {
                // create obj off class from Option/AddPlan.php
                $addPlan = new Option\AddPlan();
                $add_plan = $addPlan->addPlan($_POST['plan_name'], $_POST['plan_users'], $_POST['plan_color']);
                echo $add_plan;
            }
        }
    }

    // run static method for run specyfic method from different class
    Plan::useRightMethod();


?>