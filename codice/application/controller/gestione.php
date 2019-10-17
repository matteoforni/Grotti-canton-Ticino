<?php


class Gestione
{
    public function index()
    {
        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati
            if($_SESSION['user']['nome_ruolo'] == 'admin'){
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("gestione/index");
                ViewLoader::load("_templates/footer");
            }elseif($_SESSION['user']['nome_ruolo'] == 'utente'){
                ViewLoader::load("_templates/header_user");
                ViewLoader::load("home/index");
                ViewLoader::load("_templates/footer");
            }
        }else{
            //mostro l'index di base
            ViewLoader::load("_templates/header_base");
            ViewLoader::load("home/index");
            ViewLoader::load("_templates/footer");
        }
    }
}