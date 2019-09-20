<?php
class Home
{
    public function index()
    {
        require_once "./application/models/db_connection.php";
        $db = (new db_connection)->getConnection();
        $query = $db->prepare('SELECT * from grotto;');
        $query->execute();
        $_SESSION['grotti'] = $query->fetchAll();

        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("home/index");
        ViewLoader::load("_templates/footer");
    }
}
