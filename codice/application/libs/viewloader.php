<?php

class ViewLoader
{
    public static function load($template)
    {
        require_once  './application/views/'.$template.'.php';
    }
}
