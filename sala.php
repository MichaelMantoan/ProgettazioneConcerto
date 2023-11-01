<?php

require "db_manager.php";

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

    public function show()
    {
        echo "ID: {$this->id}
        Codice: {$this->codice}
        Nome: {$this->nome}
        Capienza: {$this->capienza}\n";
    }   
    
}

