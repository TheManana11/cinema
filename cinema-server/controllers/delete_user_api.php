<?php

require("../connection/connection.php");
require("../models/User.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $user = User::find($conn, $id);
        if (!$user) {
            $response = ["status" => 404, "message" => "User with Id {$id} is not available in database."];
        } else{

            $deleted_user = $user->delete($conn, $id);
            if($deleted_user){
                http_response_code(200);
                $response = ["Message" => "User deleted successfully"];
            }else{
                http_response_code(200);
                $response = ["Message" => "Failed to deleted user"];
            }
        }
    }else{ 
       $response = ["status" => 404, "message" => "ID is required"];
    }
}

echo json_encode($response);