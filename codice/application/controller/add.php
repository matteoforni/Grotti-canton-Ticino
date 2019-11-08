<?php


class Add
{
    public function index()
    {
        require_once "./application/models/DBConnection.php";
        $query = (new DBConnection)->getFascePrezzo();
        $_SESSION['fasce_prezzo'] = $query;
        if(isset($_SESSION['user'])) {
            if ($_SESSION['user']['nome_ruolo'] == 'admin') {
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("add/index");
                ViewLoader::load("_templates/footer");
            } elseif ($_SESSION['user']['nome_ruolo'] == 'utente') {
                ViewLoader::load("_templates/header_user");
                ViewLoader::load("add/index");
                ViewLoader::load("_templates/footer");
            }
        }else{
            ViewLoader::load("_templates/header_base");
            ViewLoader::load("home/index");
            ViewLoader::load("_templates/footer");
        }
    }

    public function addGrotto(){
        require_once "./application/models/DBConnection.php";
        require_once "./application/models/input_manager.php";
        $errors = array();
        $exists = false;
        unset($_SESSION['errors']);

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['cap']) && !empty($_POST['cap'])
                && isset($_POST['paese']) && !empty($_POST['paese']) && isset($_POST['via']) && !empty($_POST['via'])
                && isset($_POST['no_civico']) && !empty($_POST['no_civico']) && isset($_POST['telefono']) && !empty($_POST['telefono'])
                && isset($_POST['fascia_prezzo']) && !empty($_POST['fascia_prezzo'])) {

                //genero un nuovo InputManager e testo gli inserimenti
                $im = new InputManager();

                $name = filter_var($im->checkInputSpace($_POST['name']), FILTER_SANITIZE_STRING);
                $cap = filter_var($im->checkInput($_POST['cap']), FILTER_SANITIZE_NUMBER_INT);
                $paese = filter_var($im->checkInputSpace($_POST['paese']), FILTER_SANITIZE_STRING);
                $via = filter_var($im->checkInputSpace($_POST['via']), FILTER_SANITIZE_STRING);
                $no_civico = filter_var($im->checkInput($_POST['no_civico']), FILTER_SANITIZE_STRING);
                $telefono = filter_var($im->checkInput($_POST['telefono']), FILTER_SANITIZE_STRING);
                $fascia_prezzo = filter_var($im->checkInput($_POST['fascia_prezzo']), FILTER_SANITIZE_STRING);
                $lat = filter_var($im->checkInput($_POST['lat']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $lon = filter_var($im->checkInput($_POST['lng']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                //verifico che la lunghezza dei campi corrisponda con quella consentita
                if(!(strlen($name) > 0 && strlen($name) <= 50)){
                    array_push($errors, "Il nome deve essere lungo tra 1 e 50 caratteri");
                }
                if(!(strlen($paese) > 0 && strlen($paese) <= 50)){
                    array_push($errors, "Il paese deve essere lungo tra 1 e 50 caratteri");
                }
                if(!(strlen($via) > 0 && strlen($via) <= 50)){
                    array_push($errors, "La via deve essere lunga tra 1 e 50 caratteri");
                }
                if(!(strlen($no_civico) > 0 && strlen($no_civico) <= 10)){
                    array_push($errors, "Il numero civico deve essere lungo tra 1 e 10 caratteri");
                }
                if(!(strlen($telefono) > 0 && strlen($telefono) <= 20)){
                    array_push($errors, "Il telefono deve essere lungo tra 1 e 20 caratteri");
                }
                if(!(strlen($fascia_prezzo) > 0 && strlen($fascia_prezzo) <= 50)){
                    array_push($errors, "La fascia di prezzo deve essere lunga tra 1 e 50 caratteri");
                }

                //se sono di lunghezze sbagliate ritorno l'errore
                if(count($errors) != 0){
                    $_SESSION['errors'] = $errors;
                    $data = array(
                        'name' => $name,
                        'cap' => $cap,
                        'paese' => $paese,
                        'via' => $via,
                        'no_civico' => $no_civico,
                        'telefono' => $telefono
                    );
                    $_SESSION['data'] = $data;
                    header('Location: ' . URL . 'add');
                    exit();
                }

                //verifico che la fascia di prezzo esista nel DB
                $fasce_prezzo = (new DBConnection())->getFascePrezzo();
                foreach($fasce_prezzo as $item){
                    //se esiste inserisco il campo nel DB
                    if($fascia_prezzo == $item['nome']){
                        //se l'utente è admin il grotto è già verificato mentre se non lo è il grotto è da verificare
                        if($_SESSION['user']['nome_ruolo'] == 'admin'){
                            (new DBConnection())->addGrotto($name, $lon, $lat, $no_civico, $via, $paese, $cap, $telefono, $fascia_prezzo, 1);
                        }elseif($_SESSION['user']['nome_ruolo'] == 'utente'){
                            (new DBConnection())->addGrotto($name, $lon, $lat, $no_civico, $via, $paese, $cap, $telefono, $fascia_prezzo, 0);
                        }
                        $_SESSION['grotto_aggiunto'] = true;
                        header('Location: ' . URL . 'add');
                        exit();
                    }
                }

                if(!$exists){
                    //se la fascia di prezzo non esiste ritorno un errore
                    array_push($errors, "La fascia di prezzo non esiste");
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . URL . 'add');
                    exit();
                }
            }else{
                //se non vengono inseriti tutti i campi ritorno un errore
                array_push($errors, "Inserire tutti i dati");
                $_SESSION['errors'] = $errors;
                header('Location: ' . URL . 'add');
                exit();
            }
        }
    }

    public function unsetSession(){
        unset($_SESSION['grotto_aggiunto']);
        header('Location: ' . URL . 'add');
        exit();
    }
}