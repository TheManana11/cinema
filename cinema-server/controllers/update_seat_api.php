<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Seat.php");

header("Content-Type: application/json");


$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    if(!$data || !isset($id)){
        http_response_code(400);
        $response = ["Message" => "Bad Request, ID is required"];
    }

    $seat = Seat::find($conn, $id);
    if(!$seat){
        http_response_code(404);
        $response = ["Message" => "seat not found."];
    }

    $updated_seat = $seat->update($conn, $data);
    if($updated_seat){
        http_response_code(200);
        $response = ["Message" => "seat Updated Successfully.", "updated_seat" => $updated_seat->toArray()];
    }else{
        http_response_code(500);
        $response = ["Message" => "User failed to update."];
    }
}else{
    http_response_code(400);
    $response = ["Message" => "Bad Request, Wrong URL"];
}

echo json_encode($response);