<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Movie.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $movie = Movie::find($conn, $id);
        if ($movie) {
            http_response_code(200);
            $response = ["message" => "Movie with Id {$id} fetched successfully", "movie" => $movie->toArray()];
        } else {
            http_response_code(404);
            $response = ["message" => "Movie with Id {$id} is not available in database."];
        }
    } else {
        $movies = Movie::all($conn);
        if ($movies) {
            http_response_code(200);
            $response = ["message" => "All Movies are fetched successfully", "movies" => []];
            foreach ($movies as $movie) {
                $response["movies"][] = $movie->toArray();
            }
        }else{
            http_response_code(404);
            $response = ["message" => "No Movies in the database."];
        }
    }
    echo json_encode($response);
    return;
}

http_response_code(400);
$response = ["message" => "Bad request, wrong URL"];
echo json_encode($response);