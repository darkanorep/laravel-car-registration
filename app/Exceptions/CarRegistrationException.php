<?php

namespace App\Exceptions;

use Exception;

class CarRegistrationException extends Exception
{
    //Car Exceptions
    public static function carNotFound($id) {
        return new static("Car model not found by id: $id", 404);
    }

    //Car Model Exceptions
    public static function carModelNotFound($id) {
        return new static("Car not found by id: $id", 404);
    }

    //Auth Exception
    public static function authError() {
        return new static("Invalid Credentials", 401);
    }

    //Role Exception
    public static function validateRole($array, $data) {
        if (!in_array($data, $array)) {
            return new static("Invalid Role.", 400);
        }
    }
        
}
