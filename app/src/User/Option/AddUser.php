<?php

    namespace User\Option;

    // create alias of class
    use Database\Connection;
    use Colors\RandomColor;

    class AddUser {
        private $con;
        private $avatar;

        public function __construct() {
            $this->con = Connection::connect();
        }

        /**
         * validData function to check user insert all needed data
         */
        private function validation(): bool {
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

        /**
         * checkExist function to check whether exist user with entered email
         * 
         * @param string $email String with user email
         */
        private function checkExist($email): bool {
            // try to find user with entered email
            $sql = "SELECT user_id FROM users WHERE email='{$email}'";
            $query = $this->con->query($sql);
            
            // if some user have email like entered return True
            if($query->num_rows > 0) {
                return True;
            }

            return False;
        }

        /**
         * hashPassword function to hash entered password
         * 
         * @param string $passwd Variable with password
         */
        private function hashPassword($passwd): string {
            // hash password for security
            $hash = password_hash($passwd, PASSWORD_DEFAULT);

            return $hash;
        }

        /**
         * checkAvatar function to check whether user choose color
         * 
         * @param string $avatar Variable with choosed or didin't choosed color
         */
        public function checkAvatar($avatar): string {
            // if $_POST['avatat'] is empty generate random hex color
            if(empty($avatar)) {
                return RandomColor::one();
            }

            return $avatar;
        }

        /**
         * add function to add new user into db
         * 
         * @param string $name Name of user
         * @param string $surname Lastname of user
         * @param string $email Email user
         * @param string $passwd Password user 
         * @param string $avatar Avatar (color which picked user)
         */
        public function add($name, $surname, $email, $passwd, $avatar): string {
            // if checkExist return False and validation funciton return False add new user, but if not return message
            if($this->validation() == False) {
                if($this->checkExist($email) == False) {
                    // hash password
                    $hash = $this->hashPassword($passwd);
                    // avatar
                    $avatar = $this->checkAvatar($avatar);
                    // set current date
                    $date = date('Y-m-d');

                    // add new user
                    $sql = "INSERT INTO users(name, surname, email, password, join_date, avatar) 
                            VALUES('{$name}', '{$surname}', '{$email}', '$hash', '{$date}', '{$avatar}')";
                    $query = $this->con->query($sql);

                    // check correctness of query with add user into db
                    if($query) {
                        return "User added correctly";
                    }
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
