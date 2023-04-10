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
    
        include("header.php");
        include("connection.php");

        class All_Plans {
            private $user_id;

            function __construct() {
                // $this->user_id = $_SESSION['user_id'];
                $this->user_id = 1;
            }

            function find_and_print() {
                global $con;
                
                // find plans in which user is
                $sql = "SELECT plans.* FROM users_in_plan INNER JOIN plans ON users_in_plan.plan_id=plans.plan_id WHERE users_in_plan.user_id={$this->user_id}";
                $query = $con->query($sql);

                // if some plans will find print hmtl object with plan
                if($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        echo "
                            <div class='plan'>
                                <div class='plan_photo'></div>
                                <div class='plan_name_and_button'>
                                    <p class='plan_name'>{$row['name']}</p>
                                    <a href='plan.php?id={$row['plan_id']}' class='plan_button_to_open'>Open</a>
                                </div>
                            </div>
                        ";
                    }
                }
            }
        }

        $all_user_plans = new All_Plans();

    ?>

    <div id="all_plans">
        <?php $all_user_plans->find_and_print(); ?>
        <div class='plan add_plan'>
            <a class="add_plan_button" href="add_new_plan.php">+</a>
            <p class="plan_name">Add new plan</p>
        </div>
    </div>

</body>
</html>