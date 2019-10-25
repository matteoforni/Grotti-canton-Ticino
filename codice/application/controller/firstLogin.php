<?php


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
        require_once "./application/models/DBConnection.php";
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
                    (new DBConnection)->setPassword($email, $password);
                    (new DBConnection)->setFirstLogin($email);
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