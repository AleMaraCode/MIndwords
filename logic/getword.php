<?php
    // parte "api" della funzione "wordle:async function newDbWord(length, oldWord)"
    header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["len"]) and isset($_POST["oldword"])) {
        include "dbconnection.php";
        
        $word = "";
        $sql = "SELECT p.termine
                from parola as p
                where length(p.termine) = ? and p.termine <> ?
                order by rand()
                limit 1";
        if ($stmt = $db_connection->prepare($sql)) {
            $stmt->bind_param("is", $_POST["len"], $_POST["oldword"]);
            if($stmt->execute()){
                $stmt->bind_result($word);
                $stmt->fetch();
                $stmt->close();
                // se ho una parola, la restituisco
                if (!is_null($word)) {
                    echo json_encode(['generatedWord' => $word]);
                }else{
                    echo json_encode(['error' => "Impossibile generare parola"]);
                }

            }else{
                echo json_encode(['error' => 'Errore durante l\'esecuzione della query']);
            }
        }else{
            echo json_encode(['error' => 'Errore nella preparazione della query']);
        }

        $db_connection->close();
    } else {
        echo json_encode(['error' => "Non sono stati forniti i dati"]);
    }
?>