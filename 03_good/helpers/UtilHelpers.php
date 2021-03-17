<?php


namespace app\helpers;


class UtilHelpers
{

    public static function randomString(int $n): string
    {
        $characters = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = '';
        for ($i=0; $i<$n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }

        return $str;
    }

}