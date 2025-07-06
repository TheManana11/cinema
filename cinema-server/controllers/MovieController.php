<?php

require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../models/Movie.php");

class MovieController
{

    public static function addMovie()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data["name"]) || empty($data["description"]) || empty($data["price"]) || empty($data["rating"]) || empty($data["release_date"]) || empty($data["image"]) || empty($data["duration"]) || empty($data["language"])) {
                http_response_code(400);
                $response = ["Message" => "Bad request, please fill all the fields"];
            } else {

                $movie = Movie::create($conn, $data);
                if (!$movie) {
                    http_response_code(500);
                    $response = ["Message" => "Failed to Create Movie"];
                } else {

                    http_response_code(201);
                    $response = ["Message" => "Movie Created Successfully", "movie" => $movie->toArray()];
                }
            }
        } else {
            http_response_code(400);
            $response = ["Message" => "Bad request, Wrong URL"];
        }

        echo json_encode($response);
    }

    public static function getMovies()
    {
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            global $conn;
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
                } else {
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
    }

    public static function updateMovie()
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

            $movie = Movie::find($conn, $id);
            if (!$movie) {
                http_response_code(404);
                $response = ["Message" => "Movie not found."];
            }

            $updated_movie = $movie->update($conn, $data);
            if ($updated_movie) {
                http_response_code(200);
                $response = ["Message" => "Movie Updated Successfully.", "updated_movie" => $updated_movie->toArray()];
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


    public static function deleteMovie()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $movie = Movie::find($conn, $id);
                if (!$movie) {
                    http_response_code(404);
                    $response = ["message" => "User with Id {$id} is not available in database."];
                } else {

                    $is_deleted = $movie->delete($conn, $id);
                    if ($is_deleted) {
                        http_response_code(200);
                        $response = ["Message" => "Movie deleted successfully"];
                    } else {
                        http_response_code(200);
                        $response = ["Message" => "Failed to deleted movie"];
                    }
                }
            } else {
                $response = ["status" => 404, "message" => "ID is required"];
            }
        }

        echo json_encode($response);
    }
}
