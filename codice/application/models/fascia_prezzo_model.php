<?php


class fascia_prezzo_model
{
    /**
     * @var PDO Attributo contenente la connessione al database
     */
    private $_connection;

    /**
     * fascia_prezzo_model constructor.
     */
    public function __construct()
    {
        require_once "./application/models/DBConnection.php";
        $this->_connection = (new DBConnection)->getConnection();
    }

    /**
     * Funzione che ritorna tutte le fasce di prezzo nel database.
     * @return array L'array con tutte le fasce di prezzo
     */
    public function getFascePrezzo(){
        try{
            $query = $this->_connection->prepare('SELECT * FROM fascia_prezzo');
            $query->execute();
            return $query->fetchAll();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}