<?php

    namespace Themplates;

    // import object with connection with database
    use Database\Connection;

    class AllOrChoosed {
        private $con;
        private $id;
        private $table;
        private $id_name;
        private $data = array();

        public function __construct($table, $id_name) {
            // setup properties
            $this->con = Connection::connect();
            // ternary operator with $_GET['id']
            // if $_GET['id'] is not empty set value to $id of $_GET['id'] but if is set "" for $id
            $this->id = !empty($_GET['id']) ? $_GET['id'] : "";
            // add table
            $this->table = $table;
            // set id name for function where user what to get data with choosed id
            $this->id_name = $id_name;
        }

        public function getAllData($table) {
            // fetch all data from 'table' table
            $sql = "SELECT * FROM {$table}";
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

        public function choosedData($table, $id, $id_name) {
            // fetch data about choosed user from 'table' table
            $sql = "SELECT * FROM {$table} WHERE {$id_name}={$id}";
            $query = $this->con->query($sql);

            if($query->num_rows > 0) {
                // append data into array
                $this->data = $query->fetch_assoc();
            }
            else {
                return "Data with <b>id {$id}</b> doesnt exist";
            }

            // return array with data in json format and with UTF-8 codding
            return json_encode($this->data, JSON_UNESCAPED_UNICODE);
        }

        public function chooseCorrectMethod() {
            // if ?id='id_of_data' is not empty run choosedData method
            if(!empty($this->id)) {
                $choose_data = $this->choosedData($this->table, $this->id, $this->id_name);
                echo $choose_data;
            }
            else {
                $allData = $this->getAllData($this->table);
                echo $allData;
            }
        }
    }


?>