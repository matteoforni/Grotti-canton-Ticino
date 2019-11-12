<?php


class utente_model
{
    private $_connection;

    public function __construct()
    {
        require_once "./application/models/DBConnection.php";
        $this->_connection = (new DBConnection)->getConnection();
    }

    /**
     * Funzione che ritorna tutti gli utenti.
     * @return array La query al database.
     */
    public function getUsers(){

        try {
            $query = $this->_connection->prepare('SELECT * from utente');
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
            $query = $this->_connection->prepare('SELECT * FROM utente where email=?');
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
            $query = $this->_connection->prepare('INSERT INTO utente(email, nome, cognome, username, password, nome_ruolo, first_login) VALUES (?, ?, ?, ?, ?, ?, ?)');

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
     * Funzione che imposta un token di reset della password all'utente.
     * @param $email string L'email dell'utente a cui impostare il token.
     * @return string Il token impostato.
     */
    public function setToken($email){
        try{
            $query = $this->_connection->prepare('UPDATE utente SET reset_token=? WHERE email=?');

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
            $query = $this->_connection->prepare('UPDATE utente SET password=? WHERE email=?');

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
     * Funzione che consente di modificare uno dei campi di un utente.
     * @param $email string L'email dell'utente.
     * @param $campo string Il campo che si vuole modificare.
     * @param $valore string Il valore che si vuole impostare al campo.
     */
    public function updateUtente($email, $campo, $valore){
        try{
            $stmt = "UPDATE utente SET " . $campo . "=? WHERE email=?";
            $query = $this->_connection->prepare($stmt);

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
     * Funzione che consente di impostare a false il parametro first_login.
     * @param $email string L'email dell'utente da modificare.
     */
    public function setFirstLogin($email){
        try{
            $query = $this->_connection->prepare('UPDATE utente SET first_login=0 WHERE email=?');
            $query->bindParam(1, $email, PDO::PARAM_STR);
            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna l'utente che ha impostato il token passato.
     * @param $token string Il token per cui cercare l'utente.
     * @return mixed L'utente desiderato.
     */
    public function getUserFromToken($token){
        try{
            $query = $this->_connection->prepare('SELECT * FROM utente where reset_token=?');
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