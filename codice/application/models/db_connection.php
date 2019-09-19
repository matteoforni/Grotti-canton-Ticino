<?php


class db_connection
{
    private $_connection;

    private function __construct()
    {
    }

    /**
     * @return La connessione con il database
     */
    public function getConnection()
    {
        if($this->_connection == null){
            try{
                $this->_connection = new PDO(DSN, USER, PASSWORD);
            }catch(PDOException $e){
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
}