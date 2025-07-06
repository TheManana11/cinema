<?php

require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../models/Booking.php");


class BookingController
{


    public static function getBookings()
    {
        global $conn;

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
                } else {
                    http_response_code(404);
                    $response = ["message" => "No bookings for this movie in the database."];
                }
            } else {
                http_response_code(400);
                $response = ["message" => "Bad Request, Movie Id is required."];
            }
            echo json_encode($response);
            return;
        }

        http_response_code(400);
        $response = ["message" => "Bad request, wrong URL"];
        echo json_encode($response);
    }


    
    public static function addBooking()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data["user_id"]) || empty($data["movie_id"]) || empty($data["show_id"]) || empty($data["seat_id"])) {
                http_response_code(400);
                $response = ["Message" => "Bad request, please fill all the fields"];
            } else {

                $booking = Booking::create($conn, $data);
                if (!$booking) {
                    http_response_code(500);
                    $response = ["Message" => "Failed to Create booking"];
                } else {

                    http_response_code(201);
                    $response = ["Message" => "booking Created Successfully", "booking" => $booking->toArray()];
                }
            }
        } else {
            http_response_code(400);
            $response = ["Message" => "Bad request, Wrong URL"];
        }

        echo json_encode($response);
    }
}
