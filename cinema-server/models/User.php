<?php

require("Model.php");

class User extends Model{

    private string $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $phone_number;
    private string $password;
    private string $user_type;

    protected static string $table = "users";

    public function __construct(array $data){
        $this->id = $data["id"];
        $this->first_name = $data["first_name"];
        $this->last_name = $data["last_name"];
        $this->email = $data["email"];
        $this->phone_number = $data["phone_number"];
        $this->password = $data["password"];
        $this->user_type = $data["user_type"];
    }

    public function getID(){
        return $this->id;
    }

    public function getPassword(){
        return $this->password;
    }

    public function toArray(){
        return [$this->id, $this->first_name, $this->last_name, $this->email, $this->phone_number, $this->user_type];
    }

    public static function login(mysqli $mysqli, string $email){
        $sql = "SELECT * FROM users WHERE email=?";
        $query = $mysqli->prepare($sql);
        $query->bind_param("s", $email);
        if($query->execute()){
            $data = $query->get_result()->fetch_assoc();
            return $data ? new User($data) : null;
        }else{
            return null;
        }
    }

}