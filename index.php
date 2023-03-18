<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/index.css">
    <title>Week planer</title>
</head>
<body>

    <header>
        <div id="name">
            <h3><a class="link" href="index.php?page=main">Week Planer</a></h3>
        </div>

        <div id="links">
            <a class="link" href="index.php?page=calendar">Calendar</a>
            <a class="link" href="index.php?page=reminder">Reminder</a>
            <a class="link" href="index.php?page=account">Account</a>
        </div>
    </header>

    <div id="include_page">
        <?php
            session_start();
            
            $page = 'main';
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            }

            include($page.'.php');
        
        ?>
    </div>

</body>
</html>