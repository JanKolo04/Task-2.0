<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/add_new_plan.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <title>Week planer - Add new plan</title>
</head>
<body>

    <?php

        session_start();

        include("header.php");
        include("connection.php");
        include("check_login.php");

        class ValidDataPlan {
            protected function validData() {
                global $con;

                // add value into $entered_users property
                // I add value into property here because I create this cookie in JS
                $this->entered_users = explode(',', $_COOKIE['emails']);

                // check if name of plan is not used
                $sql = "SELECT plan_id FROM plans WHERE name='{$_POST['planName']}'";
                $query = $con->query($sql);
                
                // if query return id reutn true
                if($query->num_rows != 0) {
                    echo "<script>alert('This plan name is taken')</script>";
                    return True;
                }
                else {
                    // if in entered users is your email return True
                    // replace tmp email with email from $_SESSION['email']
                    if(in_array('$this->user_email', $this->entered_users)) {
                        echo "<script>alert('You canot add yourself into plan, because you will be add automatically')</script>";
                        return True;
                    }
                    return False;
                }
            }

            protected function checkUsers() {
                global $con;
                // check whether isset some users in array
                if(!empty($this->entered_users[0])) {
                    // check whether email which was entered isset in db
                    for($i=0; $i<sizeof($this->entered_users); $i++) {
                        $sql = "SELECT user_id FROM users WHERE email='{$this->entered_users[$i]}'";
                        $query = $con->query($sql);
                        
                        if($query->num_rows == 0) {
                            echo "<script>alert('User with this email ({$this->entered_users[$i]}) doesnt exist');</script>";
                            return True;
                        }
                    }
                }
                return False;
            }
        }

        class Plan extends ValidDataPlan {
            protected $entered_users;
            private $user_id;
            private $user_email;

            public function __construct() {
                $this->user_id = $_SESSION['user_id'];
                $this->user_email = $_SESSION['email'];
            }

            private function addNewUsers($plan_id) {
                global $con;

                // add you into plan
                // chnage tmp email to email from $_SESSION['email']
                $sql_insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) 
                VALUES($plan_id, (SELECT user_id FROM users WHERE email='{$this->user_email}'))";

                $query_insert_new_user = $con->query($sql_insert_new_user);

                // if first index of array have value null don't add other users
                if(!empty($this->entered_users[0])) {
                    for($i=0; $i<sizeof($this->entered_users); $i++) {
                        // add new user
                        // in this query I add function to find user id by his email
                        $sql_insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) 
                        VALUES($plan_id, (SELECT user_id FROM users WHERE email='{$this->entered_users[$i]}'))";

                        $query_insert_new_user = $con->query($sql_insert_new_user);
                    }
                }
            }

            // if valid funciton return some error complete form with entered data
            private function printValuesFromForm() {
                // print all box with added users
                for($i=0; $i<sizeof($this->entered_users); $i++) {
                    echo "
                        <div class='user'>
                            <div class='userEmail'>
                                <span class='email' name='newUser'>{$this->entered_users[$i]}</span>
                            </div>
                            <a class='deleteButton'>X</a>
                        </div>";
                }
            }

            public function addNewPlan() {
                global $con;
                
                // if function validData() return False add new plan
                if($this->validData() == False && $this->checkUsers() == False) {
                    // add new plan
                    $sql = "INSERT INTO plans(name, bg_photo) VALUES('{$_POST['planName']}', '{$_POST['planColor']}');";
                    $query = $con->query($sql);
                    // find id this plan
                    $sql = "SELECT plan_id FROM plans WHERE name='{$_POST['planName']}'";
                    $query = $con->query($sql);

                    // add plan_id into variable
                    $plan_id = $query->fetch_assoc()['plan_id'];
                    // add people into plan
                    $this->addNewUsers($plan_id);

                    //reset cookie
                    setcookie('emails', null, -1, '/');

                    // move into plan page
                    header("Location: plan.php?id={$plan_id}");
                }
                else {
                    $this->printValuesFromForm();
                }
            }
        }

        $plan = new Plan();
    ?>

<div class="form">
    <form method="POST">
        <label for="planName">Nazwa planu:</label>
        <input type="text" id="planName" name="planName" value=<?php echo isset($_POST['planName']) ? $_POST['planName']: ""; ?>>

        <label for="planColorInput">Kolor:</label>
        <input type="color" id="planColorInput" name="planColor" value=<?php echo isset($_POST['planColor']) ? $_POST['planColor']: "#ffffff"; ?>>

        <label for="planUserInput">Użytkownik:</label>
        <input type="email" id="planUserEmail" name="planUserInput">
        <span id="usersCount">Ilość uytkowników: <span id="usersCountValue">0</span>/2</span>
    
        <div class="usersSection flexRow">
            <div class="allAddedUsers flexRow">
                <?php
                    if(isset($_POST['addPlanBtn'])) {
                        $plan->addNewPlan();
                    }
                ?>
            </div>
            <a class="addButton" onclick="AddNewUserBox();">Add user</a>
        </div>

        <button class="addButton" type="submit" id="addPlanBtn" name="addPlanBtn" onclick="PassEmailToCookies();">Dodaj</button>
    </form>
</div>


<script src="js/add_plan.js"></script>
</body>
</html>