<?php

require("../middleware/cors.php");
require("../connection/connection.php");
require("../models/Show.php");

header("Content-Type: application/json");


$response = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"];
    if(!$data || !isset($id)){
        http_response_code(400);
        $response = ["Message" => "Bad Request, ID is required"];
    }

    $show = Show::find($conn, $id);
    if(!$show){
        http_response_code(404);
        $response = ["Message" => "show not found."];
    }

    $updated_show = $show->update($conn, $data);
    if($updated_show){
        http_response_code(200);
        $response = ["Message" => "show Updated Successfully.", "updated_show" => $updated_show->toArray()];
    }else{
        http_response_code(500);
        $response = ["Message" => "User failed to update."];
    }
}else{
    http_response_code(400);
    $response = ["Message" => "Bad Request, Wrong URL"];
}

echo json_encode($response);