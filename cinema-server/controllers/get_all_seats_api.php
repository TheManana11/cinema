<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Seat.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["show_id"])) {
        $id = $_GET["show_id"];
        $seats = Seat::get_all($conn, $id);
        if ($seats) {
            http_response_code(200);
            $response = ["message" => "All seats for show of {$id} are fetched successfully", "seats" => []];
            foreach ($seats as $seat) {
                $response["seats"][] = $seat->toArray();
            }
        }else{
            http_response_code(404);
            $response = ["message" => "No seats for this movie in the database."];
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