<?php
require_once "./application/models/grotto_model.php";

class Home
{
    /**
     * Funzione che richiama la pagina principale caricando dal model i grotti.
     */
    public function index()
    {
        $query = (new grotto_model)->getGrotti(true);
        $_SESSION['grotti'] = $query;

        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati

            if($_SESSION['user']['nome_ruolo'] == 'admin'){
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("home/index");
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
