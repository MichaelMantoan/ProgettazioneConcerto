<?php

require 'concerto.php';

$scelta;
do {
    echo "Premere 1 per creare un record" . PHP_EOL;
    echo "Premere 2 per mostrare un record" . PHP_EOL;
    echo "Premere 3 per modificare un record" . PHP_EOL;
    echo "Premere 4 per eliminare un record" . PHP_EOL;
    echo "Premere 5 per mostrare tutti i record presenti nella tabella" . PHP_EOL;
    echo "Premere 0 per terminare il programma" . PHP_EOL;

    $scelta = readline();

    switch ($scelta) {
        case 1:
            echo "Inserisci il codice del concerto: ";
            $codice = readline();
            echo "Inserisci il titolo del concerto: ";
            $titolo = readline();
            echo "Inserisci la descrizione del concerto: ";
            $descrizione = readline();
            echo "Inserisci la data del concerto (formato: YYYY-MM-DD): ";
            $data = readline();
            $concertoData = ['codice' => $codice, 'titolo' => $titolo, 'descrizione' => $descrizione, 'data_concerto' => $data];
            $createdConcerto = Concerto::Create($concertoData);
            if(isset($createdConcerto))
            {
                echo "Concerto creato con successo!" . PHP_EOL;
            }
            else
            {
                echo "Errore: Concerto non creato". PHP_EOL;
            }
            break;

        case 2:
            echo "Inserire l'id del concerto da mostrare: ";
            $id = readline();
            $concerto = Concerto::Find($id);
            if ($concerto) {
                $concerto->Show() . PHP_EOL;
            } else {
                echo "Concerto non trovato!" . PHP_EOL;
            }
            break;

        case 3:
            echo "Inserire l'id del concerto da modificare: ";
            $id = readline();
            $concerto = Concerto::Find($id);
            if (!$concerto) {
                echo "Concerto non trovato!" . PHP_EOL;
                break;
            }
            echo "Inserisci il nuovo codice (premere invio per non modificare): ";
            $codice = readline();
            echo "Inserisci il nuovo titolo (premere invio per non modificare): ";
            $titolo = readline();
            echo "Inserisci la nuova descrizione (premere invio per non modificare): ";
            $descrizione = readline();
            echo "Inserisci la nuova data (formato: YYYY-MM-DD HH:MM:SS, premere invio per non modificare): ";
            $data = readline();

            $updateData = [];
            if ($codice)
                $updateData['codice'] = $codice;
            if ($titolo)
                $updateData['titolo'] = $titolo;
            if ($descrizione)
                $updateData['descrizione'] = $descrizione;
            if ($data)
                $updateData['data_concerto'] = $data;

            $concerto->Update($updateData);
            echo "Concerto aggiornato con successo!" . PHP_EOL;
            break;

        case 4:
            echo "Inserire l'id del concerto da eliminare: ";
            $id = readline();
            $concerto = Concerto::Find($id);
            if ($concerto) {
                $concerto->Delete();
                echo "Concerto eliminato con successo!" . PHP_EOL;
            } else {
                echo "Concerto non trovato!" . PHP_EOL;
            }
            break;

        case 5:
            $concerti = Concerto::FindAll();
            Concerto::ShowAll($concerti);
            break;
        case 0:
            echo "Terminazione del programma..." . PHP_EOL;
            break;

        default:
            echo "Scelta non valida. Riprova." . PHP_EOL;
            break;
    }
} while ($scelta != 0);
