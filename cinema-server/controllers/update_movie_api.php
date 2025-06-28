<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Movie.php");

header("Content-Type: application/json");


$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    if(!$data || !isset($id)){
        http_response_code(400);
        $response = ["Message" => "Bad Request, ID is required"];
    }

    $movie = Movie::find($conn, $id);
    if(!$movie){
        http_response_code(404);
        $response = ["Message" => "Movie not found."];
    }

    $updated_movie = $movie->update($conn, $data);
    if($updated_movie){
        http_response_code(200);
        $response = ["Message" => "Movie Updated Successfully.", "updated_movie" => $updated_movie->toArray()];
    }else{
        http_response_code(500);
        $response = ["Message" => "User failed to update."];
    }
}else{
    http_response_code(400);
    $response = ["Message" => "Bad Request, Wrong URL"];
}

echo json_encode($response);