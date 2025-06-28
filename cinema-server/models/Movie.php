<?php

require("Model.php");

class Movie extends Model{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $rating;
    private string $release_date;

    protected static string $table = "movies";

    public function __construct(array $data)
    {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }
}