<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Show.php");

header('Content-Type: application/json');

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if(empty($data["movie_id"]) || empty($data["start_time"]) || empty($data["hall"])){
        http_response_code(400);
        $response = ["Message" => "Bad request, please fill all the fields"];
    }else{
        $show = Show::create($conn, $data);
        if(!$show){
            http_response_code(500);
            $response = ["Message" => "Failed to Create show"];
        }else{
            http_response_code(201);
            $response = ["Message" => "Show Created Successfully", "show" => $show->toArray()];
        }
    
    }

}else{
    http_response_code(400);
    $response = ["Message" => "Bad request, Wrong URL"];
}

echo json_encode($response);