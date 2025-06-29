<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Show.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $show = Show::find($conn, $id);
        if ($show) {
            http_response_code(200);
            $response = ["message" => "Show with Id {$id} fetched successfully", "Show" => $show->toArray()];
        } else {
            http_response_code(404);
            $response = ["message" => "Show with Id {$id} is not available in database."];
        }
    } else {
        $shows = Show::all($conn);
        if ($shows) {
            http_response_code(200);
            $response = ["message" => "All Shows are fetched successfully", "shows" => []];
            foreach ($shows as $show) {
                $response["shows"][] = $show->toArray();
            }
        }else{
            http_response_code(404);
            $response = ["message" => "No Shows in the database."];
        }
    }
    echo json_encode($response);
    return;
}

http_response_code(400);
$response = ["message" => "Bad request, wrong URL"];
echo json_encode($response);