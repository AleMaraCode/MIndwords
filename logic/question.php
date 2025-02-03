<?php
    // parte "api" della funzione "forget:async function getQuestion(maybeUser)"
    header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["userForget"])) {
        include "dbconnection.php";
        
        $question = "";
        $sql = "SELECT d.domanda
            from domandadisicurezza as d 
            left outer join (
                SELECT *
                from utente
                where username = ?
            )as u on u.domandadisicurezza = d.keydomanda
            order by u.username desc, rand()
            limit 1;";
        
        if ($stmt = $db_connection->prepare($sql)) {
            $stmt->bind_param("s", $_POST["userForget"]);
            if($stmt->execute()){
                $stmt->bind_result($question);
                $stmt->fetch();
                $stmt->close();

                // se non ho nessuna domanda come riposta, do errore
                if (!is_null($question)) {
                    echo json_encode(['question' => $question]);
                }else{
                    echo json_encode(['error' => "Impossibile trovare una domanda"]);
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