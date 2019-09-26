<?php
class Register
{
    /**
     * Funzione che richiama la pagina principale caricando dal model i grotti.
     */
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("register/index");
        ViewLoader::load("_templates/footer");
    }

    public function createUser(){
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) &&
                isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword'])) {

                $im = new InputManager();
                $firstname = $im->checkInput($_POST['firstname']);
                $lastname = $im->checkInput($_POST['lastname']);
                $username = $im->checkInput($_POST['username']);
                $email = $im->checkInput($_POST['email']);
                $password = $im->checkInput($_POST['password']);
                $repassword = $im->checkInput($_POST['repassword']);

                $exists = true;

                if($password == $repassword) {

                    $db = (new db_connection)->getUsers();

                    foreach ($db as $row) {
                        if ($row['email'] == $email) {
                            echo "L'email è già in uso";
                            return false;
                        }
                    }
                    (new db_connection())->addUser($firstname, $lastname, $username, $email, $password);

                    ViewLoader::load("_templates/header_base");
                    ViewLoader::load("login/index");
                    ViewLoader::load("_templates/footer");

                    return true;
                }else{
                    echo "Le password devono essere uguali";
                }
            }
        }
    }
}
