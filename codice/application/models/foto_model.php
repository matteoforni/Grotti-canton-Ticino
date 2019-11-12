<?php


class foto_model
{
    private $_connection;

    public function __construct()
    {
        require_once "./application/models/DBConnection.php";
        $this->_connection = (new DBConnection)->getConnection();
    }

    /**
     * Funzione che ritorna le immagini relative al grotto con l'id passato.
     * @param $id L'id del grotto desiderato.
     * @return array Le immagini relative al grotto.
     */
    public function getImages($id){
        try{
            $query = $this->_connection->prepare('SELECT * FROM foto WHERE grotto=?');
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
     * Funzione che consente di aggiungere un'immagine al database.
     * @param $path string Il percorso dove è salvata l'immagine.
     * @param $grotto int L'id del grotto a cui associare l'immagine.
     */
    public function addImage($path, $grotto){
        try{
            $query = $this->_connection->prepare('INSERT INTO foto(path, grotto) VALUES (?, ?)');
            $query->bindParam(1, $path, PDO::PARAM_STR);
            $query->bindParam(2, $grotto, PDO::PARAM_INT);
            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }

    /**
     * Funzione che ritorna l'immagine con l'id passato come parametro.
     * @param $id int L'id dell'immagine da ritornare.
     * @return mixed L'immagine desiderata.
     */
    public function getImage($id){
        try{
            $query = $this->_connection->prepare('SELECT * FROM foto WHERE id=?');
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
     * Funzione che consente di eliminare una foto.
     * @param $id int L'id della foto.
     */
    public function delete($id){
        try{
            $query = $this->_connection->prepare('DELETE FROM foto WHERE id=?');

            $query->bindParam(1, $id, PDO::PARAM_INT);

            $query->execute();
        }catch (Exception $e){
            $_SESSION['warning'] = $e->getCode() . " - " . $e->getMessage();
            header('Location: ' . URL . 'warning');
            exit();
        }
    }
}