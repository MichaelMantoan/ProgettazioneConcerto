<?php

require 'DBMng.php';


class Concerto
{

    private $id;
    private $_codice;
    private $_titolo;
    private $_descrizione;
    private $_data;

    public function __construct($codice,$titolo,$descrizione,$data)
    {
        $this->_codice = $codice;
        $this->_titolo = $titolo;
        $this->_descrizione = $descrizione;
        $this->_data = $data;   
    }

    public function __getID()
    {
        return $this->id;
    }

    public function __getCodice()
    {
        return $this->_codice;
    }
    public function __getTitolo()
    {
        return $this->_titolo;
    }
    public function __getDescrizione()
    {
        return $this->_descrizione;
    }
    public function __getData()
    {
        return $this->_data;
    }
    
    public static function Create($concerto)
    {
        $db = new DBMng("configS.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");
        $stm = $pdo->prepare("INSERT INTO concerti (codice, titolo, descrizione, data) VALUES (:codice, :titolo, :descrizione, :data)");

        $codice = $concerto['codice'];
        $titolo = $concerto['titolo'];
        $descrizione = $concerto['descrizione'];
        $data = $concerto['data'];

        $stm->bindParam(':codice', $codice);
        $stm->bindParam(':titolo', $titolo);
        $stm->bindParam(':descrizione', $descrizione);
        $stm->bindParam(':data', $data);

        $stm->execute();

        $stm = $pdo->prepare("SELECT * FROM Organizzazione_Concerto.concerti ORDER BY ID DESC LIMIT 1");
        $row = $stm->fetch(PDO::FETCH_OBJ);

        return $row;
    }
    
    public function Delete()
    {
        if (!$this->id) {
            // Non eseguire la query DELETE se l'ID non è impostato.
            return false;
        }
    
        $db = new DBMng("configS.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");
    
        $stm = $pdo->prepare("DELETE FROM Organizzazione_Concerto.concerti WHERE id = :id");
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        $stm->execute();
        return true;
    }

    public static function Find($id)
    {
        $db = new DBMng("configS.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");
    
        $stm = $pdo->prepare("SELECT * FROM Organizzazione_Concerto.concerti WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
    
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_OBJ);

        if(!$result) 
        {
            return null; // Nessun concerto trovato con l'ID specificato
        }
        $concerto = new Concerto($result->codice, $result->titolo, $result->descrizione, $result->data);
        $concerto->id = $result->id;  // Imposta l'ID dell'oggetto
        // Creiamo e restituiamo un nuovo oggetto Concerto basato sui dati recuperati.
        return $concerto;
      
    }

    public function show()
    {
        return "Concerto: 
        Codice: {$this->_codice}
        Titolo: {$this->_titolo}
        Descrizione: {$this->_descrizione}
        Data: {$this->_data}";
    }
}
?>