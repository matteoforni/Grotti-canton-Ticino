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

        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati

            if($_SESSION['user'][0]['nome_ruolo'] == 'admin'){
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("home/index");
                ViewLoader::load("_templates/footer");
            }elseif($_SESSION['user'][0]['nome_ruolo'] == 'utente'){
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

    public function logout(){
        unset($_SESSION['user']);
        header('Location: ' . URL . 'home');
        exit();
    }
}
