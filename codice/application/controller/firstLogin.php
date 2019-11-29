<?php
require_once "./application/models/utente_model.php";

class FirstLogin
{
    /**
     * Funzione che richiama la pagina di login.
     */
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("firstLogin/index");
        ViewLoader::load("_templates/footer");
    }

    public function changePassword(){
        require_once "./application/models/input_manager.php";

        $errors = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['password']) && !empty($_POST['password']) &&
                isset($_POST['repassword']) && !empty($_POST['repassword']) &&
                isset($_POST['email']) && !empty($_POST['email'])){

                $im = new input_manager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

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
                    header('Location: ' . URL . 'firstLogin');
                    exit();
                }

                if(!(strlen($password) >= 8)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                    $_SESSION['errors'] = $errors;
                    print_r($_SESSION['errors']);
                    header('Location: ' . URL . 'firstLogin');
                    exit();
                }

                if($password == $repassword){
                    (new utente_model)->setPassword($email, $password);
                    (new utente_model)->setFirstLogin($email);
                    header('Location: ' . URL . 'login');
                    exit();
                }else{
                    array_push($errors, "Le password devono essere uguali");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'firstLogin');
                    exit();
                }
            }else{
                array_push($errors, "Inserire la nuova password");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'firstLogin');
                exit();
            }
        }
    }
}