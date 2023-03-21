<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/plan.css">
    <script src="js/plan.js"></script>
    <title>Week planer - Calendar</title>
</head>
<body>


    <?php
    
        include("connection.php");

        $plan = new Plan(); 
        // set class variables for better performance
        $plan->__construct();

        $tasks_manipulation = new Tasks_manipulation();
        // set class variables for better performance
        $tasks_manipulation->__construct();

        // create new object with function to adding people into plan and manipulate with this data
        $people_in_plan = new People_in_plan();
        $people_in_plan->__construct();

        // check which function code have to run
        if(isset($_POST['complete'])) {
            $tasks_manipulation->complete_plan($_POST['complete']);
        }
        else if(isset($_POST['uncomplete'])) {
            $tasks_manipulation->uncomplete_plan($_POST['uncomplete']);
        }
        else if(isset($_POST['delete'])) {
            $tasks_manipulation->delete_plan($_POST['delete']);
        }
        else if(isset($_POST['add_task'])) {
            $tasks_manipulation->add_task();
        }

        class Plan {
            public $plan_id;
            public $quantity_of_user;
            public $users_array = [];

            function __construct() {
                $this->plan_id = $_GET['id'];
            }

            function print_days_box() {
                $dt = new DateTime();
                // get name of current day
                $current_day_name = date('D');
                for ($d=1; $d<=7; $d++) {
                    $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                    // short version of day name
                    $day_short_ver = date('D', strtotime($dt->format('Y-m-d')));
                    
                    // set appropriate class
                    $class_day = "other";
                    if($current_day_name == $day_short_ver) {
                        $class_day = "today";
                    }
                    // number of day in month
                    $day_number = date("d", strtotime($dt->format('Y-m-d')));
                    // print first peice of section
                    echo "
                        <div class='day-container $class_day'>
                            <div class='day-name'>
                                <h3>$day_short_ver <span class='day-date'>$day_number FEB</span></h3>
                            </div>
                            <div class='plans-container'>
                    ";
                    // print all plans 
                    $this->fetch_all_plans(date('l', strtotime($dt->format('Y-m-d'))));
                    // and finally close all divs
                    echo "
                            </div>
                        </div>
                    ";
     
                }
            }

            function fetch_all_plans($day) {
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
                        $desc = $row['description'];
                        if(strlen($row['description']) > 30) {
                            $desc = substr($desc, 0, 30).'...';
                        }

                        // print tasks
                        echo "
                            <div class='task {$row['type']}'>
                                <form method='POST'>
                                    <div class='task-top'>
                                        <p class='task_name {$status}'>{$row['name']}</p>
                                        <div class='flex-right'>$avatar</div>
                                    </div>
                                    
                                    <div class='task-middle'>
                                        <p class='task-description task-description-short' id='short_text_{$row['task_id']}'>$desc</p>
                                        <p class='task-description show-more-text' id='show_more_{$row['task_id']}'>{$row['description']}</p>
                                        <a class='show-more-button-task' onclick='show_more({$row['task_id']}, this)'>↓</a>
                                    </div>

                                    <div class='task-button-manipulation'>
                                        <button type='submit' name='$complete_button' value='{$row['task_id']}'>√</button>
                                        <button type='submit' name='delete' value='{$row['task_id']}'>X</button>
                                    </div>
                                </form>
                            </div>
                        ";
                    }
                }
            }

            function fetch_users_in_plan() {
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

            function __count_users_in_plan() {
                return $this->quantity_of_user;
            }

            function __users_in_plan() {
                return $this->users_array;
            }
        }

        class Tasks_manipulation {
            private $plan_id;
            public $users_in_array;

            function __construct() {
                $this->plan_id = $_GET['id'];
            }

            function complete_plan($task_id) {
                global $con;
                // complete plan
                $sql = "UPDATE tasks SET status=1 WHERE task_id=$task_id";
                $query = $con->query($sql);

                if(!$query) {
                    return "Something wrong";
                }
            }

            function uncomplete_plan($task_id) {
                global $con;
                // uncomplete plan
                $sql = "UPDATE tasks SET status=0 WHERE task_id=$task_id";
                $query = $con->query($sql);

                if(!$query) {
                    return "Something wrong";
                }
            }

            function delete_plan($task_id) {
                global $con;
                // delete plan
                $sql = "DELETE FROM tasks WHERE task_id=$task_id";
                $query = $con->query($sql);

                if(!$query) {
                    return "Something wrong";
                }
            }

            function add_task() {
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
                $sql = "INSERT INTO tasks(plan_id, owner_id, name, description, day, date, type) VALUES({$this->plan_id}, {$_POST['owner_of_task']}, '{$_POST['plan_name']}', '{$_POST['plan_description']}', '$day', '$date', '$plan_type')";
                $query = $con->query($sql);

                if(!$query) {
                    echo "Something wrong";
         
                }
            }
        }

        class People_in_plan {
            private $plan_id;

            function __construct() {
                $this->plan_id = $_GET['id'];
            }

            function add_people() {
                global $con, $plan, $add_new_user_error;

                if($plan->__count_users_in_plan() == 3) {
                    return "You can't add more people into plan";
                }
                
                // TODO: send email with linkt into accpet invitation for plan, but I must have www server

                // temporary adding system
                $user_email = $_POST['new_user_email'];
                // try to find user in db
                $search = "SELECT user_id FROM users WHERE email='$user_email'";
                $query_search = $con->query($search);

                $array_with_users = $plan->__users_in_plan();
                // check if user doesn't exist in plan
                for($i=0; $i<sizeof($array_with_users); $i++) {
                    // if user exist in plan return error
                    if($user_email == $array_with_users[$i]) {
                        return "User exist in plan";
                    }
                }

                // check whether isset user in db with this email
                if($query_search->num_rows > 0) {
                    // declare var with array where is user id
                    $new_user_id = $query_search->fetch_assoc();
                    // insert new user
                    $insert_new_user = "INSERT INTO users_in_plan(plan_id, user_id) VALUES({$this->plan_id}, {$new_user_id['user_id']})";
                    $query_indert_user = $con->query($insert_new_user);
                    // refresh page
                    header("Refresh:0");
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
        
    ?>


    <div id="adding_section">
        <div id="add_new_task">
            <h2>Add new task</h2>
            <form method="POST">
                <input class="input_adding_system" type="text" name="plan_name" placeholder="Enter new task name..." required>
                <input class="input_adding_system" type="text" name="plan_description" placeholder="Enter new task desc..." required>

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
                <p id="people_count">People: <?php echo $plan->__count_users_in_plan(); ?>/3</p>
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

</body>
</html>