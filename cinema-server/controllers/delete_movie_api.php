<?php

require("../connection/connection.php");
require("../models/Movie.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $movie = Movie::find($conn, $id);
        if (!$movie) {
            http_response_code(404);
            $response = ["message" => "User with Id {$id} is not available in database."];
        } else{

            $is_deleted = $movie->delete($conn, $id);
            if($is_deleted){
                http_response_code(200);
                $response = ["Message" => "Movie deleted successfully"];
            }else{
                http_response_code(200);
                $response = ["Message" => "Failed to deleted movie"];
            }
        }
    }else{ 
       $response = ["status" => 404, "message" => "ID is required"];
    }
}

echo json_encode($response);