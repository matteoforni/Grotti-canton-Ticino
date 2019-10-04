<?php


class Add
{
    public function index()
    {
        require_once "./application/models/db_connection.php";
        $query = (new db_connection)->getFascePrezzo();
        $_SESSION['fasce_prezzo'] = $query;

        if($_SESSION['user']['nome_ruolo'] == 'admin'){
            ViewLoader::load("_templates/header_admin");
            ViewLoader::load("add/index");
            ViewLoader::load("_templates/footer");
        }elseif($_SESSION['user']['nome_ruolo'] == 'utente'){
            ViewLoader::load("_templates/header_user");
            ViewLoader::load("add/index");
            ViewLoader::load("_templates/footer");
        }
    }

    public function addGrotto(){
        print_r($_POST);
    }
}