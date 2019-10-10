<?php


class Success
{
    //Metodo che carica la pagina di successo
    public function index()
    {
        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['nome_ruolo'] == 'admin') {
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("add/success");
                ViewLoader::load("_templates/footer");
            } elseif ($_SESSION['user']['nome_ruolo'] == 'utente') {
                ViewLoader::load("_templates/header_user");
                ViewLoader::load("add/success");
                ViewLoader::load("_templates/footer");
            }
        }else{
            ViewLoader::load("_templates/header_base");
            ViewLoader::load("home/index");
            ViewLoader::load("_templates/footer");
        }
    }
}