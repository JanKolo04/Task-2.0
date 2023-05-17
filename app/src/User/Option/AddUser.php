<?php

    namespace User\Option;

    // create alias of class
    use Database\Connection;
    use Colors\RandomColor;

    class AddUser {
        private $con;
        private $date;
        private $avatar;

        public function __construct() {
            $this->con = Connection::connect();
        }

        private function validation() {
            // check whether exist $_POST which is empty
            foreach($_POST as $key => $value) {
                if($key == 'avatar') {
                    continue;
                }
                // if any POST is empty return True
                else if(empty($value)) {
                    return True;
                }
            }
            return False;
        }

        private function checkExist() {
            // try to find user with entered email
            $sql = "SELECT user_id FROM users WHERE email='{$_POST['email']}'";
            $query = $this->con->query($sql);
            
            // if some user have email like entered return True
            if($query->num_rows > 0) {
                return True;
            }

            return False;
        }

        private function hashPassword($passwd) {
            // hash password for security
            $hash = password_hash($passwd, PASSWORD_DEFAULT);

            return $hash;
        }

        public function checkAvatar() {
            // if $_POST['avatat'] is empty generate random hex color
            if(empty($_POST['avatar'])) {
                return RandomColor::one();
            }

            return $_POST['avatar'];
        }

        public function add() {
            // if checkExist return False and validation funciton return False add new user, but if not return message
            if($this->validation() == False) {
                if($this->checkExist() == False) {
                    // hash password
                    $hash = $this->hashPassword($_POST['password']);
                    // set current date
                    $this->date = date('Y-m-d');

                    // add new user
                    $sql = "INSERT INTO users(name, surname, email, password, join_date, avatar) 
                            VALUES('{$_POST['name']}', '{$_POST['surname']}', '{$_POST['email']}', '$hash', '{$this->date}', '{$this->checkAvatar()}')";
                    $query = $this->con->query($sql);
                }
                else {
                    echo "User exist with this email";
                }
            }
            else {
                echo "An input is empty";
            }
        }
    }

?>
