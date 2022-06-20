<?php

namespace Devpaulopaixao\LaravelTools\Helpers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Session;

class Alert
{

    public function success($message)
    {
        Session::put('alert', ['type' => 'success', 'message' => $message]);
    }

    public function error($message)
    {
        Session::put('alert', ['type' => 'error', 'message' => $message]);
    }

    public function info($message)
    {
        Session::put('alert', ['type' => 'info', 'message' => $message]);
    }

    private function build($type, $message)
    {
        $build  = '<script rel="script" type="text/javascript">';
        $build .= '$(function(){';
        $build .= 'new PNotify({';
        $build .= 'type: "'.$type.'",';
        $build .= 'text: "'.$message.'",';
        $build .= 'width: "100%",';
        $build .= 'delay: 4000,';
        $build .= 'hide: true,';
        $build .= 'animate:{animate: true, in_class: "slideInDown", out_class: "slideOutUp"}';
        $build .= '});});';
        $build .= '</script>';

        return $build;
    }

    private function destroy()
    {
        Session::forget('alert');
    }

    public function render()
    {
        if(Session::has('alert'))
        {
            $type    = Session::get('alert')['type'];
            $message = Session::get('alert')['message'];
            $render  = $this->build($type, $message);

            $this->destroy();

            return new HtmlString($render);
        }
        else
        {
            return null;
        }
    }

}