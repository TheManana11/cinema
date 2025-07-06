<?php 

require(__DIR__ . "/../middleware/cors.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/Response.php");
require(__DIR__ . "/../services/Check.php");
require(__DIR__ . "/../services/ToArray.php");


abstract class BaseController{

    protected $conn;

    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }

    protected static function get_response($message, $data, $status_code){
        return Response::get_response($message, $data, $status_code);
    }

    protected static function check_inputs($data){
        return Check::check_inputs($data); 
    }

     protected static function toArray($data){
        return ToArray::toArray($data); 
    }
}