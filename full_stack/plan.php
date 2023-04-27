<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/plan.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <script src="js/plan.js"></script>
    <title>Week planer - Calendar</title>
</head>
<body>


    <?php

        session_start();

        include("header.php");
        include("connection.php");
        include("check_login.php");
        include("manipulate_task.php");
        include("echo_plan_obj.php");

        class Plan extends PrintPlanObjects {
            private $plan_id;
            private $quantity_of_user;
            private $users_array = [];

            public function __construct() {
                $this->plan_id = $_GET['id'];
            }

            public function print_days_box() {
                $dt = new DateTime();
                // get name of current day
                $current_day_name = date('D');
                for ($d=1; $d<=7; $d++) {
                    $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                    // short version of day name
                    $day_short_ver = date('D', strtotime($dt->format('Y-m-d')));
                    
                    // set appropriate class for day box
                    $class_day = "other";
                    if($current_day_name == $day_short_ver) {
                        $class_day = "today";
                    }

                    // month short_ver
                    $month_short_ver = date('M', strtotime($dt->format('Y-m-d')));
                    // number of day in month
                    $day_number = date("d", strtotime($dt->format('Y-m-d')));
                    
                    // print first peice of section
                    echo "
                        <div class='day-container $class_day'>
                            <div class='day-name'>
                                <h3>$day_short_ver <span class='day-date'>$day_number $month_short_ver</span></h3>
                            </div>
                            <div class='plans-container'>
                    ";
                    // print all tasks which are of the day
                    $this->fetch_all_tasks(date('l', strtotime($dt->format('Y-m-d'))));
                    echo "
                            </div>
                        </div>
                    ";        
                    
                }
            }

            private function fetch_all_tasks($day) {
                global $con;
                // current week dates
                $monday = date('Y-m-d', strtotime('monday this week'));
                $sunday = date('Y-m-d', strtotime('sunday this week'));
    
                // get all plans from current week
                $sql = "SELECT tasks.*, users.name AS user_name, users.surname, users.user_id, users.avatar FROM tasks INNER JOIN users ON tasks.owner_id=users.user_id WHERE plan_id={$_GET['id']} AND day='$day' AND date BETWEEN '$monday' AND '$sunday'";
                $query = $con->query($sql);
    
                if($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        // check on which satatus is task
                        // task can be on two status 1 or 0
                        // 1 = is done, 0 = is not done
                        $status = "";
                        $complete_button = "complete";
                        if($row['status'] == 1) {
                            $status = "done";
                            $complete_button = "uncomplete";
                        }

                        // check wether user have avatar or only bg color
                        $avatar = "<p class='task_owner_img' style='background-color: #{$row['avatar']}'>".$row['user_name'][0].''.$row['surname'][0]."</p>";
                        $explode_avatar = explode(".", $avatar);
                        if(sizeof($explode_avatar) != 1) {
                            $avatar = "<img class='task_owner_img' src='./img/avatars/{$row['avatar']}'>";
                        }

                        // make shortcut of description if len of desc id loger than 30
                        // when your text is longer than 30 don't add class into button
                        // hidden_button_show_more - this class have display: none;
                        $desc = $row['description'];
                        $show_more_class = "hidden_button_show_more";
                        if(strlen($row['description']) > 30) {
                            $desc = substr($desc, 0, 30).'...';
                            $show_more_class = "";
                        }

                        // print tasks
                        $this->task($row, $status, $avatar, $desc, $show_more_class, $complete_button);
                    }
                }
            }

            public function fetch_users_in_plan() {
                global $con;

                // fetch name and surname of users which are in plan
                $sql = "SELECT users.user_id, users.name, users.surname, users.email FROM users_in_plan INNER JOIN users ON users.user_id=users_in_plan.user_id WHERE plan_id={$this->plan_id}";
                $query = $con->query($sql);
                
                if($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        // print their name and surname in option
                        echo "<option value={$row['user_id']}>{$row['name']} {$row['surname']}</option>";
                        $this->quantity_of_user += 1;
                        // add people into array with user
                        array_push($this->users_array, $row['email']);
                    }
                }

            }

            function count_users_in_plan() {
                return $this->quantity_of_user;
            }

            function users_in_plan() {
                return $this->users_array;
            }
        }

        class People_in_plan {
            private $plan_id;

            public function __construct() {
                $this->plan_id = $_GET['id'];
            }

            public function add_people() {
                global $con, $plan, $add_new_user_error;

                if($plan->count_users_in_plan() == 3) {
                    return "You can't add more people into plan";
                }
                
                // TODO: send email with linkt into accpet invitation for plan, but I must have www server

                // temporary adding system
                $user_email = $_POST['new_user_email'];
                // try to find user in db
                $search = "SELECT user_id FROM users WHERE email='$user_email'";
                $query_search = $con->query($search);


                $array_with_users = $plan->users_in_plan();
                // check if user doesn't exist in plan
                if(in_array($user_email, $array_with_users)) {
                    return "User alrady exist in plan";
                }

                // check whether isset user in db with this email
                if($query_search->num_rows > 0) {
                    // declare var with array where is user id
                    $new_user_id = $query_search->fetch_assoc();
                    // insert new user
                    $insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) VALUES({$this->plan_id}, {$new_user_id['user_id']})";
                    $query_indert_user = $con->query($insert_new_user);
                    // refresh page
                    header("Refresh: 0");
                }
            }
        }

        function dates_of_current_week() {
            $dt = new DateTime();
            for ($d=1; $d<=7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $day = date('l', strtotime($dt->format('Y-m-d')));
                echo "<option>$day, {$dt->format('Y-m-d')}</option>";
            }
        }

        // object with whole body of plan
        $plan = new Plan(); 

        // create new object with function to adding people into plan and manipulate with this data
        $people_in_plan = new People_in_plan();


        // check which method of Task_manipulation have to run
        if(isset($_POST['complete'])) {
            Tasks_manipulation::complete_plan($_POST['complete']);
        }
        else if(isset($_POST['uncomplete'])) {
            Tasks_manipulation::uncomplete_plan($_POST['uncomplete']);
        }
        else if(isset($_POST['delete'])) {
            Tasks_manipulation::delete_plan($_POST['delete']);
        }
        else if(isset($_POST['add_task'])) {
            Tasks_manipulation::add_task();
        }
        
    ?>


    <div id="main">
        <div id="adding_section">
            <div id="add_new_task">
                <h2>Add new task</h2>
                <form method="POST">
                    <input class="input_adding_system" type="text" name="plan_name" placeholder="Enter new task name..." required>
                    <input class="input_adding_system" type="text" name="plan_description" placeholder="Enter new task description..." required>

                    <select name="date" class="select_adding_system">
                        <option selected disabled>Select date</option>
                        <?php dates_of_current_week(); ?>
                    </select>
                    
                    <select name="type" class="select_adding_system">
                        <option disabled selected>Choose type of plan</option>
                        <option>Basic</option>
                        <option>Primary</option>
                        <option>Important</option>
                    </select>

                    <select name="owner_of_task" class="select_adding_system">
                        <option disabled selected>Choose user for task</option>
                        <?php $plan->fetch_users_in_plan(); ?>
                    </select>

                    <hr>
                    <button type="submit" name="add_task" id="add_task_submit" class="submit-button">Add plan</button>
                </form>
            </div>

            <div id="add_new_people">
                <h2 style="margin-top: 40px;">Add people into plan</h2>
                <form method="POST">
                    <p id="people_count">People: <?php echo $plan->count_users_in_plan(); ?>/3</p>
                    <input class="input_adding_system" type="email" name="new_user_email" placeholder="Enter new user email..." required>
                    
                    <hr>
                    <button type="submit" name="add_people" class="submit-button">Send invitation</button> 
                    
                    <p class="error_call">
                        <?php
                            // run function with adding new people into plan
                            if(isset($_POST['add_people'])) {
                                echo $people_in_plan->add_people();
                            }
                        ?>
                    </p>
                </form>
            </div>
        </div>

        <div id="week-container">
            <?php $plan->print_days_box(); ?>
        </div>
    </div>

</body>
</html>