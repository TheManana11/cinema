<?php

require("Model.php");

class Booking extends Model
{

    private int $id;
    private int $user_id;
    private int $movie_id;
    private int $show_id;
    private int $seat_id;


    protected static string $table = "bookings";

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }


    public static function get_booking_details(mysqli $mysqli, int $user_id) {
    $sql = " SELECT users.first_name,
                    users.last_name,
                    movies.name AS movie_name,
                    shows.start_time,
                    shows.hall,
                    seats.row,
                    seats.number AS seat_number
            FROM bookings
            JOIN users ON bookings.user_id = users.id
            JOIN movies ON bookings.movie_id = movies.id
            JOIN shows ON bookings.show_id = shows.id
            JOIN seats ON bookings.seat_id = seats.id
            WHERE bookings.user_id = ?
    ";

    $query = $mysqli->prepare($sql);
    $query->bind_param("i", $user_id);
      $data = [];
    if($query->execute()){

      
        $result = $query->get_result();
        while($row = $result->fetch_assoc()){
            $data[] = (object) $row;
        }
        return $data;
    }else{
        return null;
    }
        

}


    

    public function toArray()
    {
        return ["id" => $this->id, "user_id" => $this->user_id, "movie_id" => $this->movie_id, "show_id" => $this->show_id, "seat_id" => $this->seat_id];
    }
}
