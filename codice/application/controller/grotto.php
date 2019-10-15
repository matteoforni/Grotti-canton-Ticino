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

    //funzione che mostra il grotto scelto dalla tabella
    public function show($id){
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";

        if(isset($_SESSION['grotto'])){
            unset($_SESSION['grotto']);
        }
        if(isset($_SESSION['img'])){
            unset($_SESSION['img']);
        }

        //Carico dal DB il grotto e le sue immagini
        $im = new InputManager();
        $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
        $grotto = (new DBConnection)->getGrotto($id);
        $images = (new DBConnection)->getImages($id);
        $_SESSION['grotto'] = $grotto;
        $_SESSION['img'] = $images;
        header('Location: ' . URL . 'grotto');
    }

    //Funzione che consente di votare un grotto
    public function vota(){
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";
        $im = new InputManager();
        $errors = Array();
        unset($_SESSION['errors']);

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['val']) && !empty($_POST['val']) && isset($_SESSION['user'])){

                //Prendo i dati dell'utente, del grotto e la votazione
                $grotto = $_SESSION['grotto']['id'];
                $utente = $_SESSION['user']['email'];
                $valutazione = filter_var($im->checkInput($_POST['val']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                if($valutazione >= 0 && $valutazione <= 5) {
                    //Inserisco il voto nel DB
                    (new DBConnection())->addVoto($grotto, $utente, $valutazione);
                    header('Location: ' . URL . 'grotto/show/' . $grotto['id']);
                    exit();
                }else{
                    //se non vengono inseriti i dati in maniera corretta
                    array_push($errors, "Inserire una votazione valida");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'grotto/show/' . $grotto['id']);
                    exit();
                }
            }
        }
    }
}