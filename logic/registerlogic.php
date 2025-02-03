<?php
    //funzione che controlla l'esitenza e che non sia vuoto
    function isOk($key, $message){
        if (!isset($_POST[$key]) || $_POST[$key] == "") {
            echo "<div class='error'>".$message."</div>";
            return true;
        }
        return false;
    }

    // se mi sto connettendo alla pagina con il post
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    //patter per password e utente
    $pattern = '/^[a-zA-Z0-9_]+$/';

    //gestione username
    $keyUsername = "RegisterUsername";
    
    //controllo che il campo esista e non sia vuoto
    if(isOk($keyUsername, "inserire l'username correttamente")){
        return;
    }

    //che non ci sia carattei strani
    if (!preg_match($pattern, $_POST[$keyUsername])) {
        echo "<div class='error'>l'username contiene il carettare proibiti, solo lettere, numeri e underscores sono permessi</div>";
        return;
    }

    //che la lungezza sia possibile da salvare nel db
    if (strlen($_POST[$keyUsername]) > 30) {
        echo "<div class='error'>username troppo lungo</div>";
        return;
    }

    // controllo se esiste un username con lo stesso nome
    $sqlCheck = 'SELECT u.username from utente as u where u.username = ?';
    if ($stmt = $db_connection->prepare($sqlCheck)) {
        $stmt->bind_param('s', $_POST[$keyUsername]);
        if ($stmt->execute()) {
            $data = $stmt->get_result();
            $stmt->close();
            if ($data->num_rows !== 0) {
                echo "<div class='error'>username già in uso</div>";
                return;
            }  
        } else{
            echo "<div class='error'>qualcosa è andato storto</div>";
            return;
        }
    }else{
        echo "<div class='error'>qualcosa è andato storto, col server</div>";
        return;
    }   
    
    //gestione password
    $keyPassword = "RegisterPassword";

    //controllo esistenza e presenza
    if(isOk($keyPassword, "inserire la password correttamente")){
        return;
    }

    //che non ci sia carattei strani
    if (!preg_match($pattern, $_POST[$keyPassword])) {
        echo "<div class='error'>la password contiene il carettare proibiti, solo lettere, numeri e underscores sono permessi</div>";
        return;
    }

    //max length per limit algoritmo
    if (strlen($_POST[$keyPassword]) > 50) {
        echo "<div class='error'>la passowrd è troppo lunga</div>";
        return;
    }

    $hashPassword = password_hash($_POST[$keyPassword], PASSWORD_BCRYPT);
    
    //gestione passowrd verify
    $keyPasswordVerify = "RegisterPasswordVerify";

    //controllo esistenza e presenza passowrd verify
    if(isOk($keyPasswordVerify, "inserire la verifica della passoword correttamente")){
        return;
    }

    //max length per limit algoritmo
    if (strlen($_POST[$keyPasswordVerify]) > 50) {
        echo "<div class='error'>la riprova della passowrd è troppo lunga</div>";
        return;
    }

    //controllo che le password coincidano
    if (!password_verify($_POST[$keyPasswordVerify], $hashPassword)) {
        echo "<div class='error'>le password non corrispondono</div>";
        return;
    }

    //controllo domanda
    $keyQuestion = "RegisterQuestion";

    //esistenza e altri controlli
    if (!isset($_POST[$keyQuestion]) || !is_numeric($_POST[$keyQuestion]) || $_POST[$keyQuestion] <= 0 ) {
        echo "<div class='error'>La domanda è stata scelta incorrettamente</div>";
        return;
    }

    //controllo risposta
    $keyAnswer = "RegisterAnswer";

    // controllo esistenza e presenza
    if(isOk($keyAnswer, "inserire la risposta correttamente")){
        return;
    }

    //controllo lungezza hash
    if (strlen($_POST[$keyAnswer]) > 50) {
        echo "<div class='error'>la risposta è sfortunatamente troppo lunga</div>";
        return;
    }

    $hashAnswer = password_hash($_POST[$keyAnswer], PASSWORD_BCRYPT);

    //inserimento nel database
    $sqlInsert = 'INSERT INTO utente value (?, ?, ?, ?)';
    if ($stmt = $db_connection->prepare($sqlInsert)) {
        $stmt->bind_param('ssis', $_POST[$keyUsername], $hashPassword, $_POST[$keyQuestion], $hashAnswer);
        if(!$stmt->execute()){
            echo "<div class='error'>qualcosa è andato storto, ci scusiamo per il disagio </div>";
            return;
        }
        $stmt->close();
        header("Location: login.php");
    }else{
        echo "<div class='error'>qualcosa è andato storto col server, ci scusiamo per il disagio </div>";
        return;
    }
?>