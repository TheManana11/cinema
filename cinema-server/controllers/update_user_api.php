<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/User.php");

header("Content-Type: application/json");


$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    if(!$data || !isset($id)){
        http_response_code(400);
        $response = ["Message" => "Bad Request, ID is required"];
    }

    if($data["password"]){
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
    }

    $user = User::find($conn, $id);
    if(!$user){
        http_response_code(404);
        $response = ["Message" => "User not found."];
    }

    $updated_user = $user->update($conn, $data);
    if($updated_user){
        http_response_code(200);
        $response = ["Message" => "User Updated Successfully.", "updated_user" => $updated_user->toArray()];
    }else{
        http_response_code(500);
        $response = ["Message" => "User failed to update."];
    }
}else{
    http_response_code(400);
    $response = ["Message" => "Bad Request, Wrong URL"];
}

echo json_encode($response);