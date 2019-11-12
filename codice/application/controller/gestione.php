<?php
require_once "./application/models/DBConnection.php";
require_once "./application/models/grotto_model.php";
require_once "./application/models/utente_model.php";
require_once "./application/models/foto_model.php";

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

    /**
     * Funzione che consente di modificare un utente contenuto nel DB.
     * @param $email string L'email dell'utente.
     */
    public function updateUtente($email){
        require_once "./application/models/input_manager.php";
        require_once "./application/models/mail_manager.php";

        //Genero un input e un email manager
        $im = new InputManager();
        $mm = new MailManager();

        //Verifico il contenuto della variabile email e carico tutti gli utenti dal DB.
        $email = filter_var($im->checkInput($email), FILTER_SANITIZE_EMAIL);
        $users = (new utente_model)->getUsers();

        //Imposto le variabili d'errore.
        $errors = array();
        if(isset($_SESSION['errors'])){
            unset($_SESSION['errors']);
        }

        //Verifico il metodo di richiesta dell'utente
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //Verifico se il campo password è impostato.
            if(isset($_POST['password']) && !empty($_POST['password'])){
                //Verifico che il valore inserito non contenga codice maligno
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                //Controllo che esista un utente con quella email
                foreach ($users as $user) {
                    if($user['email'] == $email){
                        //Se l'utente esiste imposto la nuova password e invio un email di notifica
                        (new utente_model)->setPassword($email, $password);
                        $body = "<h3>La tua password è stata reimpostata da uno dei nostri admin</h3>La tua nuova password è la seguente: <br><b>" . $password . "</b>";
                        //Se l'email non viene inviata correttamente si ritorna un errore
                        if(!$mm->sendMail($email, $body, "Grotti Ticinesi - Password Modificata")){
                            array_push($errors, "Impossibile inviare l'email");
                            $_SESSION['errors'] = $errors;
                            header('Location: ' . URL . 'admin');
                            exit();
                        }
                    }
                }
            }
            //Verifico che tutti i campi siano stati impostati
            if(isset($_POST['firstname']) && !empty($_POST['firstname']) &&
                isset($_POST['lastname']) && !empty($_POST['lastname']) &&
                isset($_POST['username']) && !empty($_POST['username']) &&
                isset($_POST['ruoli']) && !empty($_POST['ruoli'])){

                //Verifico che i valori inseriti non contengano codice maligno
                $firstname = filter_var($im->checkInputSpace($_POST['firstname']), FILTER_SANITIZE_STRING);
                $lastname = filter_var($im->checkInputSpace($_POST['lastname']), FILTER_SANITIZE_STRING);
                $username = filter_var($im->checkInput($_POST['username']), FILTER_SANITIZE_STRING);
                $ruolo = filter_var($im->checkInput($_POST['ruoli']), FILTER_SANITIZE_STRING);

                //Carico dal DB i dati dell'utente che sta venendo modificato
                $user = (new utente_model)->getUser($email);
                //Se l'utente esiste e i campi inseriti sono diversi da quelli già impostati essi vengono cambiati
                if($user != null){
                    if($user['nome'] != $firstname){
                        (new utente_model)->updateUtente($email, 'nome', $firstname);
                    }
                    if($user['cognome'] != $lastname){
                        (new utente_model)->updateUtente($email, 'cognome', $lastname);
                    }
                    if($user['username'] != $username){
                        (new utente_model)->updateUtente($email, 'username', $username);
                    }
                    if($user['nome_ruolo'] != $ruolo){
                        //Se si vuole passare da admin a utente
                        if($ruolo == 'utente'){
                            //Verifico che ci sia sempre un admin
                            foreach($users as $item){
                                if($item['nome_ruolo'] == 'admin' && $item['email'] != $user['email']){
                                    (new utente_model)->updateUtente($email, 'nome_ruolo', $ruolo);
                                    header('Location: ' . URL . 'admin');
                                    exit();
                                }
                            }
                            array_push($errors, "Deve sempre esserci almeno un admin");
                            $_SESSION['errors'] = $errors;
                        }else{
                            (new utente_model)->updateUtente($email, 'nome_ruolo', $ruolo);
                        }
                    }
                }
            }else{
                array_push($errors, "Devi compilare tutti i campi");
                $_SESSION['errors'] = $errors;
            }
            header('Location: ' . URL . 'admin');
            exit();
        }
    }

    /**
     * Funzione che consente di modificare un grotto.
     * @param $id int L'identificatore del grotto.
     */
    public function updateGrotto($id){
        require_once "./application/models/input_manager.php";

        //Genero un input
        $im = new InputManager();

        //Verifico il contenuto della variabile id e carico tutti i grotti dal DB.
        $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);

        //Imposto le variabili d'errore.
        $errors = array();
        if(isset($_SESSION['errors'])){
            unset($_SESSION['errors']);
        }

        //Verifico il metodo di richiesta dell'utente
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //Verifico che tutti i campi siano stati impostati
            if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['cap']) && !empty($_POST['cap']) &&
                isset($_POST['paese']) && !empty($_POST['paese']) && isset($_POST['no_civico']) && !empty($_POST['no_civico']) &&
                isset($_POST['via']) && !empty($_POST['via']) && isset($_POST['telefono']) && !empty($_POST['telefono']) &&
                isset($_POST['fascia_prezzo']) && !empty($_POST['fascia_prezzo']) && isset($_POST['lat']) && !empty($_POST['lat']) &&
                isset($_POST['lng']) && !empty($_POST['lng'])){

                //Verifico che i valori inseriti non contengano codice maligno
                $nome = filter_var($im->checkInputSpace($_POST['name']), FILTER_SANITIZE_STRING);
                $cap = filter_var($im->checkInput($_POST['cap']), FILTER_SANITIZE_NUMBER_INT);
                $paese = filter_var($im->checkInputSpace($_POST['paese']), FILTER_SANITIZE_STRING);
                $via = filter_var($im->checkInputSpace($_POST['via']), FILTER_SANITIZE_STRING);
                $nocivico = filter_var($im->checkInput($_POST['no_civico']), FILTER_SANITIZE_STRING);
                $telefono = filter_var($im->checkInput($_POST['telefono']), FILTER_SANITIZE_STRING);
                $fasciaprezzo = filter_var($im->checkInputSpace($_POST['fascia_prezzo']), FILTER_SANITIZE_STRING);
                $lat = filter_var($im->checkInput($_POST['lat']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $lon = filter_var($im->checkInput($_POST['lng']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                $grotto = (new grotto_model)->getGrotto($id);
                if($grotto != null){
                    if($grotto['nome'] != $nome){
                        (new grotto_model)->updateGrotto($id, 'nome', $nome);
                    }
                    if($grotto['cap'] != $cap){
                        (new grotto_model)->updateGrotto($id, 'cap', $cap);
                        (new grotto_model)->updateGrotto($id, 'lat', $lat);
                        (new grotto_model)->updateGrotto($id, 'lon', $lon);
                    }
                    if($grotto['paese'] != $paese){
                        (new grotto_model)->updateGrotto($id, 'paese', $paese);
                        (new grotto_model)->updateGrotto($id, 'lat', $lat);
                        (new grotto_model)->updateGrotto($id, 'lon', $lon);
                    }
                    if($grotto['via'] != $via){
                        (new grotto_model)->updateGrotto($id, 'via', $via);
                        (new grotto_model)->updateGrotto($id, 'lat', $lat);
                        (new grotto_model)->updateGrotto($id, 'lon', $lon);
                    }
                    if($grotto['no_civico'] != $nocivico){
                        (new grotto_model)->updateGrotto($id, 'no_civico', $nocivico);
                        (new grotto_model)->updateGrotto($id, 'lat', $lat);
                        (new grotto_model)->updateGrotto($id, 'lon', $lon);
                    }
                    if($grotto['telefono'] != $telefono){
                        (new grotto_model)->updateGrotto($id, 'telefono', $telefono);
                    }
                    if($grotto['fascia_prezzo'] != $fasciaprezzo){
                        (new grotto_model)->updateGrotto($id, 'fascia_prezzo', $fasciaprezzo);
                    }
                }
            }
            array_push($errors, "Inserire tutti i valori");
            $_SESSION['errors'] = $errors;
            header('Location: ' . URL . 'admin');
            exit();
        }
    }

    /**
     * Funzione che consente di accettare un grotto inserito da un utente.
     * @param $id int L'identificatore del grotto.
     */
    public function acceptGrotto($id){
        require_once "./application/models/input_manager.php";

        //Genero un input manager e verifico che i campi non contengano codice maligno
        $im = new InputManager();
        $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);

        //Carico il grotto dal DB
        $grotto = (new grotto_model)->getGrotto($id);
        //Se il grotto esiste lo imposto come verificato
        if($grotto != null){
            (new grotto_model)->setVerificato($id);
        }
        header('Location: ' . URL . 'admin');
        exit();
    }

    /**
     * Funzione che consente di eliminare un utente o un grotto
     * @param $type string Il tipo di elemento da eliminare (utente / grotto)
     * @param $id int/string L'identificatore dell'elemento da eliminare (email / id)
     */
    public function elimina($type, $id){
        require_once "./application/models/input_manager.php";

        //Genero un input manager
        $im = new InputManager();

        //Elimino le sessioni precedentemente generate
        unset($_SESSION['grotti']);
        unset($_SESSION['grotti_validati']);
        unset($_SESSION['users']);

        //Se vi erano errori in precedenza li elimino
        if(isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
        $errors = array();

        //Se si vuole eliminare un grotto
        if($type == 'grotto'){
            //Verifico che il grotto esiste
            $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
            $grotto = (new grotto_model)->getGrotto($id);
            $immagini = (new foto_model)->getImages($id);
            if($grotto != null){
                //Se esiste lo elimino
                (new grotto_model)->delete($id);
                if($immagini != null){
                    foreach ($immagini as $immagine){
                        unlink($immagine['path']);
                    }
                }
            }
        //Se si vuole eliminare un utente
        }elseif ($type == 'utente'){
            //Verifico che l'utente esista
            $id = filter_var($im->checkInput($id), FILTER_SANITIZE_EMAIL);
            $utenti = (new utente_model)->getUsers();
            $utente = (new utente_model)->getUser($id);
            if($utente != null){
                //Verifico che ci sia sempre almeno un admin
                foreach($utenti as $item){
                    if(($item['nome_ruolo'] == 'admin' && $item['email'] != $utente['email'])){
                        (new utente_model)->delete($id);
                        header('Location: ' . URL . 'admin');
                        exit();
                    }
                }
                array_push($errors, "Deve sempre esserci almeno un admin");
                $_SESSION['errors'] = $errors;
            }
        //Se si vuole eliminare un'immagine
        }elseif ($type == 'immagine'){
            echo "immagine";
            //Verifico che l'immagine esista
            $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);
            $immagine = (new foto_model)->getImage($id);
            if($immagine != null){
                //Se esiste la elimino
                try {
                    unlink($immagine['path']);
                    (new foto_model)->delete($id);
                }catch (Exception $e){
                    array_push($errors, "Impossibile eliminare l'immagine");
                    $_SESSION['errors'] = $errors;
                }
            }
        }
        header('Location: ' . URL . 'admin');
        exit();
    }

    /**
     * Funzione che consente di ritornare alla pagina di admin
     */
    public function back(){
        header('Location: ' . URL . 'admin');
        exit();
    }
}