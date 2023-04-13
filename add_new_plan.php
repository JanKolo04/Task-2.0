<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/add_new_plan.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Week planer - Add new plan</title>
</head>
<body>

    <?php

        include("header.php");
        include("connection.php");
        
        // create object from Plan class
        $plan = new Plan();

        class Plan {
            private $entered_users;

            public function __construct() {
                $this->entered_users = explode(',', $_COOKIE['emails']);
            }

            private function validData() {
                global $con;
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
                    if(in_array('jankolodziej99@gmail.com', $this->entered_users)) {
                        echo "<script>alert('You canot add yourself into plan, because you will be add automatically')</script>";
                        return True;
                    }
                    return False;
                }
            }

            private function addNewUsers($plan_id) {
                global $con;

                // add you into plan
                // chnage tmp email to email from$_SESSION['email']
                $sql_insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) 
                VALUES($plan_id, (SELECT user_id FROM users WHERE email='jankolodziej99@gmail.com'))";
                $query_insert_new_user = $con->query($sql_insert_new_user);

                for($i=0; $i<sizeof($this->entered_users); $i++) {
                    // add new user
                    // in this query I add function to find user id by his email
                    $sql_insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) 
                    VALUES($plan_id, (SELECT user_id FROM users WHERE email='{$this->entered_users[$i]}'))";
                    $query_insert_new_user = $con->query($sql_insert_new_user);

                }
            }

            public function addNewPlan() {
                global $con;
                
                // if function validData() return False add new plan
                if($this->validData() == False) {
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
                    // move into plan page
                    header("Location: plan.php?id={$plan_id}");
                }
                else {
                    $this->printValuesFromForm();
                }
            }

            // if valid funciton return some error complete form with entered data
            public function printValuesFromForm() {
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
        }
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