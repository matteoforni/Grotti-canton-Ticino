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
        //richiamo le classi di cui avrò bisogno
        require_once "./application/models/db_connection.php";
        require_once "./application/models/input_manager.php";

        $errors = array();

        //verifico il metodo di richiesta
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //verifico che i campi siano impostati e che non siano stringhe vuote
            if (isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['lastname'])
                && isset($_POST['username']) && !empty($_POST['username']) &&
                isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']) &&
                isset($_POST['repassword']) && !empty($_POST['repassword']) ) {

                //genero un nuovo InputManager e testo gli inserimenti
                $exists = false;
                $im = new InputManager();
                $firstname = filter_var($im->checkInputSpace($_POST['firstname']), FILTER_SANITIZE_STRING);
                $lastname = filter_var($im->checkInputSpace($_POST['lastname']), FILTER_SANITIZE_STRING);
                $username = filter_var($im->checkInput($_POST['username']), FILTER_SANITIZE_STRING);
                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

                //verifico che la lunghezza dei campi corrisponda con quella consentita
                if(!(strlen($firstname) > 0 && strlen($firstname) <= 50)){
                    array_push($errors, "Il nome deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($lastname) > 0 && strlen($lastname) <= 50)){
                    array_push($errors, "Il cognome deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($username) > 0 && strlen($username) <= 50)){
                    array_push($errors, "Lo username deve essere lungo tra gli 1 e 50 caratteri");
                }
                if(!(strlen($email) > 0 && strlen($email) <= 50)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");
                }
                if(!(strlen($password) >= 8)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                }

                //se sono di lunghezze sbagliate ritorno l'errore
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
                    exit();
                }

                //verifico che la password sia la stessa in entrambi i campi
                if($password == $repassword) {

                    $db = (new db_connection)->getUsers();
                    //verifico che l'email non sia già in uso
                    foreach ($db->fetchAll() as $row) {
                        if ($row['email'] == $email) {
                            array_push($errors, "L'email è già in uso");
                            $exists = true;
                        }
                    }
                    //se non esiste inserisco il nuovo utente nel db
                    if(!$exists) {
                        (new db_connection())->addUser($firstname, $lastname, $username, $email, $password);
                        unset($_POST);
                        header('Location: ' . URL . 'login');
                        exit();
                    }else{
                        //se è già in uso ritorno l'errore
                        $_SESSION['errors'] = $errors;
                        $data = array(
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'username' => $username,
                            'email' => $email
                        );
                        $_SESSION['data'] = $data;
                        header('Location: ' . URL . 'register');
                        exit();
                    }
                //se le password non sono uguali ritorno l'errore
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
                    exit();
                }
            }else{
                //se non sono stati inseriti tutti i dati ritorno l'errore
                array_push($errors, "Inserire tutti i dati");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'register');
                exit();
            }
        }
    }
}
