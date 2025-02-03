<?php
    // parte "api" della funzione wordle/mastermid:async function updateScore(startTime, time, currentTrys, gameScore), è istanziata separatamente nei due file, scelta dovuta al fatto che è l'unica funzione che è condivisa tra i due file
    header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["user"]) and isset($_POST["inizio"]) and isset($_POST["tempo"]) and isset($_POST["tryes"]) and isset($_POST["punteggio"]) ) {
        include "dbconnection.php";
                
        $sql = "INSERT INTO partita value (?, ?, ?, ?, ?)";
        if ($stmt = $db_connection->prepare($sql)) {
            $stmt->bind_param('sssii', $_POST["user"], $_POST["inizio"], $_POST["tempo"], $_POST["tryes"], $_POST["punteggio"]);
            if($stmt->execute()){
                $stmt->close();
                // dico che tutto è ok
                echo json_encode(['ok' => true]);
            }else{
                echo json_encode(['error' => 'Errore durante l\'esecuzione della query']);
            }
        }else{
            echo json_encode(['error' => 'Errore durante l\'esecuzione della query']);
        }
    
        $db_connection->close();
    } else {
        echo json_encode(['error' => "Non sono stati forniti i dati"]);
    }
?>