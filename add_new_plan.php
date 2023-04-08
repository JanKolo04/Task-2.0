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
    
        include("header.php");
        include("connection.php");

        
    ?>

<div class="form">
    <form method="POST">
        <label for="planNameInput">Nazwa planu:</label>
        <input type="text" id="planNameInput" name="planNameInput">

        <label for="planColorInput">Kolor:</label>
        <input type="color" id="planColorInput" name="planColorInput" value="#ffffff">

        <label for="planUserInput">Użytkownik:</label>
        <input type="email" id="planUserEmail" name="planUserInput">
        <span id="usersCount">Ilość uytkowników: <span id="usersCountValue">0</span>/3</span>
    
        <div class="usersSection flexRow">
            <div class="allAddedUsers flexRow"></div>
            <a class="addButton" onclick="AddNewUser();">Add user</a>
        </div>

        <button class="addButton" type="button" id="addPlanBtn">Dodaj</button>
    </form>
</div>


<script src="js/add_plan.js"></script>
</body>
</html>