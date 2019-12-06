<?php


class grotto_model
{
    /**
     * @var PDO Attributo contenente la connessione al database
     */
    private $_connection;

    /**
     * grotto_model constructor.
     */
    public function __construct()
    {
        require_once "./application/models/DBConnection.php";
        $this->_connection = (new DBConnection)->getConnection();
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

            $query = $this->_connection->prepare('SELECT * from grotto WHERE verificato=?;');
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
            $query = $this->_connection->prepare('SELECT * FROM grotto WHERE id=?');
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
     * @param $verificato bool Se il grotto è stato verificato da un admin o meno.
     */
    public function addGrotto($nome, $lon, $lat, $no_civico, $via, $paese, $cap, $telefono, $fascia_prezzo, $verificato){
        try{
            $query = $this->_connection->prepare('INSERT INTO grotto(nome, lon, lat, no_civico, via, paese, cap, telefono, fascia_prezzo, verificato) values (?,?,?,?,?,?,?,?,?,?)');

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
     * Funzione che imposta il valore "verificato" ad 1 (true)
     * @param $id int L'id del grotto da verificare.
     */
    public function setVerificato($id){
        try{
            $query = $this->_connection->prepare('UPDATE grotto SET verificato=? WHERE id=?');

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
     * Funzione che consente di modificare uno dei campi di un grotto.
     * @param $id string L'id del grotto.
     * @param $campo string Il campo che si vuole modificare.
     * @param $valore string Il valore che si vuole impostare al campo.
     */
    public function updateGrotto($id, $campo, $valore){
        try{
            $stmt = "UPDATE grotto SET " . $campo . "=? WHERE id=?";
            $query = $this->_connection->prepare($stmt);

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
     * Funzione che consente di eliminare un grotto.
     * @param $id int L'id del grotto.
     */
    public function delete($id){
        try{
            $query = $this->_connection->prepare('DELETE FROM grotto WHERE id=?');

            $query->bindParam(1, $id, PDO::PARAM_INT);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}