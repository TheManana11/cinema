<?php

require("../connection/connection.php");
require("../models/User.php");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $user = User::find($conn, $id);
        if ($user) {
            $response = ["status" => 200, "message" => "User with Id {$id} fetched successfully", "user" => $user->toArray()];
        } else {
            $response = ["status" => 404, "message" => "User with Id {$id} is not available in database."];
        }
    } else {
        $users = User::all($conn);
        if ($users) {
            $response = ["status" => 200, "message" => "All User are fetched successfully", "users" => []];
            foreach ($users as $user) {
                $response["users"][] = $user->toArray();
            }
        }else{
            $response = ["status" => 404, "message" => "No Users in the database."];
        }
    }
    echo json_encode($response);
    return;
}

$response = ["status" => 404, "message" => "Bad request, wrong URL"];
echo json_encode($response);