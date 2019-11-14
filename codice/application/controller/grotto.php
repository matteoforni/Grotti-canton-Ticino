<?php
require_once "./application/models/grotto_model.php";
require_once "./application/models/foto_model.php";
require_once "./application/models/voto_model.php";
require_once "./application/models/input_manager.php";

class Grotto
{
    /**
     * Funzione che consente di visualizzare la pagina. Se si è loggati si avrà la possibilità di votare e aggiungere
     * immagini altrimenti non sarà concesso.
     */
    public function index()
    {
        if(isset($_SESSION['user'])){
            //mostro l'index per gli utenti loggati
            if($_SESSION['user']['nome_ruolo'] == 'admin'){
                ViewLoader::load("_templates/header_admin");
                ViewLoader::load("grotto/index");
                ViewLoader::load("_templates/footer");
            }elseif($_SESSION['user']['nome_ruolo'] == 'utente'){
                ViewLoader::load("_templates/header_user");
                ViewLoader::load("grotto/index");
                ViewLoader::load("_templates/footer");
            }
        }else{
            //mostro l'index di base
            ViewLoader::load("_templates/header_base");
            ViewLoader::load("grotto/index");
            ViewLoader::load("_templates/footer");
        }
    }

    /**
     * Funzione che mostra il grotto scelto dalla tabella.
     * @param $id int L'id del grotto premuto.
     */
    public function show($id){
        if(isset($_SESSION['grotto'])){
            unset($_SESSION['grotto']);
        }
        if(isset($_SESSION['img'])){
            unset($_SESSION['img']);
        }
        if(isset($_SESSION['noValutazioni'])){
            unset($_SESSION['noValutazioni']);
        }

        //Carico dal DB il grotto e le sue immagini
        $im = new input_manager();
        $id = filter_var($im->checkInput($id), FILTER_SANITIZE_NUMBER_INT);

        $grotto = (new grotto_model)->getGrotto($id);
        $images = (new foto_model)->getImages($id);
        $noValutazioni = (new voto_model)->getNoValutazioni($id);

        //Salvo i valori nelle sessioni
        $_SESSION['grotto'] = $grotto;
        $_SESSION['img'] = $images;
        $_SESSION['noValutazioni'] = $noValutazioni[0]['count(*)'];
        header('Location: ' . URL . 'grotto');
        exit();
    }

    /**
     * Funzione che consente di votare un grotto.
     */
    public function vota(){
        //Carico le classi necessarie e istanzio gli oggetti relativi
        require_once "./application/models/input_manager.php";
        $im = new input_manager();

        //Genero l'array contenente gli errori
        $errors = array();

        //Prendo i dati del grotto
        $grotto = $_SESSION['grotto']['id'];

        //Verifico che la richiesta venga fatta con il metodo corretto
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //Verifico che tutti i dati siano stati impostati
            if(isset($_POST['val']) && !empty($_POST['val']) && isset($_SESSION['user'])){

                //Prendo i dati dell'utente e la votazione
                $utente = $_SESSION['user']['email'];
                $valutazione = filter_var($im->checkInput($_POST['val']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                if($valutazione >= 0 && $valutazione <= 5) {
                    //Inserisco il voto nel DB
                    (new voto_model)->addVoto($grotto, $utente, $valutazione);
                }else{
                    //se non vengono inseriti i dati in maniera corretta
                    array_push($errors, "Inserire una votazione valida");
                    $_SESSION['errors'] = $errors;
                }
            }else{
                array_push($errors, "Inserire una votazione valida");
                $_SESSION['errors'] = $errors;
            }
            header('Location: ' . URL . 'grotto/show/' . $grotto);
            exit();
        }
    }

    /**
     * Funzione che consente di caricare un'immagine relativa al grotto scelto.
     */
    public function caricaImmagine(){
        //Carico le classi necessarie e istanzio gli oggetti relativi.
        require_once "./application/models/input_manager.php";
        $im = new input_manager();

        //Genero l'array contenente gli eventuali errori.
        $imgErrors = array();

        //Verifico se la richiesta è stata fatta correttamente.
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit'])) {
                //Verifico che sia stata scelta un'immagine e che non ci siano stati errori nell'operazione.
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    //Prendo l'id del grotto
                    $grotto = filter_var($im->checkInput($_SESSION['grotto']['id']), FILTER_SANITIZE_NUMBER_INT);

                    //Prendo dall'immagine gli attributi necessari.
                    $filename = $_FILES['image']['name'];
                    $fileTmpPath = $_FILES['image']['tmp_name'];
                    $fileNameParts = explode(".", $filename);
                    $extension = strtolower(end($fileNameParts));

                    //Imposto le estensioni accettate.
                    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
                    //Verifico che l'estensione sia tra quelle concesse.
                    if (in_array($extension, $allowedfileExtensions)) {
                        //Cambio il nome del file con l'hash (md5) del contenuto dello stesso file.
                        $filename = hash_file('md5', $fileTmpPath) . '.' . $extension;

                        //Creo la path dove salvare il file.
                        $path = IMG_PATH . $filename;

                        //Verifico che il file non esista già.
                        if(!file_exists($path)) {
                            //Provo a spostare il file dalla memoria temporanea alla path scelta in precedenza.
                            if(move_uploaded_file($fileTmpPath, $path)) {
                                //Se tutto è andato a buon fine aggiuno l'immagine al database.
                                (new foto_model)->addImage($path, $grotto);
                                if(isset($_SESSION['img'])){
                                    unset($_SESSION['img']);
                                }
                                $images = (new foto_model)->getImages($grotto);
                                $_SESSION['img'] = $images;
                            }else{
                                //Genero il messaggio d'errore
                                array_push($imgErrors, "Impossibile caricare il file");
                                $_SESSION['imgErrors'] = $imgErrors;
                            }
                        }else{
                            //Genero il messaggio d'errore
                            array_push($imgErrors, "L'immagine scelta è già associata al grotto");
                            $_SESSION['imgErrors'] = $imgErrors;
                        }
                    }else{
                        //Genero il messaggio d'errore
                        array_push($imgErrors, "Scegliere un formato accettato [jpg, gif, png, jpeg]");
                        $_SESSION['imgErrors'] = $imgErrors;
                    }
                }else{
                    //Genero il messaggio d'errore
                    array_push($imgErrors, "Nessuna immagine scelta");
                    $_SESSION['imgErrors'] = $imgErrors;
                }
                header('Location: ' . URL . 'grotto');
                exit();
            }
        }
    }
}