<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/main.css">
    <link type="text/css" rel="stylesheet" href="style/header_footer.css">
    <title>Week planer - Main page</title>
</head>
<body>

    <?php
        session_start();

        include("header.php");
        include("check_login.php");
    
    ?>

    <div id="main-text">
        <h2>Choose calendar or reminder</h2>
    </div>

    <div id="stuff">
        <div class="stuff-box" id="calendar-section">
            <a href="all_plans.php"><div class="photo" id="calendar"></div></a>
            <p>Week calendar is teh best tool to plan your all week to have better performance.</p>
        </div>

        <div class="stuff-box" id="reminder-section">
            <a href="reminder.php"><div class="photo" id="reminder"></div></a>
            <p>Reminder can help you to remember all your tasks.</p>
        </div>
    </div>

</body>
</html>