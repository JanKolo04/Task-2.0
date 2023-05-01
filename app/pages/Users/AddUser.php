<?php

    namespace Users;

    use Connection\Connection;
    use \Colors\RandomColor;

    class Adduser {
        private $con;
        private $date;
        private $avatar;

        public function __construct() {
            $this->con = Connection::connect();
        }

        public function checkExist() {
            // try to find user with entered email
            $sql = "SELECT user_id FROM users WHERE email='{$_POST['email']}'";
            $query = $this->con->query($sql);
            
            // if some user have email like entered return True
            if($query->num_rows > 0) {
                return True;
            }

            return False;
        }

        public function currentDate() {
            // add to $this->date current date
            $this->date = date('Y-m-d');
        }

        private function hashPassword($passwd) {
            // hash password for security
            $hash = password_hash($passwd, PASSWORD_DEFAULT);

            return $hash;
        }

        public function checkAvatar() {
            // if $_POST['avatat'] is empty generate random hex color
            if(empty($_POST['avatar'])) {
                $this->avatar = RandomColor::one();
            }

            $this->avatar = $_POST['avatar'];
        }

        public function add() {
            // if checkExist return False add new user, but if not return message
            if($this->checkExist() == False) {
                // hash password
                $hash = $this->hashPassword($_POST['password']);

                // add new user
                $sql = "INSERT INTO users(name, surname, email, password, join_date, avatar) 
                        VALUES('{$_POST['name']}', '{$_POST['surname']}', '{$_POST['email']}', '$hash', '{$this->date}', '{$this->avatar}')";
                $query = $this->con->query($sql);
            }
            else {
                echo "User exist with this email";
            }
        }
    }

    $addUser = new AddUser();
    // if REQUEST_METHOD equals POST run methods
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $addUser->currentDate();
        $addUser->checkAvatar();
        $addUser->add();
    }

?>
