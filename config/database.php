<?php
    class Database{
        //variable declaration
        private $hostname;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        public function connect(){
            //variable initialization
            $this->hostname = "localhost";
            $this->dbname = "course";
            $this->username = "root";
            $this->password = "";

            $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
            if($this->conn->connect_errno){
                print_r($this->conn->connect_error);
            }else{
                return $this->conn;
            }
        } 
    }
?>