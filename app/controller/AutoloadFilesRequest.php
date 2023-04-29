<?php

    namespace Controller;

    class AutoloadFilesRequest {
        public $file;
        public function __construct() {
            $this->file = $_SERVER['REDIRECT_URL'];
        }
        
        public function checkCorrectnessOfRequest() {
            // check whether request is in switch
            switch($this->file) {
                case('/'):
                    include 'Pages/main.php';
                    break;
                case('/users'):
                    include 'Pages/Users/AllUsers.php';
                    break;
                default:
                    include 'Pages/error.php';
            }
        }
    }

?>