<?php

require("Model.php");

class Seat extends Model{

    private int $id;
    private int $show_id;
    private string $row;
    private int $number;
    private bool $is_booked;

    protected static string $table = "seats";

    public function __construct(array $data)
    {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

    public static function create_all(mysqli $mysqli, int $show_id){
        $sql = "INSERT INTO seats (show_id, row, number) VALUES (?,?,?)";
        $query = $mysqli->prepare($sql);

        $flag = true;

        $chars = ['A', 'B', 'C','D', 'E', 'F'];
        foreach($chars as $char){
            for($j = 1; $j <= 10; $j++){
                $query->bind_param("isi", $show_id, $char, $j);
                if(!$query->execute()){
                    $flag = false;
                    break;
                }
            }
            if(!$flag) break;
        }
        return $flag;
    }


     public static function get_all(mysqli $mysqli, int $show_id){
        $sql = "SELECT * FROM seats WHERE show_id=?";
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $show_id);

        $seats = [];
        if($query->execute()){
            $result = $query->get_result();
            while($row = $result->fetch_assoc()){
                array_push($seats, new Seat($row));
            }
            return $seats;
        }else{
            return null;
        }
    }


    public static function update_all(mysqli $mysqli, array $seat_ids){
        $sql = "UPDATE seats SET is_booked=? WHERE id=?";
        $query = $mysqli->prepare($sql);

        $flag = true;
        foreach($seat_ids as $id){
            $is_booked = 1;
            $query->bind_param("ii", $is_booked, $id);
            if(!$query->execute()){
                $flag = false;
                break;
            }
        }
        return $flag;
    }

    public function toArray(){
        return ["id" => $this->id, "show_id" => $this->show_id, "row" => $this->row, "number" => $this->number, "is_booked" => $this->is_booked];
    }


}