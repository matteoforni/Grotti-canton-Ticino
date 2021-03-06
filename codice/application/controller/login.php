<?php
require_once "./application/models/utente_model.php";

class Login
{
    /**
     * Funzione che richiama la pagina di login.
     */
    public function index()
    {
        //Se è appena stata camabiata la password elimino la sessione così che l'utente può ricambiare la password
        if(isset($_SESSION['password_change'])){
            unset($_SESSION['password_change']);
            unset($_SESSION['errors']);

        }
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("login/index");
        ViewLoader::load("_templates/footer");
    }

    /**
     * Funzione che verifica il login dell'utente.
     */
    public function checkLogin()
    {
        //richiamo le classi di cui avrò bisogno
        unset($_SESSION['errors']);
        require_once "./application/models/input_manager.php";

        $errors = array();

        //verifico il metodo di richiesta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

                //genero un nuovo input_manager e testo gli inserimenti
                $im = new input_manager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);

                //verifico che la lunghezza dei campi corrisponda con quella consentita
                if(!(strlen($email) > 0 && strlen($email) <= 50) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");
                }
                if(!(strlen($password) >= 8) || !preg_match('/^[\p{L}a-zA-Z\d._\-*%&!?$@+#+,;:]+$/', $password)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                }

                //se sono di lunghezze sbagliate ritorno l'errore
                if(count($errors) != 0){
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'login');
                    exit();
                }

                //prendo tutti gli utenti nel database
                $users = (new utente_model)->getUsers();

                //eseguo l'hash della password così da poterla comparare con quella nel db
                $password = hash('sha256', $password);
                foreach ($users as $row) {
                    //controllo che l'email sia in uso da un utente
                    if ($row['email'] == $email) {
                        //controllo che la password corrisponda
                        if ($row['password'] == $password) {
                            $_SESSION['user'] = (new utente_model)->getUser($email);
                            //verifico se è admin o utente normale
                            if(!$row['first_login']){
                                if ($row['nome_ruolo'] == 'admin') {
                                    header('Location: ' . URL . 'admin');
                                    exit();
                                } elseif ($row['nome_ruolo'] == 'utente') {
                                    header('Location: ' . URL . 'home');
                                    exit();
                                }
                            }else{
                                header('Location: ' . URL . 'firstLogin');
                                exit();
                            }

                        } else {
                            //se la password è sbagliata ritorno l'errore
                            array_push($errors, "Password o email sbagliate");
                            $_SESSION['errors'] = $errors;
                            header('Location: ' . URL . 'login');
                            exit();
                        }
                    }
                }
                //se l'email non è in utilizzo da nessun user ritorno l'errore
                array_push($errors, "Password o email sbagliate");
                $_SESSION['errors'] = $errors;

            }else{
                array_push($errors, "Nessun campo compilato");
                $_SESSION['errors'] = $errors;
            }
            header('Location: ' . URL . 'login');
            exit();
        }
    }

    /**
     * Funzione che consente di uscire dall'account alla quale si è connessi
     */
    public function logout(){
        unset($_SESSION['user']);
        header('Location: ' . URL . 'home');
        exit();
    }
}
