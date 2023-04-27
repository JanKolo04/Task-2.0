<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/all_plans.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <title>Week planer - Plans</title>
</head>
<body>

    <?php
    
        session_start();
        
        include("header.php");
        include("connection.php");
        include("check_login.php");

        class AllPlans {
            private $user_id;

            public function __construct() {
                $this->user_id = $_SESSION['user_id'];
            }

            public function find_and_print() {
                global $con;
                
                // find plans in which user is
                $sql = "SELECT plans.* FROM users_in_plan INNER JOIN plans ON users_in_plan.plan_id=plans.plan_id WHERE users_in_plan.user_id={$this->user_id}";
                $query = $con->query($sql);

                // if some plans will find print hmtl object with plan
                if($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        echo "
                            <div class='plan'>
                                <div class='plan_photo' style='background-color: {$row['bg_photo']};'>
                                    <form method='POST'>
                                        <button class='deletePlanButton' type='submit' name='delete' value='{$row['plan_id']}'>X</button>
                                    </form>
                                </div>
                                <div class='plan_name_and_button'>
                                    <p class='plan_name'>{$row['name']}</p>
                                    <a href='plan?id={$row['plan_id']}' class='plan_button_to_open'>Open</a>
                                </div>    
                            </div>
                        ";
                    }
                }
            }
        }

        class ManipulatePlans {
            public static function deleteUsers($planId) {
                global $con;

                // find and delete users which are in plan
                $sql = "DELETE FROM users_in_plan WHERE plan_id={$planId}";
                $query = $con->query($sql);
            }
            public static function deletePlan($planId) {
                global $con;

                // run function with delete users from plan
                self::deleteUsers($planId);
                // delete plan
                $sql = "DELETE FROM plans WHERE plan_id={$planId}";
                $query = $con->query($sql);
            }
        }

        // create object from class AllPlans
        $all_user_plans = new AllPlans();

        // if user click delete button run static function
        if(isset($_POST['delete'])) {
            ManipulatePlans::deletePlan($_POST['delete']);
        }
    ?>

    <div id="all_plans">
        <?php $all_user_plans->find_and_print(); ?>
        <div class='plan add_plan'>
            <a class="add_plan_button" href="add_new_plan">+</a>
            <p class="plan_name">Add new plan</p>
        </div>
    </div>

</body>
</html>