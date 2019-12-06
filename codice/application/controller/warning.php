<?php

class Warning
{
    /**
     * Funzione che carica la pagina di errore
     */
    public function index()
    {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        //Show warning page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("warning/index");
        ViewLoader::load("_templates/footer");
    }
}