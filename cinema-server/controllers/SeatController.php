<?php

require(__DIR__ . "/BaseController.php");
require(__DIR__ . "/../models/Seat.php");

class SeatController extends BaseController
{

    public static function getSeats()
    {
        global $conn;

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
                if (isset($_GET["show_id"])) {

                    $seats = seat::get_all($conn, $_GET["show_id"]);
                    if ($seats) {
                        http_response_code(200);
                        $response = ["message" => "All seats are fetched successfully", "seats" => []];
                        foreach ($seats as $seat) {
                            $response["seats"][] = $seat->toArray();
                        }
                    } else {
                        http_response_code(404);
                        $response = ["message" => "No seats in the database."];
                    }
                }
            }
            echo json_encode($response);
            return;
        }

        http_response_code(400);
        $response = ["message" => "Bad request, wrong URL"];
        echo json_encode($response);
    }


    public static function addAllSeats()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $show_id = json_decode(file_get_contents("php://input"), true);
            // $show_id = $data["show_id"];

            if (empty($show_id)) {
                http_response_code(400);
                $response = ["Message" => "Fill all the fields"];
            } else {
                $seats = Seat::create_all($conn, $show_id);
                if ($seats) {
                    http_response_code(201);
                    $response = ["Message" => "Seats Created successfully"];
                } else {
                    http_response_code(400);
                    $response = ["Message" => "Fails to create seats"];
                }
            }
        } else {
            http_response_code(400);
            $response = ["Message" => "Bad request, wrong url"];
        }

        echo json_encode($response);
    }


    // public static function addSeat()
    // {
    //     global $conn;

    //     $response = [];

    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $data = json_decode(file_get_contents("php://input"), true);

    //         if (empty($data["show_id"]) || empty($data["row"]) || empty($data["number"])) {
    //             http_response_code(400);
    //             $response = ["Message" => "Bad request, please fill all the fields"];
    //         } else {

    //             $seat = Seat::create($conn, $data);
    //             if (!$seat) {
    //                 http_response_code(500);
    //                 $response = ["Message" => "Failed to Create seat"];
    //             } else {

    //                 http_response_code(201);
    //                 $response = ["Message" => "seat Created Successfully", "seat" => $seat->toArray()];
    //             }
    //         }
    //     } else {
    //         http_response_code(400);
    //         $response = ["Message" => "Bad request, Wrong URL"];
    //     }

    //     echo json_encode($response);
    // }


    public static function updateSeat()
    {
        global $conn;

        $response = [];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = json_decode(file_get_contents("php://input"), true);

                $seat = Seat::update_all($conn, $data);
                if (!$seat) {
                    http_response_code(404);
                    $response = ["Message" => "seats not found."];
                } else {
                    http_response_code(200);
                    $response = ["Message" => "seats updated successfully."];
                }
            } else {
                http_response_code(400);
                $response = ["Message" => "Bad Request, Wrong URL"];
            }

            echo json_encode($response);
        }



    public static function deleteSeat()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $seat = Seat::find($conn, $id);
                if (!$seat) {
                    http_response_code(404);
                    $response = ["message" => "User with Id {$id} is not available in database."];
                } else {

                    $is_deleted = $seat->delete($conn, $id);
                    if ($is_deleted) {
                        http_response_code(200);
                        $response = ["Message" => "seat deleted successfully"];
                    } else {
                        http_response_code(200);
                        $response = ["Message" => "Failed to deleted seat"];
                    }
                }
            } else {
                $response = ["status" => 404, "message" => "ID is required"];
            }
        }

        echo json_encode($response);
    }
}
