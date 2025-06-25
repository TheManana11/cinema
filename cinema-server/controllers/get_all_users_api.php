<?php

require("../models/User.php");

header('Content-Type: application/json');

$all_users = [];
$response = [];
$user = new User();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if($user->getAllUsers()){
        $all_users = $user->getAllUsers();
        $response["status"] = "200";
        $response["users"] = $all_users;
        $response["message"] = "Fetched Successfully";
    }else{
        $response["status"] = "404";
        $response["message"] = "No Users found in the database";
    }
}else{
    $response["status"] = "400";
    $response["message"] = "Bad Request";
}

echo json_encode($response);