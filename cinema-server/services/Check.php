<?php

class Check{

    public static function check_inputs($data){
        $keys = array_keys($data);
        $flag = true;
        foreach($keys as $key){
            if (empty($data[$key])) $flag = false;
        }
        return $flag;
    }
}