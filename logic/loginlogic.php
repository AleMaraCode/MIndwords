<?php
// accesso con post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return; 
}

$keyUsername = "LoginUsername";
$keyPassword = "LoginPassword";

// controllo esistenza e reale presenza
if (!isset($_POST[$keyUsername]) || 
    $_POST[$keyUsername] == "" || 
    !isset($_POST[$keyPassword]) || 
    $_POST[$keyPassword] == "") {
    echo "<div class='error'>Passoword o username non è inserita</div>";
    return;
}

//controllo lungezza password per algo hash
if (strlen($_POST[$keyPassword]) > 50) {
    echo "<div class='error'>la passowrd è troppo lunga</div>";
    return;
}

include "dbconnection.php";

//controllo esistenza account
//bynary per le maiuscole
$sqlCheck = 'SELECT u.username, u.password from utente as u where binary u.username = ?';
if ($stmt = $db_connection->prepare($sqlCheck)) {
    $stmt->bind_param('s', $_POST[$keyUsername]);
    if ($stmt->execute()) {
        $stmt->execute();
        $stmt->bind_result($name, $hashPassword);
        $stmt->fetch();
        $stmt->close();

        if (is_null($name) || !password_verify($_POST[$keyPassword], $hashPassword)) {
            echo "<div class='error'>Username o password non corretti</div>";
            return;
        }

        $_SESSION["UtenteMindWords"] = $name;
        header("Location: index.php"); 

    } else{
        echo "<div class='error'>qualcosa è andato storto</div>";
        return;
    }
}else{
    echo "<div class='error'>qualcosa è andato storto, col server</div>";
    return;
}  

?>