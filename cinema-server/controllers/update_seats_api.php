<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Seat.php");

header("Content-Type: application/json");


$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    $seat = Seat::update_all($conn, $data);
    if(!$seat){
        http_response_code(404);
        $response = ["Message" => "seats not found."];
    }else{
        http_response_code(200);
        $response = ["Message" => "seats updated successfully."]; 
    }
}else{
    http_response_code(400);
    $response = ["Message" => "Bad Request, Wrong URL"];
}

echo json_encode($response);