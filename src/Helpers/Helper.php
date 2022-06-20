<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

class Helper
{
    public function test()
    {
        return 'It Works!';
    }

    public function percentCalc($valor, $total){
        return number_format(( $valor * 100 ) / $total, 2, '.', ',');
    }

    public function to_array($object)
    {
        $array = $object;
        
        if (is_object($object)) {
            $array = (array)get_object_vars($object);
        }
        
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                if (is_object($value)) {
                    $array[$key] = self::to_array($value);
                }
            }
        }
        
        return is_array($array) ? array_filter($array) : [];
    }
}