<?php
require_once "./application/models/utente_model.php";

class Reset
{
    /**
     * Funzione che richiama la pagina di reset della password.
     */
    public function index()
    {
        if (isset($_COOKIE['password_changed'])){
            setcookie('password_changed', '', time()-3600, '/');
        }
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("login/reset");
        ViewLoader::load("_templates/footer");
    }

    /**
     * Funziona che gestisce il contenuto dei campi del form quando si esegue un reset dell'email e richiama il mail_manager
     * per inviare l'email di reset.
     */
    public function sendEmail(){
        require_once "./application/models/input_manager.php";
        require_once "./application/models/mail_manager.php";

        unset($_SESSION['errors']);
        $errors = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['email']) && !empty($_POST['email'])) {

                //genero un nuovo input_manager e testo gli inserimenti
                $im = new input_manager();
                $mm = new mail_manager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $users = (new utente_model)->getUsers();


                //Verifico che esista un utente con l'email inserita
                foreach ($users as $user) {
                    if($user['email'] == $email){
                        //Genero un token
                        $token = (new utente_model)->setToken($email);
                        //Invio l'email
                        $body = "<h3>C'é stato un tentativo di modifica della password di questo account.</h3> Se sei stato te per reimpostare la tua password premi sul seguente link: <br><a href='" . URL . "reset/resetPassword/" . $token . "'>Reimposta la tua password</a>";
                        if($mm->sendMail($email, $body, "Grotti Ticinesi - Reimposta la tua password")){
                            setcookie('mail_sent', $email, time()+86400, '/');
                            header('Location: ' . URL . 'reset');
                            exit();
                        }
                    }
                }
                //Genero l'errore se l'email non è in uso
                array_push($errors, "L'email non è in uso da nessun account");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'reset');
                exit();
            }else{
                //Genero l'errore se non si ha inserito niente
                array_push($errors, "Inserire un email valida");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'reset');
                exit();
            }
        }
    }

    /**
     * Funzione che consente di ripristinare la password
     * @param $token string Il token di reset inviato via email
     */
    public function resetPassword($token){
        require_once "./application/models/input_manager.php";

        //Verifico che l'email sia stata inviata
        if(isset($_COOKIE['mail_sent'])){

            //Verifico i campi inseriti
            $im = new input_manager();
            $token = filter_var($im->checkInput($token), FILTER_SANITIZE_STRING);

            //Verifico che l'utente esista
            $user = (new utente_model)->getUserFromToken($token);
            if($user != null){
                //Se esiste genero i cookie che mostreranno la pagina corretta
                setcookie('password_change', true, time()+86400, '/');
                setcookie('user_mail', $user['email'], time()+86400, '/');
                setcookie('mail_sent', '', time()-3600, '/');
                header('Location: ' . URL . 'reset');
                exit();
            }else{
                header('Location: ' . URL . 'login');
                exit();
            }
        }else{
            //Se non è stata inviata l'email riporto l'utente alla pagina di invio
            header('Location: ' . URL . 'reset');
            exit();
        }
    }

    /**
     * Funzione che consente di cambiare la password
     */
    public function setNewPassword(){
        require_once "./application/models/input_manager.php";

        //Svuoto le variabili contenenti gli errori
        unset($_SESSION['errors']);
        $errors = array();

        //Verifico il metodo di richiesta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])
                && isset($_POST['repassword']) && !empty($_POST['repassword'])) {
                //genero un nuovo input_manager e testo gli inserimenti
                $im = new input_manager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

                //Verifico la lunghezza e il contenuto dei campi
                if(!(strlen($email) > 0 && strlen($email) <= 50) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'reset');
                    exit();
                }
                if(!(strlen($password) >= 8) || !preg_match('/^[\p{L}a-zA-Z\d._\-*%&!?$@+#+,;:]+$/', $password)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'reset');
                    exit();
                }

                //Carico gli utenti dal database
                $users = (new utente_model)->getUsers();
                //Controllo che le due password siano uguali
                if($password == $repassword){
                    //Verifico che esista un utente con l'email inserita
                    foreach ($users as $user) {
                        if($user['email'] == $email){
                            //imposto la nuova password
                            (new utente_model)->setPassword($email, $password);
                            setcookie('password_change', '', time()-3600, '/');
                            setcookie('password_changed', true, time()+86400, '/');
                            header('Location: ' . URL . 'reset');
                            exit();
                        }
                    }
                    //Genero l'errore se nessun'account usa quell'email
                    array_push($errors, "L'email non è in uso da nessun account");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'reset');
                    exit();
                }else{
                    //Genero un errore se le password sono diverse
                    array_push($errors, "Le password non sono uguali");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'reset');
                    exit();
                }
            }else{
                //Genero un errore se non sono stati inseriti tutti i campi
                array_push($errors, "Inserire tutti i dati");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'reset');
                exit();
            }
        }
    }
}