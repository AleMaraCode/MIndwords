<?php
    //parte "api" della funzione "friend:async function sendFriendReq(who)"
    header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["who"]) and isset($_POST["sender"])) {
        include "dbconnection.php";
        include "utilfriend.php";
        

        $reciver = $_POST["who"];
        $sender = $_POST["sender"];

        // se è presente una richiesta al contrario
        if (PresentReq($sender, $reciver, $db_connection)) {
            //tolgo l'inversa
            removeReq($sender, $reciver, $db_connection);
            //creo l'amicizia
            insertFriend($sender, $reciver, $db_connection);
            // segnalo che devo ricaricare la pagina
            echo json_encode(['success' => true]);
        }else{
            // allora aggiungo una nuova richesta
            $sqlInset = "INSERT into pending value (?, ?, ?)";
            $tempo = date("Y-m-d");

            if ($stmt = $db_connection->prepare($sqlInset)) {
                $stmt->bind_param("sss", $sender, $reciver, $tempo);
            
                if ($stmt->execute()) {
                    $stmt->close();
                    //seganlo che non devo ricaricare la pagina
                    echo json_encode(['success' => false]);
                } else {
                    echo json_encode(['error' => 'Errore durante l\'esecuzione della query di inserimento richeista']);
                }
            } else {
                echo json_encode(['error' => 'Errore nella preparazione della query di inserimento richeista']);
            }
        }
        $db_connection->close();
    } else {
        echo json_encode(['error' => "Non sono stati forniti i dati"]);
    }
?>