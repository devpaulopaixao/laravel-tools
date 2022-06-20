<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Session;

class Layout
{
    protected $prefix;

    public function __construct()
    {
       $this->prefix = explode('.', request()->headers->get('host'))[0] == 'science' ? 'client' : 'admin';
    }

    public function errorClass($field)
    {
        if(Session::has('errors') && Session::get('errors')->has($field))
        {
            return ($this->prefix == 'admin') ? 'has-error' : '';
        }
        else
        {
            return null;
        }
    }

    public function errorText($field)
    {
        if(Session::has('errors') && Session::get('errors')->has($field))
        {
            return ($this->prefix == 'admin') ? 'text-danger' : 'is-invalid';
        }
        else
        {
            return ($this->prefix == 'admin') ? 'text-muted' : '';
        }
    }

    public function errorDescription($field)
    {
        if(Session::get('errors'))
        {
            return Session::get('errors')->first($field);
        }
        else
        {
            return null;
        }
    }

    public function activeClass($route)
    {
        if(route($route) == request()->url())
        {
            return 'active';
        }
        else
        {
            return null;
        }
    }

    public function createSelect($name, $data = null, $selected = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="form-control select-main'.($class ? " {$class}" : null).'" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createOption($data, $selected);
        $render .= '</select>';

        return  new HtmlString($render);
    }

    public function createSelectClient($name, $data = null, $selected = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="form-select'.($class ? " {$class}" : null).'" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createOption($data, $selected);
        $render .= '</select>';

        return  new HtmlString($render);
    }

    public function createMultiSelect($name, $data = null, $selected = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="multiselect'.($class ? " {$class}" : null).'" multiple="multiple" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createOption($data, $selected, false);
        $render .= '</select>';

        return  new HtmlString($render);
    }

    public function createMultiSelectFilter($name, $data = null, $selected = array(), $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $selected = (array)$selected;

        $render  = '<div class="multi-select-full">';
        $render .= '<select class="multiselect-filtering'.($class ? " {$class}" : null).'" multiple="multiple" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createMultiOption($data, $selected, false);
        $render .= '</select></div>';

        return  new HtmlString($render);
    }

    public function createSelectSearch($name, $data = null, $selected = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="select-main'.($class ? " {$class}" : null).'" data-live-search="true" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createOption($data, $selected);
        $render .= '</select>';

        return  new HtmlString($render);
    }

    public function createSelectSearchMultiple($name, $data = null, array $selected, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="select-main'.($class ? " {$class}" : null).'" multiple="multiple" data-live-search="true" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createMultiOptionArray($data, $selected, false);
        $render .= '</select>';

        return  new HtmlString($render);
    }

    public function createSelectSearchClient($name, $data = null, $selected = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="form-select select2'.($class ? " {$class}" : null).'" data-live-search="true" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createOption($data, $selected);
        $render .= '</select>';

        return  new HtmlString($render);
    }

	public function createSelectGroup($name, $data = null, $selected = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        $render  = '<select class="select-main'.($class ? " {$class}" : null).'" data-width="100%" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).'>';
        $render .= $this->createOptionGroup($data, $selected);
        $render .= '</select>';
        return  new HtmlString($render);
    }
	
	public function createOptionGroup($data = null, $selected = null)
    {
        if(is_array($data))
        {
            $render = '<option></option>';

            foreach($data as $keys => $items)
            {
                $render .= '<optgroup label="'.$keys.'">';

                foreach($items as $key => $item)
                {
                    if($key == $selected)
                    {
                        $render .= '<option value="'.$key.'" selected="selected">'.$item.'</option>';
                    }
                    else
                    {
                        $render .= '<option value="'.$key.'">'.$item.'</option>';
                    }
                }

                $render .= '</optgroup>';
            }

            return  new HtmlString($render);
        }
        else
        {
            return null;
        }
    }
	
    public function createOption($data = null, $selected = null, $first = true)
    {
        if(is_array($data))
        {
            $render = $first ? '<option></option>' : null;

            foreach ($data as $key => $item)
            {
                if($key == $selected)
                {
                    $render .= '<option value="'.$key.'" selected="selected">'.$item.'</option>';
                }
                else
                {
                    $render .= '<option value="'.$key.'">'.$item.'</option>';
                }
            }

            return  new HtmlString($render);
        }
        else
        {
            return null;
        }
    }

    public function createMultiOption($data = null, $selected = null, $first = true)
    {

        if(is_array($data))
        {
            $render = $first ? '<option></option>' : null;

            foreach ($data as $key => $item)
            {
                if(in_array($key, $selected))
                {
                    $render .= '<option value="'.$key.'" selected="selected">'.$item.'</option>';
                }
                else
                {
                    $render .= '<option value="'.$key.'">'.$item.'</option>';
                }
            }

            return  new HtmlString($render);
        }
        else
        {
            return null;
        }
    }

    public function createMultiOptionArray($data = null, $selected = [], $first = true)
    {

        if(is_array($data))
        {
            $render = $first ? '<option></option>' : null;

            foreach ($data as $key => $item)
            {
                if(in_array($key, $selected))
                {
                    $render .= '<option value="'.$key.'" selected="selected">'.$item.'</option>';
                }
                else
                {
                    $render .= '<option value="'.$key.'">'.$item.'</option>';
                }
            }

            return  new HtmlString($render);
        }
        else
        {
            return null;
        }
    }

    public function createNumber($name, $value = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        return new HtmlString('<input class="form-control'.($class ? " {$class}" : null).'" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).' type="number" value="'.$value.'">');
    }

    public function createText($name, $value = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        return new HtmlString('<input class="form-control'.($class ? " {$class}" : null).'" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).' type="text" value="'.$value.'">');
    }

    public function createPassword($name, $value = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        return new HtmlString('<input class="form-control'.($class ? " {$class}" : null).'" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).' type="password" value="'.$value.'">');
    }

    public function createTextarea($name, $value = null, $required = true, $disabled = false, $readonly = false, $class = null, $height = null, $length = 255)
    {
        return new HtmlString('<textarea maxlength='.$length.' class="form-control'.($class ? " {$class}" : null).'" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).' '.($height ? 'rows="'.$height.'"' : null).'>'.$value.'</textarea>');
    }

    public function createDate($name, $value = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        return new HtmlString('<input class="form-control'.($class ? " {$class}" : null).'" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).' type="date" value="'.$value.'">');
    }

    public function createMail($name, $value = null, $required = true, $disabled = false, $readonly = false, $class = null)
    {
        return new HtmlString('<input class="form-control'.($class ? " {$class}" : null).'" '.($disabled ? 'disabled="disabled"' : null).' id="input-'.str_replace('_','-', $name).'" name="'.$name.'" '.($readonly ? 'readonly="readonly"' : null).' '.($required ? 'required="required"' : null).' type="email" value="'.$value.'">');
    }

    public function createHidden($name, $value = null)
    {
        return new HtmlString('<input id="input-'.str_replace('_','-', $name).'" name="'.$name.'" type="hidden" value="'.$value.'">');
    }
    public function createRangeSlide($range,$position = null,$min,$max)
    {
        $template = '<div class="category-content" style="display: block;">
                       <div class="mb-1">
                         <div style="background-color: #7986cb;" name="divSlider" class="ui-slider-horizontal ui-slider-pips jui-slider-labels-custom" data-min='.$min.' data-max='.$max.' data-range='.$range.' data-value="'.$position.'" data-fouc></div>
                        </div>
                     </div>';

        return new HtmlString($template);
    }

}