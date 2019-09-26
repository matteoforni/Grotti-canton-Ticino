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
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
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
        $db = $this->getConnection();
        $query = $db->prepare('insert into utente(email, nome, cognome, username, password, nome_ruolo) values (":email", ":firstname", ":lastname", ":username", ":password" , ":nome_ruolo")');

        $password = hash('sha256', $password);
        $type = "utente";

        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':nome_ruolo', $type, PDO::PARAM_STR);

        $query->execute();
    }

    /**
     * Funzione che ritorna tutti i grotti.
     * @return bool|PDOStatement La query al database.
     */
    public function getGrotti(){
        $db = $this->getConnection();
        $query = $db->prepare('SELECT * from grotto;');
        $query->execute();
        return $query;
    }
}