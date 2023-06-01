<?php
    ini_set("display_errors", 1);

    require "../vendor/autoload.php";
    use \Firebase\JWT\JWT;
    USE \Firebase\JWT\Key;

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

        $headers = getallheaders();

        $jwt = $headers['Authorization'];

        $security_key = "owt123";

        try{
            
            $decoded_data = JWT::decode($jwt, new key($security_key, 'HS512'));

            $user_obj->user_id = $decoded_data->data->id;

            $projects = $user_obj->user_get_all_projects();

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

        }catch(Exception $ex){
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => $ex->getMessage()
            ));
        }

        
    }
?>