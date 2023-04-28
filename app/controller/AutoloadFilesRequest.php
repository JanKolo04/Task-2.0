<?php

    namespace Controller;

    class AutoloadFilesRequest {
        public $file;
        public function __construct() {
            $this->file = $_SERVER['REQUEST_URI'];
        }
        public function checkExist() {
            if($this->file == '/') {
                return true;
            }
            else if(file_exists('pages/'.$this->file.'.php')) {
                return true;
            }
            else {
                return false;
            }
        }

        public function importFile() {
            if($this->checkExist()) {
                if($this->file == '/') {
                    include 'pages/main.php';
                }
                else {
                    include 'pages/'.$this->file.'.php';
                }
            }
            else {
                echo "Page not found";
            }
        }
    }

?>