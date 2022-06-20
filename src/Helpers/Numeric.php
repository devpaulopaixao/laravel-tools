<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

class Numeric
{

    public function formatMoney($value)
    {
        return 'R$ '.number_format($value, 2, ',', '.');
    }

    public function stripGroup($value)
    {
        if(is_numeric($value))
        {
            return $value;
        }
        else
        {
            if(mb_substr_count($value, ','))
            {
                $clean = preg_replace('/[^\d|,]/', '', $value);

                return preg_replace('/,/', '.', $clean);
            }
            else
            {
                return preg_replace('/[^\d]/', '', $value);
            }
        }
    }

    public function dafaultPhoneToLocal($phone)
    {
        if(mb_strlen($phone) == 10)
        {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
        }
        else
        {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        }
    }

    public function filterNumber($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    public function stringToMoney($string)
    {
        $stringTrim   = trim($string);
        $stringDots   = preg_replace('/\./', '', $stringTrim);
        $stringCommas = preg_replace('/,/', '.', $stringDots);

        return $stringCommas;
    }

    public function priceOnlyNumbers($price){
        return number_format($price, 2, '', '');
    }

    public function percentCalc($valor, $total, $decimal = '.'){
       return number_format(( $valor * 100 ) / $total, 2, $decimal, '.');
    }

}