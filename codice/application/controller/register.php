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

        $errors = array();

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) &&
                isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword'])) {

                $exists = false;
                $im = new InputManager();
                $firstname = filter_var($im->checkInput($_POST['firstname']), FILTER_SANITIZE_STRING);
                $lastname = filter_var($im->checkInput($_POST['lastname']), FILTER_SANITIZE_STRING);
                $username = filter_var($im->checkInput($_POST['username']), FILTER_SANITIZE_STRING);
                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

                if(!(strlen($firstname) > 0 && strlen($firstname) < 50)){
                    array_push($errors, "Il nome deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($lastname) > 0 && strlen($lastname) < 50)){
                    array_push($errors, "Il cognome deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($username) > 0 && strlen($username) < 50)){
                    array_push($errors, "Lo username deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($email) > 0 && strlen($email) < 50)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");
                }
                if(!(strlen($password) >= 8)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                }

                if(count($errors) != 0){
                    $_SESSION['errors'] = $errors;
                    $data = array(
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'email' => $email
                    );
                    $_SESSION['data'] = $data;
                    header('Location: ' . URL . 'register');
                }

                if($password == $repassword) {

                    $db = (new db_connection)->getUsers();

                    foreach ($db as $row) {
                        if ($row['email'] == $email) {
                            array_push($errors, "L'email è già in uso");
                            $exists = true;
                        }
                    }
                    if(!$exists) {
                        (new db_connection())->addUser($firstname, $lastname, $username, $email, $password);
                        header('Location: ' . URL . 'login');
                    }

                }else{
                    array_push($errors, "Le password devono essere uguali");
                    $_SESSION['errors'] = $errors;
                    $data = array(
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'email' => $email
                    );
                    $_SESSION['data'] = $data;
                    header('Location: ' . URL . 'register');
                }
            }else{
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'register');
            }
        }
    }
}
