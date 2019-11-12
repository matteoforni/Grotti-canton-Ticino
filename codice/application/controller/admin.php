<?php
require_once "./application/models/ruolo_model.php";
require_once "./application/models/utente_model.php";
require_once "./application/models/grotto_model.php";
require_once "./application/models/foto_model.php";
require_once "./application/models/fascia_prezzo_model.php";

class Admin
{
    /**
     * Funzione che mostra la pagina di admin solo se si è connessi e se il proprio utente è un admin.
     */
    public function index()
    {
        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati.
            if($_SESSION['user']['nome_ruolo'] == 'admin'){

                //Carico gli utenti.
                $utenti = (new utente_model)->getUsers();
                $_SESSION['users'] = $utenti;

                //Carico i grotti già validati.
                $grotti_validati = (new grotto_model)->getGrotti(true);
                $_SESSION['grotti_validati'] = $grotti_validati;

                //Carico i grotti da validare.
                $grotti = (new grotto_model)->getGrotti(false);
                $_SESSION['grotti'] = $grotti;

                //Carico le immagini.
                $i = 0;
                $immagini = null;
                foreach($grotti_validati as $grotto){
                    if($i == 0){
                        $immagini = (new foto_model)->getImages($grotto['id']);
                    }else{
                        $mom = (new foto_model)->getImages($grotto['id']);
                        if ($mom != null){
                            array_push($immagini, $mom[0]);
                        }
                    }
                    $i++;
                }
                if($immagini != null){
                    $_SESSION['immagini'] = array_filter($immagini);
                }else{
                    $_SESSION['immagini'] = array();
                }



                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("admin/index");
                ViewLoader::load("_templates/footer");
            }elseif($_SESSION['user']['nome_ruolo'] == 'utente'){
                //mostro l'index di base se l'utente non è admin.
                ViewLoader::load("_templates/header_user");
                ViewLoader::load("home/index");
                ViewLoader::load("_templates/footer");
            }
        }else{
            //mostro l'index di base se l'utente non è connesso.
            ViewLoader::load("_templates/header_base");
            ViewLoader::load("home/index");
            ViewLoader::load("_templates/footer");
        }
    }

    /**
     * Funzione che consente di passare alla pagina di modifica di un utente.
     * @param $email string L'email dell'utente da modificare.
     */
    public function updateUser($email){
        //Carico le classi che necessito.
        require_once "./application/models/input_manager.php";

        //Verifico che l'utente sia loggato e che sia un admin.
        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['nome_ruolo'] == 'admin') {
                if(isset($_SESSION['users'])){
                    //Cancello le sessioni se sono impostate così che la pagina di modifica mostri i dati corretti.
                    if(isset($_SESSION['utente'])){
                        unset($_SESSION['utente']);
                    }
                    if(isset($_SESSION['grotto'])){
                        unset($_SESSION['grotto']);
                    }
                    //Se non è settata carico i ruoli che un utente può avere.
                    if(!isset($_SESSION['ruoli'])){
                        $ruoli = (new ruolo_model)->getRuoli();
                        $_SESSION['ruoli'] = $ruoli;
                    }

                    //Carico dal DB l'utente.
                    $im = new InputManager();
                    $email = filter_var($im->checkInput($email), FILTER_SANITIZE_EMAIL);
                    $utente = (new utente_model)->getUser($email);

                    //Verifico che l'utente esista.
                    if($utente == null){
                        //Se non esiste resto alla pagina di admin.
                        header('Location: ' . URL . 'admin');
                        exit();
                    }
                    //Se esiste passo alla pagina di modifica.
                    $_SESSION['utente'] = $utente;
                    header('Location: ' . URL . 'gestione');
                    exit();
                }
            }
        }
    }

    /**
     * Funzione che consente di passare alla pagina di modifica di un grotto.
     * @param $id int L'id del grotto da modificare.
     */
    public function updateGrotto($id){
        //Carico le classi che necessito.
        require_once "./application/models/input_manager.php";

        //Verifico che l'utente sia loggato e che sia un admin.
        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['nome_ruolo'] == 'admin') {
                if(isset($_SESSION['grotti_validati'])){

                    //Cancello le sessioni se sono impostate così che la pagina di modifica mostri i dati corretti.
                    if(isset($_SESSION['grotto'])){
                        unset($_SESSION['grotto']);
                    }
                    if(isset($_SESSION['utente'])){
                        unset($_SESSION['utente']);
                    }
                    //Se non è settata carico le fascie di prezzo che un grotto può avere.
                    if(!isset($_SESSION['fasce_prezzo'])){
                        $fasce_prezzo = (new fascia_prezzo_model)->getFascePrezzo();
                        $_SESSION['fasce_prezzo'] = $fasce_prezzo;
                    }

                    //Carico dal DB il grotto.
                    $im = new InputManager();
                    $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
                    $grotto = (new grotto_model)->getGrotto($id);

                    //Verifico che esista.
                    if($grotto == null){
                        //Se non esiste resto alla pagina di admin.
                        header('Location: ' . URL . 'admin');
                        exit();
                    }
                    //Se esiste passo alla pagina di modifica.
                    $_SESSION['grotto'] = $grotto;
                    header('Location: ' . URL . 'gestione');
                    exit();
                }
            }
        }
    }
}