<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Movie.php");

header('Content-Type: application/json');

$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if(empty($data["name"]) || empty($data["description"]) || empty($data["price"]) || empty($data["rating"]) || empty($data["release_date"]) || empty($data["image"]) || empty($data["duration"]) || empty($data["language"])){
        http_response_code(400);
        $response = ["Message" => "Bad request, please fill all the fields"];
    }else{

        $movie = Movie::create($conn, $data);
        if(!$movie){
            http_response_code(500);
            $response = ["Message" => "Failed to Create Movie"];
        }else{

            http_response_code(201);
            $response = ["Message" => "Movie Created Successfully", "movie" => $movie->toArray()];
        }
    
    }

}else{
    http_response_code(400);
    $response = ["Message" => "Bad request, Wrong URL"];
}

echo json_encode($response);