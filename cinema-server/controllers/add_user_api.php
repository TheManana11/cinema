<?php

require("../models/User.php");

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = [];
$user = new User();
$data = json_decode(file_get_contents("php://input"), true);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!isset($data["first_name"]) || !isset($data["last_name"]) || !isset($data["email"]) || !isset($data["phone_number"]) || !isset($data["password"])){
        $response["status"] = 400;
        $response["message"] = "Please fill all the fields";
    }else{
        $success = $user->addUser($data["first_name"], $data["last_name"], $data["email"], $data["phone_number"], $data["password"]);
        if($success){
            $response["status"] = 201;
            $response["message"] = "User Created Successfully";
        }else{
            $response["status"] = 500;
            $response["message"] = "Server Error | Can't create user right now";
        }
    }
}else{
    $response["status"] = 400;
    $response["message"] = "Bad Request";
}

echo json_encode($response);