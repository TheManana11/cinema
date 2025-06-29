<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Seat.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $seat = Seat::find($conn, $id);
        if ($seat) {
            http_response_code(200);
            $response = ["message" => "seat with Id {$id} fetched successfully", "seat" => $seat->toArray()];
        } else {
            http_response_code(404);
            $response = ["message" => "seat with Id {$id} is not available in database."];
        }
    } else {
        $seats = seat::all($conn);
        if ($seats) {
            http_response_code(200);
            $response = ["message" => "All seats are fetched successfully", "seats" => []];
            foreach ($seats as $seat) {
                $response["seats"][] = $seat->toArray();
            }
        }else{
            http_response_code(404);
            $response = ["message" => "No seats in the database."];
        }
    }
    echo json_encode($response);
    return;
}

http_response_code(400);
$response = ["message" => "Bad request, wrong URL"];
echo json_encode($response);