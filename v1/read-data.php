<?php
ini_set("display_errors", 1);

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
USE \Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

// Including files
include_once("../config/database.php");
include_once("../classes/users.php");

// Objects
$db = new Database();
$connection = $db->connect();
$user_obj = new Users($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $all_headers = getallheaders();

    $data = new stdClass(); // Initialize $data as an object

    $data->jwt = $all_headers['Authorization'];

    //$data = json_decode(file_get_contents("php://input"));

    if (!empty($data->jwt)) {
        try {
            $secret_key = "owt123";
            //$key_id = null;

             // Check if "kid" exists in the token's header
             $decoded_data = JWT::decode($data->jwt, new key($secret_key,  'HS512'));
             /*if (isset($decoded_token->kid)) {
                 $key_id = $decoded_token->kid;
             }
             //if(isset($key_id))
             $decoded_data = JWT::decode($data->jwt, new Key($secret_key,  'HS256',$key_id));*/
            http_response_code(200);

            $user_id = $decoded_data->data->id;

            echo json_encode(array(
                "status" => 1,
                "message" => "We got the JWT token",
                "user_data" => $decoded_data,
                "user_id" => $user_id
            ));
        } catch (Exception $ex) {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => $ex->getMessage()
                
            ));
        }
    }
}
?>