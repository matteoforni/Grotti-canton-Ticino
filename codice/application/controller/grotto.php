<?php


class Grotto
{
    public function index()
    {
        require_once "./application/models/db_connection.php";

        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati

            if($_SESSION['user']['nome_ruolo'] == 'admin'){
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("grotto/index");
                ViewLoader::load("_templates/footer");
            }elseif($_SESSION['user']['nome_ruolo'] == 'utente'){
                ViewLoader::load("_templates/header_user");
                ViewLoader::load("grotto/index");
                ViewLoader::load("_templates/footer");
            }
        }else{
            //mostro l'index di base
            ViewLoader::load("_templates/header_base");
            ViewLoader::load("grotto/index");
            ViewLoader::load("_templates/footer");
        }
    }

    public function show($id){
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";

        if(isset($_SESSION['grotto'])){
            unset($_SESSION['grotto']);
        }
        if(isset($_SESSION['img'])){
            unset($_SESSION['img']);
        }

        $im = new InputManager();
        $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
        $grotto = (new db_connection)->getGrotto($id);
        $images = (new db_connection)->getImages($id);
        $_SESSION['grotto'] = $grotto;
        $_SESSION['img'] = $images;
        header('Location: ' . URL . 'grotto');
    }
}