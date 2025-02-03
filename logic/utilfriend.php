<?php
    // ritorna vero se esiste almeno una richiesta dove i due intressati sono $sender e $reciver l'ordine non influenza
    function PresentReq($sender, $reciver, $db_connection) {
        // controllo che la connessione al database esista
        if (!isset($db_connection)) {
            echo json_encode(['error' => 'Manca connessione al db']);
            exit;
        }

        $search = "SELECT dataInvio
        from pending 
        where (sender = ? and reciver = ?) 
        or (sender = ? and reciver = ?)";
        
        if ($stmt = $db_connection->prepare($search)) {
            $stmt->bind_param("ssss", $sender, $reciver, $reciver, $sender);            
            if ($stmt->execute()) {
                $data = $stmt->get_result();
                $stmt->close();
                return $data->num_rows !== 0;
            } else {
                echo json_encode(['error' => 'Errore durante l\'esecuzione della query di ricerca richeista']);
                $db_connection->close();
                exit;
            }
        } else {
            echo json_encode(['error' => 'Errore nella preparazione della query di ricerca richiesta']);
            $db_connection->close();
            exit;
        }
    }

    //inserisco una amicizia
    function insertFriend($sender, $reciver, $db_connection) {
        // guardo se il database esiste
        if (!isset($db_connection)) {
            echo json_encode(['error' => 'Manca connessione al db']);
            exit;
        }

        $search = "INSERT into friend value(?, ?)";
        
        if ($stmt = $db_connection->prepare($search)) {
            $stmt->bind_param("ss", $sender, $reciver);
        
            if ($stmt->execute()) {
                $stmt->close();
            } else {
                echo json_encode(['error' => 'Errore durante l\'esecuzione della query di inserimento amicizia']);
                $db_connection->close();
                exit;
            }
        } else {
            echo json_encode(['error' => 'Errore nella preparazione della query inserimento amicizia']);
            $db_connection->close();
            exit;
        }
    }

    // rimuovo tutte le richieste dove i target sono o $reciver o $sender
    function removeReq($sender, $reciver, $db_connection){
        if (!isset($db_connection)) {
            echo json_encode(['error' => 'Manca connessione al db']);
            $db_connection->close();
            exit;
        }

        $sqlremove = "DELETE from pending where (sender = ? and reciver = ?) or (sender = ? and reciver = ?)";

        if ($stmt = $db_connection->prepare($sqlremove)) {
            $stmt->bind_param("ssss", $sender, $reciver, $reciver, $sender);
            
            if ($stmt->execute()) {
                $stmt->close();
            } else {
                echo json_encode(['error' => 'Errore durante l\'esecuzione della query di rimozione']);
                $db_connection->close();
                exit;
            }
        }else {
            echo json_encode(['error' => 'Errore nella preparazione della query di rimozione']);
            $db_connection->close();
            exit;
        }
    }

?>