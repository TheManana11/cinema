<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Booking.php");

header('Content-Type: application/json');

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if(empty($data["user_id"]) || empty($data["movie_id"]) || empty($data["show_id"]) || empty($data["seat_id"]) ){
        http_response_code(400);
        $response = ["Message" => "Bad request, please fill all the fields"];
    }else{

        $booking = Booking::create($conn, $data);
        if(!$booking){
            http_response_code(500);
            $response = ["Message" => "Failed to Create booking"];
        }else{

            http_response_code(201);
            $response = ["Message" => "booking Created Successfully", "booking" => $booking->toArray()];
        }
    
    }

}else{
    http_response_code(400);
    $response = ["Message" => "Bad request, Wrong URL"];
}

echo json_encode($response);


