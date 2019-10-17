<?php


class Admin
{
    public function index()
    {
        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati
            if($_SESSION['user']['nome_ruolo'] == 'admin'){
                require_once "./application/models/DBConnection.php";

                //Carico gli utenti
                $utenti = (new DBConnection)->getUsers();
                $_SESSION['users'] = $utenti;

                //Carico i grotti già validati
                $grotti_validati = (new DBConnection)->getGrotti(true);
                $_SESSION['grotti_validati'] = $grotti_validati;

                //Carico i grotti da validare
                $grotti = (new DBConnection)->getGrotti(false);
                $_SESSION['grotti'] = $grotti;

                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("admin/index");
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

    public function showUser($email){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";

        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['nome_ruolo'] == 'admin') {
                if(isset($_SESSION['utenti'])){
                    if(isset($_SESSION['utente'])){
                        unset($_SESSION['utente']);
                    }
                    if(isset($_SESSION['grotto'])){
                        unset($_SESSION['grotto']);
                    }

                    //Carico dal DB l'utente
                    $im = new InputManager();
                    $email = filter_var($im->checkInput($email), FILTER_SANITIZE_EMAIL);
                    $utente = (new DBConnection)->getUser($email);
                    $_SESSION['utente'] = $utente;
                    header('Location: ' . URL . '');
                }
            }
        }
    }

    public function showGrotto($id){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";

        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['nome_ruolo'] == 'admin') {
                if(isset($_SESSION['grotti_validati'])){
                    if(isset($_SESSION['grotto'])){
                        unset($_SESSION['grotto']);
                    }
                    if(isset($_SESSION['utente'])){
                        unset($_SESSION['utente']);
                    }

                    //Carico dal DB il grotto
                    $im = new InputManager();
                    $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
                    $grotto = (new DBConnection)->getGrotto($id);
                    $_SESSION['grotto'] = $grotto;
                    header('Location: ' . URL . '');
                }
            }
        }
    }
}