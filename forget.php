<!--validato-->
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="src/icon.ico">
    <title>Registrazione</title>
</head>
<body>
    <?php
        if (isset($_SESSION["UtenteMindWords"])) {
            header("Location: index.php"); 
        }
        include "logic/dbconnection.php";
    ?>
    <nav>
        <a class="linkLogo" href="index.php">
            <img class="icon" src="src/game.png" alt="Logo MindWords">
            <h1>MindWords</h1>
        </a>
    </nav>

    <div id="section">
        <div>
            <form action="forget.php" method="post">
                <div class="topForm">
                    <img class="icon" src="src/game.png" alt="Logo MindWords">
                    <h2>Recupero password</h2>
                    <p>Inserisci gentilmente i tuoi dettagli per recuperare la password</p>
                </div>
                <hr>
                <?php 
                    include "logic/recoverlogic.php";
                ?>
                <div class="bottomForm">
                    <div class="textLabelFrom">
                        <b>Username</b> 
                    </div>
                    <b class="textLabelFrom"></b>
                    <input name="RecoverUsername" id="username" type="text" placeholder="Il tuo username" maxlength="30">
                    <div class="displayFlex">
                    <p class="separator"><u>Nota:</u> se l'username è sbagliato, verrà mostrata comunque una domanda</p>
                    </div>
                    <b class="textLabelFrom">Nuova password</b>
                    <div class="visible">
                        <input name="RecoverPassword" type="password" placeholder="la tua nuova Password" maxlength="50">
                        <div class="btnBg">
                            <img class="eye" src="src/visible.png" alt="visualizza password">
                        </div>
                    </div>
                    <b class="textLabelFrom">Conferma la password</b>
                    <div class="visible">
                        <input name="RecoverPasswordVerify" type="password"  placeholder="la tua nuova Password di nuovo" maxlength="50">
                        <div class="btnBg">
                            <img class="eye" src="src/visible.png" alt="visualizza password">
                        </div>
                    </div>
                    <b class="textLabelFrom">Domanda di sicurezza</b>
                    <p class="fakeInput" id="display">Domanda personale</p>
                    <b class="textLabelFrom">Risposta</b>
                    <input name="Answer" type="text" placeholder="la tua risposta">
                </div>
                <input class="confirmBtn" type="submit" value="Cambia password">
            </form>
        </div>
    </div>

    <?php
        include "view/footer.php"
    ?>

    <script src="js/forget.js"></script>
    <script src="js/password.js"></script>
</body>
</html>