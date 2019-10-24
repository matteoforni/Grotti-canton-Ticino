<?php
class Reset
{
    /**
     * Funzione che richiama la pagina di reset della password.
     */
    public function index()
    {
        //unset($_SESSION['mail_sent']);
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("login/reset");
        ViewLoader::load("_templates/footer");
    }

    /**
     * Funziona che gestisce il contenuto dei campi del form quando si esegue un reset dell'email e richiama il MailManager
     * per inviare l'email di reset.
     */
    public function sendEmail(){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";
        require_once "./application/models/mail_manager.php";

        unset($_SESSION['errors']);
        $errors = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])
                && isset($_POST['repassword']) && !empty($_POST['repassword'])) {

                //genero un nuovo InputManager e testo gli inserimenti
                $im = new InputManager();
                $mm = new MailManager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

                if($password == $repassword){
                    $users = (new DBConnection())->getUsers();
                    $_SESSION['password'] = $password;

                    foreach ($users as $user) {
                        if($user['email'] == $email){
                            $token = (new DBConnection())->setToken($email);
                            $body = "<h5>C'é stato un tentativo di modifica della password di questo account.</h5> Se sei stato te per reimpostare la tua password premi sul seguente link: <br><a href='" . URL . "reset/resetPassword/" . $token . "'>Reimposta la tua password</a>";
                            if($mm->sendMail($email, $body, "Grotti Ticinesi - Reimposta la tua password")){
                                $_SESSION['mail_sent'] = $email;
                                header('Location: ' . URL . 'reset');
                                exit();
                            }
                        }
                    }
                    array_push($errors, "L'email non è in uso da nessun account");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'reset');
                    exit();
                }else{
                    array_push($errors, "Le password devono essere uguali");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'reset');
                    exit();
                }
            }
        }
    }

    public function resetPassword($token){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";

        $im = new InputManager();
        $token = filter_var($im->checkInput($token), FILTER_SANITIZE_STRING);

        if(isset($_SESSION['mail_sent']) && isset($_SESSION['password'])){
            $user = (new DBConnection())->getUser($_SESSION['mail_sent']);
            if($user['reset_token'] == $token){
                (new DBConnection())->setPassword($_SESSION['mail_sent'], $_SESSION['password']);
                $_SESSION['password_change'] = true;
                unset($_SESSION['mail_sent']);
            }else{
                unset($_SESSION['mail_sent']);
            }
            header('Location: ' . URL . 'reset');
            exit();
        }else{
            header('Location: ' . URL . 'reset');
            exit();
        }
    }
}