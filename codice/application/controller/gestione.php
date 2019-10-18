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

    public function updateUtente($email){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";
        $im = new InputManager();

        $email = filter_var($im->checkInput($email), FILTER_SANITIZE_EMAIL);

    }

    public function updateGrotto($id){

    }

    public function acceptGrotto($id){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";

        $im = new InputManager();
        $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
        $grotto = (new DBConnection)->getGrotto($id);
        if($grotto != null){
            (new DBConnection)->setVerificato($id);

        }
        header('Location: ' . URL . 'admin');
        exit();
    }

    public function elimina($type, $id){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";

        $im = new InputManager();

        unset($_SESSION['grotti']);
        unset($_SESSION['grotti_validati']);
        unset($_SESSION['users']);

        if(isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }

        $errors = array();

        if($type == 'grotto'){
            $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
            $grotto = (new DBConnection)->getGrotto($id);
            if($grotto != null){
                (new DBConnection)->delete($type, $id);
            }
        }elseif ($type == 'utente'){
            $id = filter_var($im->checkInput($id), FILTER_SANITIZE_EMAIL);
            $utenti = (new DBConnection)->getUsers();
            $utente = (new DBConnection)->getUser($id);
            if($utente != null){
                foreach($utenti as $item){
                    if($item['nome_ruolo'] == 'admin' && $item['id'] != $utente['id']){
                        (new DBConnection)->delete($type, $id);
                    }else{
                        array_push($errors, "Deve sempre esserci almeno un admin");
                        $_SESSION['errors'] = $errors;
                    }
                }
            }
        }
        header('Location: ' . URL . 'admin');
        exit();
    }

    public function back(){
        header('Location: ' . URL . 'admin');
        exit();
    }
}