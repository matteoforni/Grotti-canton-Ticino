<?php


class DBConnection
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
            return $query->fetchAll();
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
    public function addUser($firstname, $lastname, $username, $email, $password, $firstLogin){
        try {
            $db = $this->getConnection();
            $query = $db->prepare('INSERT INTO utente(email, nome, cognome, username, password, nome_ruolo, first_login) VALUES (?, ?, ?, ?, ?, ?, ?)');

            $password = hash('sha256', $password);
            $type = "utente";

            $query->bindParam(1, $email, PDO::PARAM_STR);
            $query->bindParam(2, $firstname, PDO::PARAM_STR);
            $query->bindParam(3, $lastname, PDO::PARAM_STR);
            $query->bindParam(4, $username, PDO::PARAM_STR);
            $query->bindParam(5, $password, PDO::PARAM_STR);
            $query->bindParam(6, $type, PDO::PARAM_STR);
            $query->bindParam(7, $firstLogin, PDO::PARAM_BOOL);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna tutti i grotti.
     * @param bool validati Se si vogliono ottenere i grotti validati o quelli non ancora validati
     * @return array La query al database.
     */
    public function getGrotti($validati){
        try {
            if($validati){
                $verificato = 1;
            }else{
                $verificato = 0;
            }

            $db = $this->getConnection();
            $query = $db->prepare('SELECT * from grotto WHERE verificato=?;');
            $query->bindParam(1, $verificato, PDO::PARAM_BOOL);
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
            $query->bindParam(1, $id, PDO::PARAM_INT);
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
            $query->bindParam(1, $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna tutte le fasce di prezzo nel database.
     * @return array L'array con tutte le fasce di prezzo
     */
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

    /**
     * Funzione che ritorna tutti i ruoli presenti nel database.
     * @return array L'array di ruoli.
     */
    public function getRuoli(){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * FROM ruolo');
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che aggiunge un nuovo grotto al database.
     * @param $nome string Il nome del grotto.
     * @param $lon float La longitudine del grotto.
     * @param $lat float La latitudine del grotto.
     * @param $no_civico string Il numero civico.
     * @param $via string La via dove si trova il grotto.
     * @param $paese string Il paese in cui si trova il grotto.
     * @param $cap int Il CAP del paese.
     * @param $telefono string Il numero di telefono del grotto.
     * @param $fascia_prezzo string La fascia di prezzo del locale.
     * @param $valutazione float La valutazione del grotto.
     * @param $verificato bool Se il grotto è stato verificato da un admin o meno.
     */
    public function addGrotto($nome, $lon, $lat, $no_civico, $via, $paese, $cap, $telefono, $fascia_prezzo, $verificato){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('INSERT INTO grotto(nome, lon, lat, no_civico, via, paese, cap, telefono, fascia_prezzo, verificato) values (?,?,?,?,?,?,?,?,?,?)');

            $query->bindParam(1, $nome, PDO::PARAM_STR);
            $query->bindParam(2, $lon);
            $query->bindParam(3, $lat);
            $query->bindParam(4, $no_civico, PDO::PARAM_STR);
            $query->bindParam(5, $via, PDO::PARAM_STR);
            $query->bindParam(6, $paese, PDO::PARAM_STR);
            $query->bindParam(7, $cap, PDO::PARAM_INT);
            $query->bindParam(8, $telefono, PDO::PARAM_STR);
            $query->bindParam(9, $fascia_prezzo, PDO::PARAM_STR);
            $query->bindParam(10, $verificato, PDO::PARAM_BOOL);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di assegnare un voto ad un grotto.
     * @param $grotto int L'id del grotto che ha ricevuto il voto.
     * @param $utente string L'email dell'utente che ha votato.
     * @param $voto float Il voto da assegnare alla località.
     */
    public function addVoto($grotto, $utente, $voto){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('INSERT INTO voto(email_utente, id_grotto, voto) VALUES (?, ?, ?)');
            $query->bindParam(1, $utente, PDO::PARAM_STR);
            $query->bindParam(2, $grotto, PDO::PARAM_INT);
            $query->bindParam(3, $voto);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che imposta un token di reset della password all'utente.
     * @param $email string L'email dell'utente a cui impostare il token.
     * @return string Il token impostato.
     */
    public function setToken($email){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('UPDATE utente SET reset_token=? WHERE email=?');

            $token = bin2hex(random_bytes(15));

            $query->bindParam(1, $token, PDO::PARAM_STR);
            $query->bindParam(2, $email, PDO::PARAM_STR);

            $query->execute();

            return $token;
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di settare la password di un account. Usata nella parte di recupero della password dimenticata.
     * @param $email string L'email dell'utente da modificare.
     * @param $password string La password da impostare.
     */
    public function setPassword($email, $password){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('UPDATE utente SET password=? WHERE email=?');

            $password = hash('sha256', $password);
            $query->bindParam(1, $password, PDO::PARAM_STR);
            $query->bindParam(2, $email, PDO::PARAM_STR);

            $query->execute();

        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che imposta il valore "verificato" ad 1 (true)
     * @param $id int L'id del grotto da verificare.
     */
    public function setVerificato($id){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('UPDATE grotto SET verificato=? WHERE id=?');

            $validato = 1;

            $query->bindParam(1, $validato, PDO::PARAM_BOOL);
            $query->bindParam(2, $id, PDO::PARAM_INT);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che elimina un utente o un grotto dal database.
     * @param $type string Il tipo di dato da eliminare (utente o grotto).
     * @param $id int/string L'id / l'email del grotto / utente da eliminare.
     */
    public function delete($type, $id){
        try{
            $db = $this->getConnection();
            $query = null;

            if($type == 'grotto'){
                $query = $db->prepare('DELETE FROM grotto WHERE id=?');

                $query->bindParam(1, $id, PDO::PARAM_INT);
            }elseif ($type == 'utente'){
                $query = $db->prepare('DELETE FROM utente WHERE email=?');

                $query->bindParam(1, $id, PDO::PARAM_STR);
            }elseif ($type == 'immagine'){
                $query = $db->prepare('DELETE FROM foto WHERE id=?');

                $query->bindParam(1, $id, PDO::PARAM_INT);
            }

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di modificare uno dei campi di un utente.
     * @param $email string L'email dell'utente.
     * @param $campo string Il campo che si vuole modificare.
     * @param $valore string Il valore che si vuole impostare al campo.
     */
    public function updateUtente($email, $campo, $valore){
        try{
            $db = $this->getConnection();
            $stmt = "UPDATE utente SET " . $campo . "=? WHERE email=?";
            $query = $db->prepare($stmt);

            $query->bindParam(1, $valore, PDO::PARAM_STR);
            $query->bindParam(2, $email, PDO::PARAM_STR);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di modificare uno dei campi di un grotto.
     * @param $id string L'id del grotto.
     * @param $campo string Il campo che si vuole modificare.
     * @param $valore string Il valore che si vuole impostare al campo.
     */
    public function updateGrotto($id, $campo, $valore){
        try{
            $db = $this->getConnection();
            $stmt = "UPDATE grotto SET " . $campo . "=? WHERE id=?";
            $query = $db->prepare($stmt);

            $query->bindParam(1, $valore, PDO::PARAM_STR);
            $query->bindParam(2, $id, PDO::PARAM_INT);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di ottenere il numero di valutazioni effettuate su di un grotto.
     * @param $grotto int Il grotto su cui sono state fatte le votazioni.
     * @return mixed Il risultato della query.
     */
    public function getNoValutazioni($grotto){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('SELECT count(*) FROM voto where id_grotto=?');
            $query->bindParam(1, $grotto, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di impostare a false il parametro first_login.
     * @param $email string L'email dell'utente da modificare.
     */
    public function setFirstLogin($email){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('UPDATE utente SET first_login=0 WHERE email=?');
            $query->bindParam(1, $email, PDO::PARAM_STR);
            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che consente di aggiungere un'immagine al database.
     * @param $path string Il percorso dove è salvata l'immagine.
     * @param $grotto int L'id del grotto a cui associare l'immagine.
     */
    public function addImage($path, $grotto){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('INSERT INTO foto(path, grotto) VALUES (?, ?)');
            $query->bindParam(1, $path, PDO::PARAM_STR);
            $query->bindParam(2, $grotto, PDO::PARAM_INT);
            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    public function getImage($id){
        try{
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * FROM foto WHERE id=?');
            $query->bindParam(1, $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    public function getUserFromToken($token){
        try{
            $db = $this->getConnection();

            $query = $db->prepare('SELECT * FROM utente where reset_token=?');
            $query->bindParam(1, $token, PDO::PARAM_STR);

            $query->execute();

            return $query->fetch();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}