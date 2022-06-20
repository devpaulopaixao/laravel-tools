<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

class Validation
{

    protected $moment;

    public function __construct()
    {}

    public function noRepeat($string)
    {
        $first  = substr($string, 0, 1);
        $repeat = str_repeat($first, mb_strlen($string));

        return $string === $repeat ? false : true;
    }

    public function month($value)
    {
        if(is_numeric($value) && ctype_digit($value))
        {
            return $value >= 1 && $value <= 12;
        }
        else
        {
            return false;
        }
    }

    public function year($value)
    {
        return array_key_exists($value, \Moment::listYear());
    }

    public function cpf($value)
    {
        $value = numeric()->filterNumber($value);

        if (strlen($value) != 11)
        {
            return false;
        }

        if($value == str_repeat($value[0], 11))
        {
            return false;
        }

        for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--)
        {
            $sum += $value{$i} * $j;
        }

        $rest = $sum % 11;

        if ($value{9} != ($rest < 2 ? 0 : 11 - $rest))
        {
            return false;
        }

        for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--)
        {
            $sum += $value{$i} * $j;
        }

        $rest = $sum % 11;

        return $value{10} == ($rest < 2 ? 0 : 11 - $rest);
    }

    public function cnpj($value)
    {
        $value = numeric()->filterNumber($value);

        if (strlen($value) != 14)
        {
            return false;
        }

        if($value == str_repeat($value[0], 14))
        {
            return false;
        }

        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++)
        {
            $sum += $value{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($value{12} != ($rest < 2 ? 0 : 11 - $rest))
        {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++)
        {
            $sum += $value{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $value{13} == ($rest < 2 ? 0 : 11 - $rest);
    }

}