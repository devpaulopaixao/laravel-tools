<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

class Mask
{
    //CNPJ Mask("##.###.###/####-##",$cnpj)
    //CPF Mask("###.###.###-##",$cpf)
    //CEP Mask("#####-###",$cep)
    //TELEFONE Mask("(##)####-####",$telefone)
    //DATA Mask("##/##/####",$data)
    public function transform($mask, $str)
    {
        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;
    }

    public function shift($string, $limit,$char = "*"){

        $str = "";

        $string = str_split($string);

        foreach ($string as $key => $value) {
            if($key <= $limit){
                $str = $str . $char;
            }else{
                $str = $str . $value;
            }
        }

        return $str;
    }
}
