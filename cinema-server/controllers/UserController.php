<?php

require(__DIR__ . "/BaseController.php");
require(__DIR__ . "/../models/User.php");


class UserController extends BaseController
{

    public static function register()
    {
        global $conn;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!static::check_inputs($data)) {
                echo static::get_response("Bad request, please fill all the fields", "", 400);
                return;
            }

            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

            $user = User::create($conn, $data);
            if (!$user) {
                echo static::get_response("Failed to Create user", "", 500);
                return;
            }
            echo static::get_response("User Created Successfully", $user->toArray(), 201);
            return;
        }
        echo static::get_response("Bad request, Wrong URL", "", 400);
    }




    public static function login()
    {
        global $conn;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!static::check_inputs($data)) {
                echo static::get_response("Bad request, please fill all the fields", "", 400);
                return;
            }
            $user = User::login($conn, $data["email"]);
            if ($user && password_verify($data["password"], $user->getPassword())) {
                echo static::get_response("Logged in Successfully", $user->toArray(), 200);
                return;
            }
            echo static::get_response("User not found", "", 404);
            return;
        }
        echo static::get_response("Bad request, Wrong URL", "", 400);
    }


    public static function getUsers()
    {
        global $conn;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $user = User::find($conn, $id);
                if ($user) {
                    echo static::get_response("User with Id {$id} fetched successfully", $user->toArray(), 200);
                } else {
                    echo static::get_response("User with Id {$id} is not available in database.", "", 404);
                }
            } else {
                $users = User::all($conn);
                if ($users) {
                    $new_users = static::toArray($users);
                    echo static::get_response("All users are fetched successfully", $new_users, 200);
                } else {
                    echo static::get_response("No users in the database", "", 404);
                }
            }
        }else{

        echo static::get_response("Bad request, Wrong URL", "", 400);
        }
    }


    public static function updateUser()
    {
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            global $conn;
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data["id"];
            if (!$data || !isset($id)) {
                echo static::get_response("Bad request, ID is required", "", 400);
            }

            if ($data["password"]) {
                $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
            }

            $user = User::find($conn, $id);
            if (!$user) {
                echo static::get_response("User not found", "", 404);
            }

            $updated_user = $user->update($conn, $data);
            if ($updated_user) {
                echo static::get_response("User Updated Successfully.", $updated_user->toArray(), 200);
            } else {
                echo static::get_response("User failed to update.", "", 500);
            }
        } else {
            echo static::get_response("Bad request, wrong url", "", 400);
        }
    }


    public static function deleteUser()
    {
        global $conn;
        $response = [];

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $user = User::find($conn, $id);
                if (!$user) {
                    echo static::get_response("User with Id {$id} is not available in database.", "", 404);
                } else {

                    $deleted_user = $user->delete($conn, $id);
                    if ($deleted_user) {
                        echo static::get_response("User deleted successfully", "", 200);
                    } else {
                        echo static::get_response("Failed to deleted user", "", 500);
                    }
                }
            } else {
                echo static::get_response("ID is required", "", 404);
            }
        }
    }
}
