<?php

require("Model.php");

class Movie extends Model{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $rating;
    private string $release_date;
    private string $image;
    private string $duration;
    private string $language;
    private string $genre;


    protected static string $table = "movies";

    public function __construct(array $data)
    {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

    public function toArray(){
        return ["id" => $this->id, "name" => $this->name, "description" => $this->description, "price" => $this->price, "rating" => $this->rating, "release_date" => $this->release_date, "image" => $this->image, "duration" => $this->duration, "language" => $this->language, "genre" => $this->genre];
    }
}