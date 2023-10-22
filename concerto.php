<?php

require 'db_manager.php';


class Concerto
{

    private $id;
    private $codice;
    private $titolo;
    private $descrizione;
    private $data;

    public function __construct($codice, $titolo, $descrizione, $data_concerto)
    {
        $this->codice = $codice;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->data = $data_concerto;
    }

    //METODI GET

    public function __getID()
    {
        return $this->id;
    }

    public function __getCodice()
    {
        return $this->codice;
    }
    public function __getTitolo()
    {
        return $this->titolo;
    }
    public function __getDescrizione()
    {
        return $this->descrizione;
    }
    public function __getData()
    {
        return $this->data;
    }

    //METODI SET

    public function __setID($id)
    {
        $this->id = $id;
    }
    public function __setCodice($codice)
    {
        $this->codice = $codice;
    }
    public function __setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }
    public function __setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }
    public function __setData($data)
    {
        $this->data = $data;
    }

    //METODI STATICI

    public static function Create($concerto)
    {
        $db = new DbManager("config.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");
        $stm = $pdo->prepare("INSERT INTO concerti (codice, titolo, descrizione, data_concerto) VALUES (:codice, :titolo, :descrizione, :data_concerto)");

        $codice = $concerto['codice'];
        $titolo = $concerto['titolo'];
        $descrizione = $concerto['descrizione'];
        $data = $concerto['data_concerto'];

        $stm->bindParam(':codice', $codice);
        $stm->bindParam(':titolo', $titolo);
        $stm->bindParam(':descrizione', $descrizione);
        $stm->bindParam(':data_concerto', $data);

        $stm->execute();

        $stm = $pdo->prepare("SELECT * FROM Organizzazione_Concerti.concerti ORDER BY ID DESC LIMIT 1");
        $row = $stm->fetchobject();

        return $row;
    }

    public static function Find($id)
    {
        $db = new DbManager("config.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");

        $stm = $pdo->prepare("SELECT * FROM Organizzazione_Concerti.concerti WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);

        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_OBJ);

        if (!$result) {
            return null; // Nessun concerto trovato con l'ID specificato
        }
        $concerto = new Concerto($result->codice, $result->titolo, $result->descrizione, $result->data_concerto);
        $concerto->id = $result->id;  // Imposta l'ID dell'oggetto
        // Creiamo e restituiamo un nuovo oggetto Concerto basato sui dati recuperati.
        return $concerto;
    }

    public static function FindAll()
    {
        $db = new DbManager("config.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");

        $stm = $pdo->query("SELECT * FROM Organizzazione_Concerto.concerti");
        return $stm->fetchAll();
    }
    public static function ShowAll($concerti)
    {
        foreach ($concerti as $concerto) {
            echo "ID: " . $concerto['id'] . PHP_EOL;
            echo "Codice: " . $concerto['codice'] . PHP_EOL;
            echo "Titolo: " . $concerto['titolo'] . PHP_EOL;
            echo "Descrizione: " . $concerto['descrizione'] . PHP_EOL;
            echo "Data: " . $concerto['data_concerto'] . PHP_EOL;
            echo "------------------------------------" . PHP_EOL;
        }
    }


    //METODI DI ISTANZA

    public function Delete()
    {
        if (!$this->id) {
            // Non eseguire la query DELETE se l'ID non è impostato.
            return false;
        }

        $db = new DbManager("config.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");

        $stm = $pdo->prepare("DELETE FROM Organizzazione_Concerto.concerti WHERE id = :id");
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stm->execute();
        return true;
    }


    public function Update($concerto)
    {
        if (!$this->id) {
            // Non eseguire l'aggiornamento se l'ID non è impostato.
            return false;
        }

        $db = new DbManager("config.txt");
        $pdo = $db->Connect("Organizzazione_Concerto");

        $updateFields = [];
        $bindParams = [];

        foreach ($concerto as $key => $value) {
            $updateFields[] = "$key = :$key";
            $bindParams[":$key"] = $value;
        }

        if (empty($updateFields)) {
            // Nessun campo da aggiornare specificato
            return false;
        }

        $updateFieldsString = implode(', ', $updateFields);
        $query = "UPDATE Organizzazione_Concerto.concerti SET $updateFieldsString WHERE id = :id";

        $stm = $pdo->prepare($query);
        $bindParams[':id'] = $this->id;

        foreach ($bindParams as $param => $value) {
            $stm->bindValue($param, $value);
        }

        $stm->execute();
        return true;
    }




    public function Show()
    {
        return "Concerto:
        ID: {$this->id}
        Codice: {$this->codice}
        Titolo: {$this->titolo}
        Descrizione: {$this->descrizione}
        Data: {$this->data}";
    }
}
