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

        $plan = new Plan();
        if(isset($_POST['addPlanBtn'])) {
            $plan->addNewPlan();
        }

        class Plan {
            private function validData() {
                global $con;

                // check if name of plan is not used
                $sql = "SELECT plan_id FROM plans WHERE name='{$_POST['planName']}'";
                $query = $con->query($sql);
                
                // if query return id reutn true
                if($query->num_rows != 0) {
                    return True;
                }
                else {
                    return False;
                }
            }

            private function addNewUsers($plan_id) {
                global $con;

                // cookie with all user email
                $emails = $_COOKIE['emails'];
                $emails = explode(",", $emails);
                for($i=0; $i<sizeof($emails); $i++) {
                    // add new user
                    // in this query I add function to find user id by his email
                    $sql_insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) 
                    VALUES($plan_id, (SELECT user_id FROM users WHERE email='{$emails[$i]}'))";
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
                    
                }
            }
        }
    ?>

<div class="form">
    <form method="POST">
        <label for="planName">Nazwa planu:</label>
        <input type="text" id="planName" name="planName">

        <label for="planColorInput">Kolor:</label>
        <input type="color" id="planColorInput" name="planColor" value="#ffffff">

        <label for="planUserInput">Użytkownik:</label>
        <input type="email" id="planUserEmail" name="planUserInput">
        <span id="usersCount">Ilość uytkowników: <span id="usersCountValue">0</span>/3</span>
    
        <div class="usersSection flexRow">
            <div class="allAddedUsers flexRow"></div>
            <a class="addButton" onclick="AddNewUser();">Add user</a>
        </div>

        <button class="addButton" type="submit" id="addPlanBtn" name="addPlanBtn" onclick="PassEmailToCookies();">Dodaj</button>
    </form>
</div>


<script src="js/add_plan.js"></script>
</body>
</html>