<?php

class ToArray{

    public static function toArray($data){
        $new_data = [];

        foreach($data as $d){
            $new_data[] = $d->toArray();
        }
        return $new_data;
    }
}