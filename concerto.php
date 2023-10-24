<?php

require 'db_manager.php';


class Concerto
{

    public $id;
    public $codice;
    public $titolo;
    public $descrizione;
    public $data;
    
    public function __construct($codice, $titolo, $descrizione, $data_concerto)
    {
        $this->codice = $codice;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->data = $data_concerto;
    }
    
    //METODI GET

    public function getID()
    {
        return $this->id;
    }

    public function getCodice()
    {
        return $this->codice;
    }
    public function getTitolo()
    {
        return $this->titolo;
    }
    public function getDescrizione()
    {
        return $this->descrizione;
    }
    public function getData()
    {
        return $this->data;
    }

    //METODI SET

    private function setID($id)
    {
        $this->id = $id;
    }
    public function setCodice($codice)
    {
        $this->codice = $codice;
    }
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }
    public function setData($data)
    {
        $this->data = $data;
    }

    //METODI STATICI

    public static function Create($concerto)
    {

        $pdo = Concerto::Connect();
        // Controllo se esiste già un concerto con lo stesso codice
        $checkStm = $pdo->prepare("SELECT id FROM concerti WHERE codice = :codice");
        $checkStm->bindParam(':codice', $concerto['codice']);
        $checkStm->execute();

        if ($checkStm->fetchColumn()) {
            // Se esiste già, restituisci un errore
            return ["error" => "Un concerto con questo codice esiste già."];
        }
        $stm = $pdo->prepare("INSERT INTO concerti (codice, titolo, descrizione, data_concerto) VALUES (:codice, :titolo, :descrizione, :data_concerto)");

        $codice = $concerto['codice'];
        $titolo = $concerto['titolo'];
        $descrizione = $concerto['descrizione'];
        $data = $concerto['data_concerto'];

        $stm->bindParam(':codice', $codice);
        $stm->bindParam(':titolo', $titolo);
        $stm->bindParam(':descrizione', $descrizione);
        $stm->bindParam(':data_concerto', $data);

        $result = $stm->execute();
        if ($result == false) {
            return null;
        } else {
            $stm = $pdo->prepare("SELECT * FROM Organizzazione_Concerti.concerti ORDER BY ID DESC LIMIT 1");
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);
            $row = new Concerto($result->codice, $result->titolo, $result->descrizione, $result->data_concerto);
            $row->id = $result->id;
            return $row;
        }
    }

    public static function Find($id)
    {

        $pdo= Concerto::Connect();

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
        $pdo= Concerto::Connect();

        $stm = $pdo->query("SELECT * FROM organizzazione_concerti.concerti");
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

        $pdo = Concerto::Connect();

        $stm = $pdo->prepare("DELETE FROM organizzazione_concerti.concerti WHERE id = :id");
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stm->execute();
        return true;
    }


    public function Update($concerto)
{
    // Verifica che l'oggetto Concerto abbia un ID valido
    if (!$this->id) {
        return false;
    }

    // Connetti al database
    $pdo = Concerto::Connect();

    // Verifica se esiste già un concerto con lo stesso codice (escluso se è lo stesso concerto)
    $checkStm = $pdo->prepare("SELECT id FROM concerti WHERE codice = :codice AND id <> :current_id");
    $checkStm->bindParam(':codice', $concerto['codice']);
    $checkStm->bindParam(':current_id', $this->id, PDO::PARAM_INT);
    $checkStm->execute();

    if ($checkStm->fetchColumn()) {
        return ["error" => "Un concerto con questo codice esiste già."];
    }

    // Prepara i dati per l'aggiornamento
    $updateFields = [];
    $bindParams = [':id' => $this->id];

    foreach ($concerto as $key => $value) {
        if ($value !== null) {
            $updateFields[] = "$key = :$key";
            $bindParams[":$key"] = $value;
        }
    }

    if (empty($updateFields)) {
        return false; // Nessun campo da aggiornare specificato
    }

    // Costruisci la query SQL
    $updateFieldsString = implode(', ', $updateFields);
    $query = "UPDATE organizzazione_concerti.concerti SET $updateFieldsString WHERE id = :id";

    // Esegui l'aggiornamento con il binding dei parametri
    $stm = $pdo->prepare($query);

    foreach ($bindParams as $param => $value) {
        $stm->bindValue($param, $value);
    }

    $result = $stm->execute();

    return $result;
}


    public function Show()
    {
        echo("Concerto:
        ID: {$this->id}
        Codice: {$this->codice}
        Titolo: {$this->titolo}
        Descrizione: {$this->descrizione}
        Data: {$this->data}"."\n");
    }



    //METODO CONNESSIONE

    private static function Connect()
    {
        $db = new DbManager("config.txt");
        return $db->Connect("organizzazione_concerti");
    }
}
