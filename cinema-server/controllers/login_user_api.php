<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/User.php");

header("Content-Type: application/json");



$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);
    if(empty($data["email"]) || empty($data["password"])) {
        http_response_code(400);
        $response = ["Message" => "Bad request, fill all the fields."];
    }else{
        $user = User::login($conn, $data["email"]);
        if($user && password_verify($data["password"], $user->getPassword())){
            http_response_code(200);
            $response = ["user" => $user->toArray(), "Message" => "Logged in Successfully."];
        }else{
            http_response_code(404);
            $response = ["Message" => "User not found."];
        }
    }

}else{
    http_response_code(404);
    $response = ["Message" => "Bad request, Wrong URL."];
}

echo json_encode($response);