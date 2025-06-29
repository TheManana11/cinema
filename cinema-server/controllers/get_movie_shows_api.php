<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Show.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["movie_id"])) {
        $id = $_GET["movie_id"];
        $shows = Show::movieShows($conn, $id);
        if ($shows) {
            http_response_code(200);
            $response = ["message" => "All Shows for movie of {$id} are fetched successfully", "shows" => []];
            foreach ($shows as $show) {
                $response["shows"][] = $show->toArray();
            }
        }else{
            http_response_code(404);
            $response = ["message" => "No Shows for this movie in the database."];
        }
    }else{
        http_response_code(400);
            $response = ["message" => "Bad Request, Movie Id is required."];
    }
    echo json_encode($response);
    return;
}

http_response_code(400);
$response = ["message" => "Bad request, wrong URL"];
echo json_encode($response);