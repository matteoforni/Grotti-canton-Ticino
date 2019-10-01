<?php
class Login
{
    /**
     * Funzione che richiama la pagina principale caricando dal model i grotti.
     */
    public function index()
    {
        //Show index page
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("login/index");
        ViewLoader::load("_templates/footer");
    }

    public function checkLogin(){
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";

        $errors = array();

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
                $im = new InputManager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);

                if(!(strlen($email) > 0 && strlen($email) < 50)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");

                }
                if(!(strlen($password) >= 8)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                }

                if(count($errors) != 0){
                    $_SESSION['warning'] = $errors;
                    header('Location: ' . URL . 'register');
                    return false;
                }else{
                    $db = (new db_connection)->getUsers();
                    $password = hash('sha256', $password);
                    foreach ($db->fetchAll() as $row) {
                        if ($row['email'] == $email) {
                            $_SESSION['user'] = (new db_connection)->getUser($email);
                            if($row['password'] == $password){
                                $_SESSION['user'] = (new db_connection)->getUser($email);
                                if($row['nome_ruolo'] == 'admin'){
                                    header('Location: ' . URL . 'admin');
                                }elseif($row['nome_ruolo'] == 'utente'){
                                    header('Location: ' . URL . 'home');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
