<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/User.php");

header('Content-Type: application/json');

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if(empty($data["first_name"]) || empty($data["last_name"]) || empty($data["email"]) || empty($data["phone_number"]) || empty($data["password"])){
        $response = ["status" => 400, "Message" => "Bad request, please fill all the fields"];
        return;
    }

    $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

    $user = User::create($conn, $data);
    if(!$user){
        $response = ["status" => 500, "Message" => "Failed to Create user"];
        return;
    }

    $response = ["status" => 201, "Message" => "User Created Successfully", "user" => $user->toArray()];
}else{
    $response = ["status" => 400, "Message" => "Bad request, Wrong URL"];
}

echo json_encode($response);