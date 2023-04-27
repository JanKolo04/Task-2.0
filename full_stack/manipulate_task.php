<?php

    class Tasks_manipulation {
        static function complete_plan($task_id) {
            global $con;
            // complete plan
            $sql = "UPDATE tasks SET status=1 WHERE task_id=$task_id";
            $query = $con->query($sql);

            if(!$query) {
                return "Something wrong";
            }
        }

        static function uncomplete_plan($task_id) {
            global $con;
            // uncomplete plan
            $sql = "UPDATE tasks SET status=0 WHERE task_id=$task_id";
            $query = $con->query($sql);

            if(!$query) {
                return "Something wrong";
            }
        }

        static function delete_plan($task_id) {
            global $con;
            // delete plan
            $sql = "DELETE FROM tasks WHERE task_id=$task_id";
            $query = $con->query($sql);

            if(!$query) {
                return "Something wrong";
            }
        }

        static function add_task() {
            global $con;

            $plan_type = "basic";
            // validation
            if($_POST['plan_name'] == "") {
                echo "Plan name is empty";
                return;
            }
            else if(!isset($_POST['date'])) {
                echo "Plan date is empty";
                return;
            }
            else if(isset($_POST['type'])) {
                $plan_type = $_POST['type'];
            }

            // day name of selected date
            $day = date('l', strtotime($_POST['date']));
            // get date of selected day
            $date = date('Y-m-d', strtotime($_POST['date']));

            // add new plan
            $sql = "INSERT INTO tasks(plan_id, owner_id, name, description, day, date, type) VALUES({$_GET['id']}, {$_POST['owner_of_task']}, '{$_POST['plan_name']}', '{$_POST['plan_description']}', '$day', '$date', '$plan_type')";
            $query = $con->query($sql);

            if(!$query) {
                echo "Something wrong";
    
            }
        }
    }

?>