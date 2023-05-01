<?php

    namespace Controller;

    class AutoloadFilesRequest {
        public $file;
        public function __construct() {
            // create ternary operator with $_SERVER['REDIRECT_URL'] for $file variable
            // if $_SERVER['REDIRECT_URL'] is not empty get value of $_SERVER['REDIRECT_URL'] and set to $file
            // but if is set "" for $file 
            $this->file = !empty($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : "";
        }
        
        public function checkCorrectnessOfRequest() {
            // check whether request is in switch
            switch($this->file) {
                case(''):
                    include 'Pages/main.php';
                    break;
                case('/users'):
                    include 'Pages/Users/AllUsers.php';
                    break;
                case('/adduser'):
                    include 'Pages/Users/AddUser.php';
                    break;
                default:
                    include 'Pages/error.php';
            }
        }
    }

?>