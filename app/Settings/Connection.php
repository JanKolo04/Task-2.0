<?php

    namespace Connection;
    
    // import global variable
    use mysqli;

    // declare static variable for connection with database
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "week_planer");

    class Connection {
        static public function connect() {
            // 
            $con = new mysqli("localhost", "root", "", "week_planer");

            if($con->connect_error) {
                echo "Error with connection with db";
            }
            else {
                return $con;
            }
        }
    }

    
?>