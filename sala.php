<?php

class Sala
{
    private $id;
    private $nome;
    private $codice;
    private $capienza;


    public function setID($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setCodice($codice)
    {
        $this->codice = $codice;
    }
    public function setCapienza($capienza)
    {
        $this->capienza = $capienza;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getCodice()
    {
        return $this->codice;
    }
    public function getCapienza()
    {
        return $this->capienza;
    }


    public  static  function find($sala_id)
    {
        $db = new DbManager("config.txt");
        $pdo = $db->Connect("organizzazione_concerti");
        $Stm = $pdo->prepare("SELECT * FROM organizzazione_concerti.sale WHERE id = :sala_id");
        $Stm->bindParam(':sala_id', $sala_id, PDO::PARAM_INT);
        $Stm->execute();
        return $Stm->fetchObject('Sala');
    }
    public function show()
    {
        echo "ID: {$this->id}
        Codice: {$this->codice}
        Nome: {$this->nome}
        Capienza: {$this->capienza}\n";
    }
}
