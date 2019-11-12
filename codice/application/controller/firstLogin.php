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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['password']) && !empty($_POST['password']) &&
                isset($_POST['repassword']) && !empty($_POST['repassword']) &&
                isset($_POST['email']) && !empty($_POST['email'])){

                $im = new InputManager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

                if($password == $repassword){
                    echo "password uguali: $password <br>";
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
            }
        }
    }
}