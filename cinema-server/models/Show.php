<?php

require("Model.php");

class Show extends Model{

    private int $id;
    private int $movie_id;
    private string $start_time;
    private string $hall;

    protected static string $table = "shows";

    public function __construct(array $data)
    {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

    public function toArray(){
        return ["id" => $this->id, "movie_id" => $this->movie_id, "start_time" => $this->start_time, "hall" => $this->hall];
    }

    public static function movieShows(mysqli $mysqli, int $id){
        $sql = "SELECT * FROM shows WHERE movie_id=?";

        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        if($query->execute()){
            $data = [];
            $result = $query->get_result();
            while($row = $result->fetch_assoc()){
                array_push($data, new Show($row));
            }
            return $data;
        }else{
            return null;
        }
    }

}