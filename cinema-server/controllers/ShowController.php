<?php

require(__DIR__ . "/BaseController.php");
require(__DIR__ . "/../models/Show.php");

class ShowController extends BaseController
{

    public static function getShows()
    {
        global $conn;
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
                } else {
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
    }


    public static function getMovieShows()
    {
        global $conn;
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
                } else {
                    http_response_code(404);
                    $response = ["message" => "No Shows for this movie in the database."];
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

    public static function addShow()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data["movie_id"]) || empty($data["start_time"]) || empty($data["hall"])) {
                http_response_code(400);
                $response = ["Message" => "Bad request, please fill all the fields"];
            } else {
                $show = Show::create($conn, $data);
                if (!$show) {
                    http_response_code(500);
                    $response = ["Message" => "Failed to Create show"];
                } else {
                    http_response_code(201);
                    $response = ["Message" => "Show Created Successfully", "show" => $show->toArray()];
                }
            }
        } else {
            http_response_code(400);
            $response = ["Message" => "Bad request, Wrong URL"];
        }

        echo json_encode($response);
    }



    public static function updateShow()
    {
        global $conn;

        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data["id"];
            if (!$data || !isset($id)) {
                http_response_code(400);
                $response = ["Message" => "Bad Request, ID is required"];
            }

            $show = Show::find($conn, $id);
            if (!$show) {
                http_response_code(404);
                $response = ["Message" => "show not found."];
            }

            $updated_show = $show->update($conn, $data);
            if ($updated_show) {
                http_response_code(200);
                $response = ["Message" => "show Updated Successfully.", "updated_show" => $updated_show->toArray()];
            } else {
                http_response_code(500);
                $response = ["Message" => "User failed to update."];
            }
        } else {
            http_response_code(400);
            $response = ["Message" => "Bad Request, Wrong URL"];
        }

        echo json_encode($response);
    }



    public static function deleteShow()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $show = Show::find($conn, $id);
                if (!$show) {
                    http_response_code(404);
                    $response = ["message" => "User with Id {$id} is not available in database."];
                } else {

                    $is_deleted = $show->delete($conn, $id);
                    if ($is_deleted) {
                        http_response_code(200);
                        $response = ["Message" => "show deleted successfully"];
                    } else {
                        http_response_code(200);
                        $response = ["Message" => "Failed to deleted show"];
                    }
                }
            } else {
                $response = ["status" => 404, "message" => "ID is required"];
            }
        }

        echo json_encode($response);
    }
}
