<?php

class DBMng
{

    private $host,$porta,$username,$password;

    public function __construct($fileDBConfig)
    {
        $lines = file($fileDBConfig, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->host = $lines[0];
        $this->porta = $lines[1];
        $this->username = $lines[2];
        //$this->password = $lines[3];
    }

    public function Connect($dbname)
    {

        $dsn = "mysql:dbname={$dbname};host={$this->host}";
        
        try
        {
            $pdo = new PDO($dsn,$this->username,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $pdo;

        }catch(PDOException $e)
        {
            die("Connessione al DB fallita: ".$e->getMessage());
        }
    }
}

?>