<?php

    namespace Database;
    
    // import global variable
    use mysqli;

    // declare static variable for connection with database
    define("DB_HOST", "127.0.0.1");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "week_planer");

    class Connection {
        static public function connect() {
            // create connection with database
            $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // handle errors
            if($con->connect_error) {
                echo "Error with connection with db";
            }
            else {
                return $con;
            }
        }
    }

    
?>