<?php

class Pezzo
{
    private $id;
    private $codice;
    private $titolo;


    public function getId()
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

    public function setId($id)
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

    public static function find($id)
    {
        $db = new DbManager("config.txt");
        $pdo = $db->Connect("organizzazione_concerti");
        $stm = $pdo->prepare("SELECT pezzi.id, pezzi.codice, pezzi.titolo
        FROM concerti
        INNER JOIN concerti_pezzi ON concerti.id = concerti_pezzi.concerto_id
        INNER JOIN pezzi ON concerti_pezzi.pezzo_id = pezzi.id
        WHERE concerti.id = :id");
        $stm->bindParam(":id", $id);
        $stm->execute();

        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $pezzi = array();

        foreach ($result as $row) {
            $pezzo = new Pezzo();
            $pezzo->setId($row['id']);
            $pezzo->setCodice($row['codice']);
            $pezzo->setTitolo($row['titolo']);
            $pezzi[] = $pezzo;
        }

        return $pezzi;
    }


    public static function show($pezzi)
    {
        foreach ($pezzi as $pezzo) {
            echo "ID: " . $pezzo->getId() . "\n";
            echo "Codice: " . $pezzo->getCodice() . "\n";
            echo "Titolo: " . $pezzo->getTitolo() . "\n";
            echo "----------------------\n";
        }
    }
}
