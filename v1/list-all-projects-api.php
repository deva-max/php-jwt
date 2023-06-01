<?php
    ini_set("display_errors", 1);

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");

    // Including files
    include_once("../config/database.php");
    include_once("../classes/users.php");

    // Objects
    $db = new Database();
    $connection = $db->connect();
    $user_obj = new Users($connection);

    if ($_SERVER['REQUEST_METHOD'] === "GET") {

        $projects = $user_obj->get_all_projects();

        $project_arr = array();

        if($projects->num_rows > 0){
            while($row = $projects->fetch_assoc()){
                
                $project_arr[] = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "description" => $row['description'],
                    "userId" => $row['userId'],
                    "status" => $row['status'],
                    "created_at" => $row['created_at']
                );

            }

            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => $project_arr
            ));
        }else{
            http_response_code(404);
            echo json_encode(array(
                "status" => 0,
                "message" => "no records"
            ));
        }
    }

?>