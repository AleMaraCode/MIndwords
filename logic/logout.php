<?php
    // per eseguire il logout, resetto la sessione e reidirizzo alla home
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
?>