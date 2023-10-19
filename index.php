<?php
require 'Concerto.php';

//$conc = Concerto::Create(array("codice"=> "232121","titolo"=>"titolo1","descrizione"=>"desc1","data"=>"22/11/01"));
//$conc2 = Concerto::Create(array("codice"=> "232121","titolo"=>"titolo2","descrizione"=>"desc2","data"=>"23/12/03"));
$concerto = Concerto::Find(2);  // Supponendo che il tuo metodo Find restituisca un'istanza di Concerto con l'ID impostato.

//$concerto->DeleteAll();

if ($concerto) 
{
    $concerto->Delete();
}

//Concerto::Create($conc2);;
?>