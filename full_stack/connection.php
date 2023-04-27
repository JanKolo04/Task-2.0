<?php

    $host = "localhost";
    $user = "root";
    $passwd = "";
    $db = "week_planer";

    $con = new mysqli($host, $user, $passwd, $db);

    if($con->connect_error) {
        die("Connection error");
    }

?>