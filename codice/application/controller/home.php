<?php
class Home
{
    /**
     * Funzione che richiama la pagina principale caricando dal model i grotti.
     */
    public function index()
    {
        require_once "./application/models/db_connection.php";
        $query = (new db_connection)->getGrotti();
        $_SESSION['grotti'] = $query->fetchAll();

        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("home/index");
        ViewLoader::load("_templates/footer");
    }
}
