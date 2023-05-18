<?php

    namespace Plan\Option;

    // create alias of namespace
    use Database\Connection;
    use Colors\RandomColor;

    class AddPlanValidation {
        /**
         * validationAddedUser check whether user didin't added user which doesn't exist in db
         * or check whether user didin't add yourself
         * 
         * @param array $plan_users The array with emial of added users 
         */
        protected function validationAddedUser($plan_users): bool {
            if(!empty($plan_users)) {
                for($i=0; $i<sizeof($plan_users); $i++) {
                    $sql = "SELECT user_id FROM users WHERE email='{$plan_users[$i]}'";
                    $query = $this->con->query($sql);

                    if($query->num_rows == 0) {
                        return True;
                    }
                }
            }
            return False;
        } 
    }

    class AddPlan extends AddPlanValidation {
        private $con;

        public function __construct() {
            // set $con valriable with object of connect with db
            $this->con = Connection::connect();
        }

        /*
        Name of inputs in plan creator:
            - Name: plan_name string required
            - Users in plan: plan_users empty/(array)
            - Bg_color: plan_color empty/file
        */

        /**
         * checkExist function to check whether exist plan with the same name and return bool type
         * @param string $plan_name The name of plan
         */
        private function checkExist($plan_name): bool {
            if(!empty($plan_name)) {
                // MYSQL query
                $sql = "SELECT plan_id FROM plans WHERE name='{$_POST['plan_name']}'";
                $query = $this->con->query($sql);

                // if $query return 1 row return True
                if($query->num_rows == 1) {
                    return True;
                }
                return False;
            }
        }

        /**
         * setupBgColor function to check whether user check the color but if not generate random
         * 
         * @param string $bg_color The bachground color of plan
         */
        private function setupBgColor($bg_color): string {
            // if user didin't pick the color generate random in hex
            if(empty($bg_color)) {
                return RandomColor::one();
            }
            return $bg_color;
        }

        /**
         * addUsers function to add users which are choosed
         * 
         * @param array $plan_users The array with emails of choosed users
         * @param int $plan_id The id of plan
         */
        private function addUsers($plan_users, $plan_id): void {
            // if user added any user and function valiadationAddedUsers return False
            if(!empty($plan_users) && $this->validationAddedUser($plan_users) == False) {
                for($i=0; $i<sizeof($plan_users); $i++) {
                    // add new user into plan
                    $sql = "INSERT INTO users_in_plan(plan_id, user_id) VALUES(
                        {$plan_id}, (SELECT user_id FROM users WHERE email='{$plan_users[$i]}')
                    );";
                    $query = $this->con->query($sql);
                }
            }
        }
        
        public function addPlan($plan_name, $plan_users, $bg_color): void {
            if(!empty($plan_name) && $this->checkExist($plan_name) == False) {
                // add new plan
                $sql_add = "INSERT INTO plans(name, bg_photo) VALUES(
                    '{$plan_name}', '{$this->setupBgColor($bg_color)}'
                );";
                $query_add = $this->con->query($sql_add);

                // get id of added plan
                $sql_id = "SELECT plan_id FROM plans WHERE name='{$plan_name}';";
                $query_id = $this->con->query($sql);

                // declare var with id of plan
                $plan_id = $query->fetch_assoc()['plan_id'];                

                // run function with adding new users into plan
                $this->addUsers($plan_users, $plan_id);
                
            }
            
        }

        /**
         * TODO:  
         *  - Check whether all code with adding new plan work good
         *  - Add documentation for addPlan() function like to others
         */ 
    
    }

?>