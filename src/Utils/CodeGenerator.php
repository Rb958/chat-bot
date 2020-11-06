<?php


namespace App\Utils;


class CodeGenerator
{

    public static function generateNumericCode(int $length = 12){
        $char = "0123456789";
        $code = "";

        for ($i = 0; $i < $length; $i++){
            $code .= str_shuffle($char)[0];
        }
        return $code;
    }

    public static function generateStringCode(int $length = 12, $uppercase = true){
        $char = "abcdefghijklmnopqrstuvwxyz";
        $code = "";

        for ($i = 0; $i < $length; $i++){
            $code .= str_shuffle($char)[0];
        }
        return ($uppercase) ? strtoupper($code) : strtolower($code);
    }
}