<?php
require_once "./application/models/utente_model.php";

class FirstLogin
{
    /**
     * Funzione che richiama la pagina del primo login
     */
    public function index()
    {
        //Mostro la pagina da mostrare al primo login
        ViewLoader::load("_templates/header_base");
        ViewLoader::load("firstLogin/index");
        ViewLoader::load("_templates/footer");
    }

    /**
     * Funzione che consente ad un utente di cambiare la password al primo login
     */
    public function changePassword(){
        require_once "./application/models/input_manager.php";

        //Genero un array che conterà gli eventuali errori
        $errors = array();

        //Verifico il metodo di richiesta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Verifico che tutti i campi siano stati compilati e che non siano vuoti
            if(isset($_POST['password']) && !empty($_POST['password']) &&
                isset($_POST['repassword']) && !empty($_POST['repassword']) &&
                isset($_POST['email']) && !empty($_POST['email'])){

                //Creo un nuovo input manager e testo i campi inseriti
                $im = new input_manager();

                $email = filter_var($im->checkInput($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var($im->checkInput($_POST['password']), FILTER_SANITIZE_STRING);
                $repassword = filter_var($im->checkInput($_POST['repassword']), FILTER_SANITIZE_STRING);

                //Verifico che la lunghezza dei campi corrisponda con quella consentita e che non contengano valori non validi
                if(!(strlen($email) > 0 && strlen($email) <= 50) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors, "L'email deve essere formattata nel seguente modo: indirizzo@dominio.xx");
                }
                if(!(strlen($password) >= 8) || !preg_match('/^[\p{L}a-zA-Z\d._\-*%&!?$@+#+,;:]+$/', $password)){
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                }

                //Se sono di lunghezze sbagliate o contengono caratteri illegali ritorno l'errore
                if(count($errors) != 0){
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'firstLogin');
                    exit();
                }

                //Verifico che la password sia di almeno 8 caratteri
                if(!(strlen($password) >= 8)){
                    //Genero l'errore
                    array_push($errors, "La password deve essere almeno lunga 8 caratteri");
                    $_SESSION['errors'] = $errors;

                    //Riporto l'utente alla pagina per mostrargli l'errore
                    header('Location: ' . URL . 'firstLogin');
                    exit();
                }

                //Verifico che le due password siano uguali
                if($password == $repassword){
                    //Imposto la nuova password nel database
                    (new utente_model)->setPassword($email, $password);
                    (new utente_model)->setFirstLogin($email);

                    //Indirizzo l'utente alla pagina di login
                    header('Location: ' . URL . 'login');
                    exit();
                }else{
                    //Se sono diverse genero l'errore
                    array_push($errors, "Le password devono essere uguali");
                    $_SESSION['errors'] = $errors;

                    //Riporto l'utente alla pagina per mostrargli l'errore
                    header('Location: ' . URL . 'firstLogin');
                    exit();
                }
            }else{
                //Se non vengono inseriti tutti i dati genero l'errore
                array_push($errors, "Inserire la nuova password");
                $_SESSION['errors'] = $errors;

                //Riporto l'utente alla pagina per mostrargli l'errore
                header('Location: ' . URL . 'firstLogin');
                exit();
            }
        }
    }
}