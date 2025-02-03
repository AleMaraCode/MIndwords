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

    //patter per password
    $pattern = '/^[a-zA-Z0-9_]+$/';

    //gestione username
    $keyUsername = "RecoverUsername";

    //controllo che il campo esista e non sia vuoto
    if(isOk($keyUsername, "inserire l'username correttamente")){
        return;
    }

    //che la lungezza sia possibile da salvare nel db
    if (strlen($_POST[$keyUsername]) > 30) {
        echo "<div class='error'>username troppo lungo</div>";
        return;
    }

    //gestione password
    $keyPassword = "RecoverPassword";

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
    $keyPasswordVerify = "RecoverPasswordVerify";

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

    //controllo risposta
    $keyAnswer = "Answer";

    // controllo esistenza e presenza
    if(isOk($keyAnswer, "inserire la risposta correttamente")){
        return;
    }

    //controllo lungezza hash
    if (strlen($_POST[$keyAnswer]) > 50) {
        echo "<div class='error'>la risposta è sfortunatamente troppo lunga</div>";
        return;
    }

    //controllo se esiste una risposta per l'utente
    $sqlCheck = 'SELECT u.risposta from utente as u where binary u.username = ?';
    if ($stmt = $db_connection->prepare($sqlCheck)) {
        $stmt->bind_param('s', $_POST[$keyUsername]);
        if ($stmt->execute()) {
            $data = $stmt->get_result();
            $stmt->close();
            if ($data->num_rows === 0) {
                echo "<div class='error'>username o risposta errati</div>";
                return;
            }
            // posso fare così perchè accedendo sulla chiave o ne ho 1
            $dbanser = $data->fetch_assoc()["risposta"];
        } else{
            echo "<div class='error'>qualcosa è andato storto</div>";
            return;
        }
    }else{
        echo "<div class='error'>qualcosa è andato storto, col server</div>";
        return;
    }   

    //controllo che la risposta corrisponda    
    if (!password_verify($_POST[$keyAnswer], $dbanser)) {
        echo "<div class='error'>username o risposta errati</div>";
        return;
    }

    //Aggiornamento del db
    $sqlUpdate = 'UPDATE utente set password = ? where username = ?';
    if ($stmt = $db_connection->prepare($sqlUpdate)) {
        $stmt->bind_param('ss', $hashPassword, $_POST[$keyUsername]);
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
