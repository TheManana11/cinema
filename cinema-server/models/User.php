<?php

require("../connection/connection.php");

class User
{
    private $connection;

    function __construct()
    {
        global $conn;
        $this->connection = $conn;
    }

    function getAllUsers()
    {
        $users = [];
        $sql_query = "SELECT id, first_name, last_name, email, phone_number, user_type FROM users";

        $stmt = $this->connection->prepare($sql_query);
        if ($stmt->execute()) {;
            $result = $stmt->get_result();

            while ($record = $result->fetch_assoc()) {
                array_push($users, $record);
            }
            $stmt->close();
            return $users;
        } else {
            return false;
        }
    }

    function addUser($first_name, $last_name, $email, $phone_number, $password)
    {
        $sql_query = "INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES(?,?,?,?,?)";
        $stmt = $this->connection->prepare($sql_query);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone_number, $hashed_password);
        if ($stmt->execute()) {
            return true;
            $stmt->close();
        } else {
            return false;
        }
    }
}
