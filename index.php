<!-- validato -->
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/x-icon" href="src/icon.ico">
    <title>MindWords</title>
</head>
<body>
    <nav>
        <a class="linkLogo" href="index.php">
            <img class="icon" src="src/game.png" alt="Logo MindWords">
            <h1>MindWords</h1>
        </a>
        <a href="doc.php">Tutorial</a>
        <div class="NavLeftElem">
            <?php
                if (isset($_SESSION["UtenteMindWords"])) {
                    echo '
                    <a class="linkLogo" href="user.php">
                        <img class="iconSmall" src="src/user.png" alt="Pagin Utente">
                    </a>';
                }else {
                    echo '
                    <a href="register.php">Registrati</a>
                    <a class="login" href="login.php">Login</a>';
                }
            ?>
        </div>
    </nav>

    <div id="section">
        <form action="wordle.php" method="post">
            <b>Numero tentativi</b>
            <div class="selector">
                <p id="wordleDownTrys"> &#9665; </p>
                <input type="text" name="wordleTrys" id="wordleTrys" value="Normale" readonly>
                <p id="wordleUpTrys"> &#9655; </p>
            </div>
            <b>lunghezza sequenza</b>
            <div class="selector">
                <p id="wordleDownLen"> &#9665; </p>
                <input type="text" name="wordleLen" id="wordleLen" value="Normale" readonly>
                <p id="wordleUpLen"> &#9655; </p>
            </div>
            <hr>
            <input class="wordle" type="submit" value="Gioca a Wordle!">
        </form>
        <form action="mastermind.php" method="post">
            <b>Numero tentativi</b>
            <div class="selector">
                <p id="masterDownTrys"> &#9665; </p>
                <input type="text" name="masterTrys" id="masterTrys" value="Normale" readonly>
                <p id="masterUpTrys"> &#9655; </p>
            </div>
            <b>lunghezza sequenza</b>
            <div class="selector">
                <p id="masterDownLen"> &#9665; </p>
                <input type="text" name="masterLen" id="masterLen" value="Normale" readonly>
                <p id="masterUpLen"> &#9655; </p>
            </div>
            <hr>
            <input class="mastermind" type="submit" value="Gioca a Mastermind!">
        </form>
    </div>
    
    <?php
        include "view/footer.php"
    ?>
    <script src="js/index.js"></script>
</body>
</html>