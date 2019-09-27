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
                header('Location: ' . URL . 'error');
            }
        }
    }

    /**
     * Funzione che ritorna tutti gli utenti.
     * @return bool|PDOStatement La query al database.
     */
    public function getUsers(){
        $db = $this->getConnection();
        $query = $db->prepare('SELECT * from utente');
        $query->execute();
        return $query;
    }


    public function getUser(){

    }

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
            header('Location: ' . URL . 'warning');
        }
    }

    /**
     * Funzione che ritorna tutti i grotti.
     * @return bool|PDOStatement La query al database.
     */
    public function getGrotti(){
        try {
            $db = $this->getConnection();
            $query = $db->prepare('SELECT * from grotto;');
            $query->execute();
            return $query;
        }catch (Exception $e){
            header('Location: ' . URL . 'error');
        }
    }
}