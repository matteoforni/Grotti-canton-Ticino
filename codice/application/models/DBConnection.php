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
}
