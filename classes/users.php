<?php
    class Users{
        //define properties
        public $name;
        public $email;
        public $password;
        public $user_id;
        public $project_name;
        public $description;
        public $status;

        private $conn;
        private $users_tbl;
        private $projects_tbl;

        public function __construct($db){
            $this->conn = $db;
            $this->users_tbl = "tbl_users";
            $this->projects_tbl = "tbl_projects";
        }

        public function create_user(){
            $user_query = "INSERT INTO " . $this->users_tbl . " SET name = ?, email = ?, password = ? ";
            $user_obj = $this->conn->prepare($user_query);

            if ($user_obj) {
                $user_obj->bind_param("sss", $this->name, $this->email, $this->password);
                
                if ($user_obj->execute()) {
                    return true;
                } else {
                    // Handle execute error
                    // Example: 
                    echo $user_obj->error;
                }
            } else {
                // Handle prepare error
                // Example: 
                echo $this->conn->error;
            }

            return false;

        }
        public function check_email(){
            $email_query = "SELECT * FROM ".$this->users_tbl." WHERE email = ?";
            $user_obj = $this->conn->prepare($email_query);

            if($user_obj){
                $user_obj->bind_param("s",$this->email);
                if($user_obj->execute()){
                    $data = $user_obj->get_result();
                    return $data->fetch_assoc();
                }else{
                    echo $user_obj->error;
                }
            }else{
                echo $this->conn->error;
            }
            return array();
        }
        public function check_login(){
            $email_query = "SELECT * FROM ".$this->users_tbl." WHERE email = ?";
            $user_obj = $this->conn->prepare($email_query);

            if($user_obj){
                $user_obj->bind_param("s",$this->email);
                if($user_obj->execute()){
                    $data = $user_obj->get_result();
                    return $data->fetch_assoc();
                }else{
                    echo $user_obj->error;
                }
            }else{
                echo $this->conn->error;
            }
            return array();
        }
        public function create_project(){
            $project_query = "INSERT INTO " . $this->projects_tbl . " SET userId = ?, name = ?, description = ?, status = ?";
            $project_obj = $this->conn->prepare($project_query);
            
            //sanitize input variables
            $project_name = htmlspecialchars(strip_tags($this->project_name));
            $description = htmlspecialchars(strip_tags($this->description));
            $status = htmlspecialchars(strip_tags($this->status));
            
            if($project_obj){
                $project_obj->bind_param("isss", $this->user_id, $this->project_name, $this->description, $this->status);
                
                if($project_obj->execute()){
                    return true;
                }
                
                return false;
            } else{
                echo $this->conn->error;
            }
        }
        public function get_user_all_projects(){
            $project_query = " SELECT * FROM " . $this->projects_tbl . " ORDER BY id DESC ";
            $project_obj = $this->conn->prepare($project_query);

            if($project_obj){
                
                $project_obj->execute();

                return $project_obj->get_result();

            }else{

                echo $this->conn->error;
            }
        }
        public function user_get_all_projects(){
            $project_query = " SELECT * FROM " . $this->projects_tbl . " WHERE userId = ? ORDER BY id DESC ";
            $project_obj = $this->conn->prepare($project_query);

            if($project_obj){
                
                $project_obj->bind_param("i", $this->user_id);
                
                $project_obj->execute();

                return $project_obj->get_result();

            }else{

                echo $this->conn->error;
            }
        }

    }
?>