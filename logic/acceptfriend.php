<?php
    // parte "api" della funzione "friend:async function acceptFriend(who)"
    header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["who"]) and isset($_POST["sender"])) {
        include "dbconnection.php";
        include "utilfriend.php";

        $reciver = $_POST["who"];
        $sender = $_POST["sender"];
        //rimuovo richiesta pendente
        removeReq($sender, $reciver, $db_connection);
        //aggiungo amicizia
        insertFriend($sender, $reciver, $db_connection);
        $db_connection->close();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => "Non sono stati forniti i dati"]);
    }
?>