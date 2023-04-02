<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/all_plans.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <title>Week planer - Main page</title>
</head>
<body>

    <?php
    
        include("header.php");
        include("connection.php");

        class All_Plans {
            private $user_id;

            function __counstruct() {
                // $this->user_id = $_SESSION['user_id'];
                $this->user_id = 1;
            }

            function find_and_print() {
                global $con;

                $sql = "SELECT * FROM plans WHERE users_id IN ({$this->user_id})";
                $query = $con->query($sql);

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
        $all_user_plans->__counstruct();

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