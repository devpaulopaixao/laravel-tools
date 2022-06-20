<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

class Text
{

    public function assistantAll()
    {
        return ['a', 'e', 'i', 'o', 'u', 'com', 'da', 'de', 'di', 'do', 'du', 'das', 'des', 'dis', 'dos', 'dus'];
    }

    public function assistantCheck($string)
    {
        return in_array( mb_strtolower($string), $this->assistantAll());
    }

    public function trimAll($string)
    {
        $clear = trim($string);

        if($clear)
        {
            $split  = explode(' ', $clear);
            $trim   = array_map(function($item) {return trim($item);}, $split);
            $filter = array_filter($trim);

            return implode(' ', $filter);
        }
        else
        {
            return $clear;
        }
    }

    public function upperFirst($string)
    {
        $trimUnit    = trim($string);
        $lowerCase   = mb_strtolower($trimUnit);
        $letterFirst = mb_strtoupper(mb_substr($lowerCase, 0, 1));
        $letterRest  = mb_substr($lowerCase, 1);



        return $letterFirst.$letterRest;
    }

    public function capitalizeFull($string)
    {
        $trimAll = $this->trimAll($string);

        if($trimAll)
        {
            $lowerCase = mb_strtolower($trimAll);
            $splitAll  = explode(' ', $lowerCase);

            foreach($splitAll as $splitKey => $splitUnit)
            {
                if($splitKey)
                {
                    if($this->assistantCheck($splitUnit))
                    {
                        $splitAll[$splitKey] = mb_strtolower($splitUnit);
                    }
                    else
                    {
                        $splitAll[$splitKey] = $this->upperFirst($splitUnit);
                    }
                }
                else
                {
                    $splitAll[$splitKey] = $this->upperFirst($splitUnit);
                }
            }

            return implode(' ', $splitAll);
        }
        else
        {
            return $trimAll;
        }
    }

    public function cutName($string)
    {
        $trim  = $this->trimAll($string);

        if($trim)
        {
            $split = explode(' ', $trim);

            if(count($split) > 1)
            {
                if(count($split) == 2)
                {
                    return $trim;
                }
                else
                {
                    if($this->assistantCheck($split[1]))
                    {
                        return $split[0].' '.$split[1].' '.$split[2];
                    }
                    else
                    {
                        return $split[0].' '.$split[1];
                    }
                }
            }
            else
            {
                return $trim;
            }
        }
        else
        {
            return null;
        }
    }

    public function getAbbreviation($string)
    {
        $stringTrim = $this->trimAll($string);

        if(!empty($stringTrim))
        {
            $stringSplit        = explode(' ', $stringTrim);
            $stringAbbreviation = null;

            foreach($stringSplit as $stringWord)
            {
                $stringAbbreviation .= mb_substr($stringWord, 0, 1);
            }

            return $stringAbbreviation;
        }
        else
        {
            return null;
        }
    }

    function upperStart($string)
    {
        $str = $this->trimAll($string);

        return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
    }

}