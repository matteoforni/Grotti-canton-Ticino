<?php


class db_connection
{
    private $_connection;

    /**
     * Funzione che ritorna la connessione con il database.
     * @return PDO La connessione con il database.
     */
    public function getConnection()
    {
        if($this->_connection == null){
            try{
                $this->_connection = new PDO(DSN, USER, PASSWORD);
                return $this->_connection;
            }catch(PDOException $e){
                $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
                header('Location: ' . URL . 'warning');
                exit();
            }
        }
    }

    /**
     * Funzione che ritorna tutti gli utenti.
     * @return bool|PDOStatement La query al database.
     */
    public function getUsers(){
        try {
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * from utente');
            $query->execute();
            return $query;
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna un utente in base all'email passata.
     * @param $email string L'email dell'utente da ritornare.
     * @return array Le informazioni dell'utente.
     */
    public function getUser($email){
        try{
            $db = $this->getConnection();

            $query = $db->prepare('SELECT * FROM utente where email=?');
            $query->bindParam(1, $email, PDO::PARAM_STR);

            $query->execute();

            return $query->fetch();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che inserisce un utente nel database.
     * @param $firstname string Il nome dell'utente da inserire nel db.
     * @param $lastname string Il cognome dell'utente da inserire nel db.
     * @param $username string Lo username dell'utente da inserire nel db.
     * @param $email string L'email dell'utente da inserire nel db.
     * @param $password string La password dell'utente da inserire nel db.
     */
    public function addUser($firstname, $lastname, $username, $email, $password){
        try {
            $db = $this->getConnection();
            $query = $db->prepare('INSERT INTO utente(email, nome, cognome, username, password, nome_ruolo) VALUES (?, ?, ?, ?, ? , ?)');

            $password = hash('sha256', $password);
            $type = "utente";

            $query->bindParam(1, $email, PDO::PARAM_STR);
            $query->bindParam(2, $firstname, PDO::PARAM_STR);
            $query->bindParam(3, $lastname, PDO::PARAM_STR);
            $query->bindParam(4, $username, PDO::PARAM_STR);
            $query->bindParam(5, $password, PDO::PARAM_STR);
            $query->bindParam(6, $type, PDO::PARAM_STR);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna tutti i grotti.
     * @return bool|PDOStatement La query al database.
     */
    public function getGrotti(){
        try {
            $verificato = true;
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * from grotto WHERE verificato=?;');
            $query->bindParam(1, $verificato);
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna un grotto in base all'id passato.
     * @param $id L'id del grotto desiderato.
     * @return array Le informazioni relative al grotto.
     */
    public function getGrotto($id){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * FROM grotto WHERE id=?');
            $query->bindParam(1, $id);
            $query->execute();
            return $query->fetch();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna le immagini relative al grotto con l'id passato.
     * @param $id L'id del grotto desiderato.
     * @return array Le immagini relative al grotto.
     */
    public function getImages($id){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * FROM foto WHERE grotto=?');
            $query->bindParam(1, $id);
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    public function getFascePrezzo(){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * FROM fascia_prezzo');
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}