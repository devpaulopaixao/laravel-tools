<?php

namespace Devpaulopaixao\LaravelTools;

use Illuminate\Support\ServiceProvider;

class LaravelToolsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {        
        //RETRIEVE LOADER INSTANCE
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        //REGISTER ALL HELPERS FROM THIS PACKAGE
        $loader->alias('Alert',         'Devpaulopaixao\LaravelTools\Helpers\Alert');
        $loader->alias('Domain',        'Devpaulopaixao\LaravelTools\Helpers\Domain');
        $loader->alias('Helper',        'Devpaulopaixao\LaravelTools\Helpers\Helper');
        $loader->alias('Layout',        'Devpaulopaixao\LaravelTools\Helpers\Layout');
        $loader->alias('Mask',          'Devpaulopaixao\LaravelTools\Helpers\Mask');
        $loader->alias('Moment',        'Devpaulopaixao\LaravelTools\Helpers\Moment');
        $loader->alias('Numeric',       'Devpaulopaixao\LaravelTools\Helpers\Numeric');
        $loader->alias('Text',          'Devpaulopaixao\LaravelTools\Helpers\Text');
        $loader->alias('Validation',    'Devpaulopaixao\LaravelTools\Helpers\Validation');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //START NUMERIC ARRAY VALIDATION
        $this->app['validator']->extend('numericarray', function ($attribute, $value, $parameters)
        {
            foreach ($value as $v) {
                if (!is_int($v)) {
                    return false;
                }
            }
            return true;
        });
        //END NUMERIC ARRAY VALIDATION
        
        //START CPF VALIDATION
        $this->app['validator']->extend('cpf', function ($attribute, $value, $parameters)
        {
            $value = \Numeric::filterNumber($value);
            
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
        });
        //END CPF VALIDATION
        
        //START CNPJ VALIDATION
        $this->app['validator']->extend('cnpj', function ($attribute, $value, $parameters)
        {
            $value = \Numeric::filterNumber($value);
            
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
        });
        //END CNPJ VALIDATION

        $this->app['validator']->extend('no_repeat', function ($attribute, $value, $parameters)
        {
            $first  = substr($value, 0, 1);
            $repeat = str_repeat($first, mb_strlen($value));
            
            return $value === $repeat ? false : true;
        });

        $this->app['validator']->extend('month', function ($attribute, $value, $parameters)
        {
            if(is_numeric($value) && ctype_digit($value))
            {
                return $value >= 1 && $value <= 12;
            }
            else
            {
                return false;
            }
        });

        $this->app['validator']->extend('year', function ($attribute, $value, $parameters)
        {
            return array_key_exists($value, \Moment::listYear());
        });
    }
}