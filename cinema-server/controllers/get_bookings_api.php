<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Booking.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["user_id"])) {
        $id = $_GET["user_id"];
        $bookings = Booking::get_booking_details($conn, $id);
        if ($bookings) {
            http_response_code(200);
            $response = ["message" => "All bookings for user of {$id} are fetched successfully", "bookings" => []];
            foreach ($bookings as $booking) {
                $response["bookings"][] = $booking;
            }
        }else{
            http_response_code(404);
            $response = ["message" => "No bookings for this movie in the database."];
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