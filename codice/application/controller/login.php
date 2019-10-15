<?php
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
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";

        $errors = array();

        //verifico il metodo di richiesta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

                //genero un nuovo InputManager e testo gli inserimenti
                $im = new InputManager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);

                //prendo tutti gli utenti nel database
                $db = (new DBConnection)->getUsers();

                //eseguo l'hash della password così da poterla comparare con quella nel db
                $password = hash('sha256', $password);
                foreach ($db->fetchAll() as $row) {
                    //controllo che l'email sia in uso da un utente
                    if ($row['email'] == $email) {
                        //controllo che la password corrisponda
                        if ($row['password'] == $password) {
                            $_SESSION['user'] = (new DBConnection)->getUser($email);
                            //verifico se è admin o utente normale
                            if ($row['nome_ruolo'] == 'admin') {
                                header('Location: ' . URL . 'admin');
                                exit();
                            } elseif ($row['nome_ruolo'] == 'utente') {
                                header('Location: ' . URL . 'home');
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
                header('Location: ' . URL . 'login');
                exit();
            }
        }
    }
}
