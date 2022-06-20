<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

use Carbon\Carbon;

class Moment extends Carbon
{

    public function greeting()
    {
        $hour = date('H:i');

        switch ($hour)
        {
            case strtotime($hour) >= strtotime('00:00') && strtotime($hour) <= strtotime('05:59'): return 'Boa noite'; break;
            case strtotime($hour) >= strtotime('06:00') && strtotime($hour) <= strtotime('11:59'): return 'Bom dia';   break;
            case strtotime($hour) >= strtotime('12:00') && strtotime($hour) <= strtotime('17:59'): return 'Boa tarde'; break;
            case strtotime($hour) >= strtotime('18:00') && strtotime($hour) <= strtotime('23:59'): return 'Boa noite'; break;
        }
    }

    public function currentYear()
    {
        return date('Y');
    }

    public function currentMonth()
    {
        return date('m');
    }

    public function listMonth()
    {
        return
        [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];
    }

    public function listYear()
    {
        return array_combine(range(1900, $this->currentYear() + 1), range(1900, $this->currentYear() + 1));
    }

    public function listDay($timestamp)
    {
        $dateStart = Carbon::createFromFormat('Y-m-d', $timestamp)->startOfMonth();
        $dateEnd   = $dateStart->copy()->endOfMonth();
        $dateDay   = array();

        for ($i = 1; $i <= $dateEnd->format('d'); $i++)
        {
            $dateDay[str_pad($i, 2, 0, STR_PAD_LEFT)] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }

        return $dateDay;
    }

    public function workingDays($timestamp)
    {
        $date  = self::createFromFormat('Y-m-d H:i:s', $timestamp);
        $start = $date->startOfMonth();
        $total = $date->daysInMonth;
        $count = 0;

        for ($i = 0; $i < $total; $i++)
        {
            if($start->isWeekend())
            {
                if($start->isSaturday())
                {
                    $count = $count + 0.5;
                }
            }
            else
            {
                $count = $count + 1;
            }

            $start->addDay();
        }

        return $count;
    }

    public function correctOrCurrent($timestamp)
    {
        $current = Carbon::now();

        if(preg_match('/\d{2}-\d{4}/', $timestamp))
        {
            $date  = explode('-', $timestamp);
            $check = checkdate ($date[0], '01', $date[1]);

            return $check ? Carbon::createFromFormat('d-m-Y H:i:s', "01-{$timestamp} 00:00:00") : $current;
        }
        else
        {
            return $current;
        }
    }

    public function dayOfWeek($timestamp)
    {
        $weekday =
        [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado'
        ];

        return $weekday[$timestamp->dayOfWeek];
    }

    public function dayWeight($timestamp)
    {
        $date = self::createFromFormat('Y-m-d', $timestamp);

        if($date->isWeekend())
        {
            if($date->isSaturday())
            {
                return 0.5;
            }
        }
        else
        {
            return 1;
        }

        return 0;
    }

    public function getWeight($days)
    {
        $weight = 0;

        foreach($days as $day)
        {
            $weight = $weight + $this->dayWeight($day);
        }

        return $weight;
    }

    public function allDays($timestamp)
    {
        $dateMain  = $this->correctOrCurrent($timestamp);
        $dateStart = $dateMain->startOfMonth();
        $dateCount = $dateStart->daysInMonth;
        $dateDays  = array();

        for($i = 0; $i < $dateCount; $i++)
        {
            $label   = $dateStart->format('d/m/Y');
            $value   = $dateStart->format('Y-m-d');
            $weight  = \Moment::dayWeight($value);
            $weekday = \Moment::dayOfWeek($dateStart);

            $dateDays[] =
            [
                'label'   => $label,
                'day'     => $value,
                'weight'  => $weight,
                'weekday' => $weekday,
            ];

            $dateStart->addDay();
        }

        return $dateDays;
    }

    public function localDateToDefault($date)
    {
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public function localDatetimeToDefault($date)
    {
        return Carbon::createFromFormat('d/m/Y H:i:s', $date)->format('Y-m-d H:i:s');
    }

    public function localDateRangeToArray($range)
    {
        $rangeSplit = explode('-', $range);
        $rangeTrim  = array_map('trim', $rangeSplit);
        $rangeArray = array();

        foreach($rangeTrim as $rangeItem)
        {
            $rangeArray[] = $this->localDateToDefault($rangeItem);
        }

        return $rangeArray;
    }

    public function defaultDateToLocal($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    }

    public function validateLocalDate($date)
    {
        $dateClean = trim($date);

        if(!is_null($dateClean) && preg_match('/^[\d]{2}\/[\d]{2}\/[\d]{4}$/', $dateClean))
        {
            $dateSplit = array_filter(explode('/', $dateClean));

            if(count($dateSplit) == 3)
            {
                return checkdate ($dateSplit[1], $dateSplit[0], $dateSplit[2]);
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

}