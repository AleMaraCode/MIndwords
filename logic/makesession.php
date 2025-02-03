<?php
    // pezzo che crea una sessione, considerando che la variabile $mode, contenga il nome della modalità. è usato per entambi i giochi
    if (isset($_SESSION["UtenteMindWords"])) {
        $query = "SELECT m.idmodalita from modalita as m where m.nomemodalita = ?";
        if ($stmt = $db_connection->prepare($query)) {
            $stmt->bind_param('s', $mode);
            $stmt->execute();
            $stmt->bind_result($idMode);
            $stmt->fetch();
            $stmt->close();
        }
    
        $time = date('Y-m-d H:i:s', time());
    
        $sqlInsert = 'INSERT INTO sessione(iduser, inizio, modalita, lughezzaSequenza, tentativiMax) value(?, ?, ?, ?, ?)';
        if ($stmt = $db_connection->prepare($sqlInsert)) {
            $stmt->bind_param('ssiii', $_SESSION["UtenteMindWords"], $time, $idMode, $len, $try);
            if(!$stmt->execute()){
                echo "
                <div class='fatalError'>
                    <h1>Qualcosa è andato storto, si prega di riporvare più tardi. Ci scusiamo del disagio</h1>
                    <hr>
                    <a href='index.php'><h2>Home</h2></a>
                </div>";
                exit;
            }
            $stmt->close();
        }
        // da questo punto ho le variabili $time e $_SESSION["UtenteMindWords"] che mi specificano i valori chiave del record, per accedervi dopo
    }
?>


