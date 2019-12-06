<?php


class ruolo_model
{
    /**
     * @var PDO Attributo contenente la connessione al database
     */
    private $_connection;

    /**
     * ruolo_model constructor.
     */
    public function __construct()
    {
        require_once "./application/models/DBConnection.php";
        $this->_connection = (new DBConnection)->getConnection();
    }

    /**
     * Funzione che ritorna tutti i ruoli presenti nel database.
     * @return array L'array di ruoli.
     */
    public function getRuoli(){
        try{
            $query = $this->_connection->prepare('SELECT * FROM ruolo');
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}