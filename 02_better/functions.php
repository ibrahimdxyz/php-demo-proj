<?php
/**
 * generates a random string with a given length
 * @param $n : string length
 * @return string $str
 */
function randomString(int $n): string
{
    $characters = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = '';
    for ($i=0; $i<$n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

