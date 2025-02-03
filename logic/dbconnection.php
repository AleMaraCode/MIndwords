<?php  
    // file per connetteri al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "DataBaseMindwords";

    $db_connection = new mysqli($servername, $username, $password, $dbname);
    if ($db_connection->connect_error) {
        die("Connessione fallita: " . $db_connection->connect_error);
    }
?>