<?php

    namespace Users;

    // import object with connection with database
    use Connection\Connection;

    class AllUsers {
        private $con;
        private $user_id;

        public function __construct() {
            // setup properties
            $this->con = Connection::connect();
            // use short version of if for better performance
            $this->user_id = !empty($_GET['id']) ? $_GET['id'] : "";
        }

        public function getAllUsers() {
            // fetch all users from 'users' table
            $sql = "SELECT * FROM users";
            $query = $this->con->query($sql);
        
            // print data about all users
            if($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                    echo "{$row['user_id']} {$row['name']} {$row['surname']}</br>";
                }
            }
        }

        public function choosedUser() {
            // fetch data about choosed user from 'users' table
            $sql = "SELECT * FROM users WHERE user_id={$this->user_id}";
            $query = $this->con->query($sql);

            if($query->num_rows > 0) {
                // print data
                $row = $query->fetch_assoc();
                echo "{$row['user_id']} {$row['name']} {$row['surname']}</br>";
            }
            else {
                echo "User with <b>id {$this->user_id}</b> doesnt exist";
            }
        }

        public function chooseCorrectMethod() {
            // if user add in url ?id=1 so function with choosedUser will be run
            if(!empty($this->user_id)) {
                $this->choosedUser();
            }
            else {
                $this->getAllUsers();
            }
        }
    }

    $users = new AllUsers();
    $users->chooseCorrectMethod();


?>