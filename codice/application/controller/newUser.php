<?php
require_once "./application/models/utente_model.php";

class NewUser
{
    public function index()
    {
        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati
            if($_SESSION['user']['nome_ruolo'] == 'admin'){
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("newUser/index");
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

    public function createUser(){
        //richiamo le classi di cui avrò bisogno
        require_once "./application/models/input_manager.php";
        require_once "./application/models/mail_manager.php";

        $errors = array();

        //verifico il metodo di richiesta
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['lastname'])
                && isset($_POST['username']) && !empty($_POST['username']) &&
                isset($_POST['email']) && !empty($_POST['email'])) {

                //genero un nuovo input_manager e testo gli inserimenti
                $exists = false;
                $im = new input_manager();
                $firstname = filter_var($im->checkInputSpace($_POST['firstname']), FILTER_SANITIZE_STRING);
                $lastname = filter_var($im->checkInputSpace($_POST['lastname']), FILTER_SANITIZE_STRING);
                $username = filter_var($im->checkInput($_POST['username']), FILTER_SANITIZE_STRING);
                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);

                //verifico che la lunghezza dei campi corrisponda con quella consentita
                if(!(strlen($firstname) > 0 && strlen($firstname) <= 50) || !preg_match('/^[\p{L}a-zA-Z\' ]+$/', $firstname)){
                    array_push($errors, "Il nome deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($lastname) > 0 && strlen($lastname) <= 50) || !preg_match('/^[\p{L}a-zA-Z\' ]+$/', $lastname)){
                    array_push($errors, "Il cognome deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($username) > 0 && strlen($username) <= 50) || !preg_match('/^[\p{L}a-zA-Z0-9\d._\- ]+$/', $username)){
                    array_push($errors, "Lo username deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($email) > 0 && strlen($email) <= 50) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");
                }

                //se sono di lunghezze sbagliate ritorno l'errore
                if(count($errors) != 0){
                    $_SESSION['errors'] = $errors;
                    $data = array(
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'email' => $email
                    );
                    $_SESSION['data'] = $data;
                    header('Location: ' . URL . 'newUser');
                    exit();
                }

                //verifico che la password sia la stessa in entrambi i campi

                $users = (new utente_model)->getUsers();
                //verifico che l'email non sia già in uso
                foreach ($users as $row) {
                    if ($row['email'] == $email) {
                        array_push($errors, "L'email è già in uso");
                        $exists = true;
                    }
                }
                //se non esiste inserisco il nuovo utente nel db
                if(!$exists) {
                    try {
                        $password = bin2hex(random_bytes(4));
                        (new utente_model)->addUser($firstname, $lastname, $username, $email, $password, true);
                        unset($_POST);
                        $mm = new mail_manager();
                        $body = "<h3>Un admin di Grotti Ticinesi ha creato un account con la tua email</h3>La password per accedervi è la seguente: <br><b>" . $password . "</b><br><br>Accedi dal seguente link: <a href='" . URL . "login'>Grotti ticino</a>";
                        $mm->sendMail($email, $body, "Grotti Ticinesi - Benvenuto");
                        header('Location: ' . URL . 'admin');
                        exit();
                    }catch(Exception $e){
                        $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
                        header('Location: ' . URL . 'warning');
                        exit();
                    }
                }else{
                    //se è già in uso ritorno l'errore
                    $_SESSION['errors'] = $errors;
                    $data = array(
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'email' => $email
                    );
                    $_SESSION['data'] = $data;
                    header('Location: ' . URL . 'newUser');
                    exit();
                }
                //se le password non sono uguali ritorno l'errore
            }else{
                //se non sono stati inseriti tutti i dati ritorno l'errore
                array_push($errors, "Inserire tutti i dati");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'newUser');
                exit();
            }
        }
    }
}