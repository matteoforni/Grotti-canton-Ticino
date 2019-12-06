<?php


class voto_model
{
    /**
     * @var PDO Attributo contenente la connessione al database
     */
    private $_connection;

    /**
     * voto_model constructor.
     */
    public function __construct()
    {
        require_once "./application/models/DBConnection.php";
        $this->_connection = (new DBConnection)->getConnection();
    }

    /**
     * Funzione che consente di assegnare un voto ad un grotto.
     * @param $grotto int L'id del grotto che ha ricevuto il voto.
     * @param $utente string L'email dell'utente che ha votato.
     * @param $voto float Il voto da assegnare alla località.
     */
    public function addVoto($grotto, $utente, $voto){
        try{
            $query = $this->_connection->prepare('INSERT INTO voto(email_utente, id_grotto, voto) VALUES (?, ?, ?)');
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
     * Funzione che consente di ottenere il numero di valutazioni effettuate su di un grotto.
     * @param $grotto int Il grotto su cui sono state fatte le votazioni.
     * @return mixed Il risultato della query.
     */
    public function getNoValutazioni($grotto){
        try{
            $query = $this->_connection->prepare('SELECT count(*) FROM voto where id_grotto=?');
            $query->bindParam(1, $grotto, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}