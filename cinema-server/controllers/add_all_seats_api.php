<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Seat.php");

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $show_id = json_decode(file_get_contents("php://input"), true);
    // $show_id = $data["show_id"];

    if(empty($show_id)){
        http_response_code(400);
        $response = ["Message" => "Fill all the fields"];
    }else{
        $seats = Seat::create_all($conn, $show_id);
        if($seats){
            http_response_code(201);
            $response = ["Message" => "Seats Created successfully"];
        }else{
            http_response_code(400);
            $response = ["Message" => "Fails to create seats"];
        }
    }
}else{
    http_response_code(400);
    $response = ["Message" => "Bad request, wrong url"];
}

echo json_encode($response);