<?php 

class Response{

    public static function get_response($message, $data = "", $status){
        http_response_code($status);
        $response["message"] = $message;
        if($data != "") $response["data"] = $data;
        return json_encode($response);
    }
}