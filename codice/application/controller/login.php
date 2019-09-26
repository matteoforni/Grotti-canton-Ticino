<?php
class Login
{
    /**
     * Funzione che richiama la pagina principale caricando dal model i grotti.
     */
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("login/index");
        ViewLoader::load("_templates/footer");
    }
}
