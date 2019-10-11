<?php
class Reset
{
    /**
     * Funzione che richiama la pagina di reset della password.
     */
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("login/reset");
        ViewLoader::load("_templates/footer");
    }

    public function sendEmail(){
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";
        require_once "./application/models/mail_manager.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['email']) && !empty($_POST['email'])) {

                //genero un nuovo InputManager e testo gli inserimenti
                $im = new InputManager();
                $mm = new MailManager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $users = (new db_connection())->getUsers();

                foreach ($users as $user) {
                    if($user['email'] == $email){
                        $token = (new db_connection())->setToken($email);
                        $mm->sendMail($email, $token);
                        $_SESSION['mail_sent'] = $email;
                        return true;
                    }
                }
            }
        }
    }
}