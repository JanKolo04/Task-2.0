<?php

    namespace Users;

    // import object with connection with database
    use Connection\Connection;

    class Users {
        private $con;
        private $user_id;
        private $data = array();

        public function __construct() {
            // setup properties
            $this->con = Connection::connect();
            // ternary operator with $_GET['id']
            // if $_GET['id'] is not empty set value to $user_id of $_GET['id'] but if is set "" for $user_id
            $this->user_id = !empty($_GET['id']) ? $_GET['id'] : "";
        }

        public function getAllUsers() {
            // fetch all users from 'users' table
            $sql = "SELECT * FROM users";
            $query = $this->con->query($sql);
        
            // append all users data into assoc array
            $counter = 0;
            if($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                    // append data into array
                    $this->data += [$counter => $row];
                    $counter += 1;
                }
            }
            
            // return array with data in json format and with UTF-8 codding
            return json_encode($this->data, JSON_UNESCAPED_UNICODE);
        }

        public function choosedUser() {
            // fetch data about choosed user from 'users' table
            $sql = "SELECT * FROM users WHERE user_id={$this->user_id}";
            $query = $this->con->query($sql);

            if($query->num_rows > 0) {
                // append data into array
                $this->data = $query->fetch_assoc();
            }
            else {
                return "User with <b>id {$this->user_id}</b> doesnt exist";
            }

            // return array with data in json format and with UTF-8 codding
            return json_encode($this->data, JSON_UNESCAPED_UNICODE);
        }

        public function chooseCorrectMethod() {
            // if user add in url '?id=1' so function with choosedUser will be run
            if(!empty($this->user_id)) {
                echo $this->choosedUser();
            }
            else {
                echo $this->getAllUsers();
            }
        }
    }

    $users = new Users();
    $users->chooseCorrectMethod();


?>