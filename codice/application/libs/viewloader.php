<?php

class ViewLoader
{
    /**
     * Funzione che carica le views
     * @param $template string La view da caricare
     */
    public static function load($template)
    {
        require_once  './application/views/'.$template.'.php';
    }
}
