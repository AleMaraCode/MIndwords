<?php
    // parte "api" della funzione async function getSubString(subString)
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["substring"]) and isset($_POST["sender"])) {
        include "dbconnection.php";
        header('Content-Type: application/json');

        $sql = "SELECT u.username
        from utente as u 
        where u.username <> ? 
        and not exists (
            select f.user1
            from friend as f 
            where (f.user1 = ? and f.user2 = u.username) or (f.user1 = u.username and f.user2 = ?)
        )
        and not exists (
            select p.dataInvio
            from pending as p
            where p.sender = ? and p.reciver = u.username
        )
        and u.username like ?";
    
        $subString = $_POST["substring"] . "%"; 

        if ($stmt = $db_connection->prepare($sql)) {
            $stmt->bind_param("sssss", $_POST["sender"], $_POST["sender"], $_POST["sender"], $_POST["sender"], $subString);
        
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $users = [];

                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['username'];
                }

                $stmt->close();
                // restituisco la lista di utenti dove l'inizio è quello fornito in funzione, che non sono amici o ha inviato richieste questo user
                echo json_encode(['users' => $users]);
            } else {
                echo json_encode(['error' => 'Errore durante l\'esecuzione della query']);
            }
        } else {
            echo json_encode(['error' => 'Errore nella preparazione della query']);
        }

        $db_connection->close();
    } else {
        echo json_encode(['error' => "Non sono stati forniti i dati"]);
    }
?>