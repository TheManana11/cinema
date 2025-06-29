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

    public function toArray(){
        return ["id" => $this->id, "show_id" => $this->show_id, "row" => $this->row, "number" => $this->number, "is_booked" => $this->is_booked];
    }


}