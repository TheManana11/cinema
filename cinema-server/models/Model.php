<?php

use function PHPSTORM_META\map;

class Model{

    protected static string $table;
    protected string $id;
    protected static string $primary_key = "id";
    

    // getting a single record based on d=id from a table
    public static function find(mysqli $mysqli, int $id){
        $sql = sprintf("SELECT * FROM %s WHERE %s= ?", static::$table, static::$primary_key);
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        if($query->execute()){
            $data = $query->get_result()->fetch_assoc();
            return $data ? new static($data) : null;
        }else{
            return null;
        }
    }


    // getting all records from a table
    public static function all(mysqli $mysqli){
        $sql = sprintf("SELECT * FROM %s", static::$table);
        $query = $mysqli->prepare($sql);
        if($query->execute()){
            $result = $query->get_result();
            $data = [];
            while($row = $result->fetch_assoc()){
                $data[] = new static($row);
            }
            return $data;
        }else{
            return null;
        }
    }


    // creating dynamic class
    public static function create(mysqli $mysqli, array $data){
        $keys = array_keys($data);  // this will return an array of the keys
        $attributes = implode(', ', $keys);  // this will make the array values as a string separated with comma

        $keys_count = count($keys);  // return the number of attributes
        $placeholders = implode(", ", array_fill(0, $keys_count, "?"));  // return an array of ? of number of attributes, then make it as a string

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", static::$table, $attributes, $placeholders);
        $query = $mysqli->prepare($sql);

        $values = array_values($data);
        $binding = "";
        for($i = 0; $i < count($values); $i++){
            if(is_string($values[$i])) $binding .= "s";
            elseif(is_int($values[$i])) $binding .= "i";
            elseif(is_double($values[$i])) $binding .= "d";
            else $binding .= "b";
        }

        $query->bind_param($binding, ...$values);

        if($query->execute()){
            $user_id = $mysqli->insert_id; // getting the last element's in the database which is created now
            $user = static::find($mysqli, $user_id); // getting the created user
            return $user;
        }else{
            return null;
        }
    }

    // updating an existing user
    public function update(mysqli $mysqli, array $data){

        $id = $data["id"];
        array_shift($data);

        $keys = array_keys($data);
        $values = array_values($data);

        $stmt_arr = [];
        foreach($keys as $key){
            array_push($stmt_arr, "{$key}=?");
        }

        $stmt_str = implode(", ", $stmt_arr);  // make the array as a string like "first_name=?, last_name=? ....."


        $sql = sprintf("UPDATE %s SET %s WHERE %s=?", static::$table, $stmt_str, static::$primary_key);
        $query = $mysqli->prepare($sql);

       
        $binding = "";
        for($i = 0; $i < count($values); $i++){
            if(is_string($values[$i])) $binding .= "s";
            elseif(is_int($values[$i])) $binding .= "i";
            elseif(is_double($values[$i])) $binding .= "d";
            else $binding .= "b";
        }
        array_push($values, $id);  // these 2 lines is for adding the binding of the id
        $binding .= "i";
        $query->bind_param($binding, ...$values);
        
        if($query->execute()){
            $user = static::find($mysqli, $id);
            return $user ? $user : null;
        }else{
            return null;
        }
    }
}