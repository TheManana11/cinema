<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Seat.php");

header('Content-Type: application/json');

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if(empty($data["show_id"]) || empty($data["row"]) || empty($data["number"])){
        http_response_code(400);
        $response = ["Message" => "Bad request, please fill all the fields"];
    }else{

        $seat = Seat::create($conn, $data);
        if(!$seat){
            http_response_code(500);
            $response = ["Message" => "Failed to Create seat"];
        }else{

            http_response_code(201);
            $response = ["Message" => "seat Created Successfully", "seat" => $seat->toArray()];
        }
    
    }

}else{
    http_response_code(400);
    $response = ["Message" => "Bad request, Wrong URL"];
}

echo json_encode($response);