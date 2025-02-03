<!--validato-->
<?php
    session_start();
    include "logic/gameconstwordle.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/wordle.css">
    <link rel="icon" type="image/x-icon" href="src/icon.ico">
    <title>Wordle</title>
</head>
<body>
    <nav>
        <a class="linkLogo" href="index.php">
            <img class="icon" src="src/game.png" alt="Logo MindWords">
            <h2>MindWords</h2>
        </a>
        <b id="punteggio">Punteggio: 0</b>
    </nav>

    <?php
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: index.php");
        }

        $points = 100;

        switch ($_POST["wordleTrys"]) {
            case 'Facile':
                $try = EasyWordleTrys;
                $points -= 25;
                break;

            case 'Difficile':
                $try = HardWordleTrys;
                $points += 25;
                break;
            
            default:
                $try = StdWordleTrys;
                break;
        }

        switch ($_POST["wordleLen"]) {
            case 'Facile':
                $len = EasyWordleLen;
                $points -= 25;
                break;

            case 'Difficile':
                $len = HardWordleLen;
                $points += 25;
                break;
            
            default:
                $len = StdWordleLen;
                break;
        }

        echo "
        <script> 
            const isLogged = ". (isset($_SESSION["UtenteMindWords"]) ? "true" : "false") . ";
            const Trys = ".$try.";
            const lenWord = ".$len.";
            const maxPoints = ".$points.";
        </script>";

        if (isset($_SESSION["UtenteMindWords"])) {
            include "logic/dbconnection.php";
            $mode = "Wordle";
            include "logic/makesession.php";
            echo "
            <script>
                const user = '".$_SESSION["UtenteMindWords"]."';
                const startTime = '".$time."';
            </script>";
            $db_connection->close();
        }
    ?>

    <div id="popup" class="sparire">
        <div class="blocker"></div>
        <div class="box sparire">
            <div class="stylePopup errorPopUp">
                <h1>Inserisci tutte le lettere</h1>
                <button id="notFull">Ok, scusa</button>
            </div>
        </div>
        <div class="box sparire">
            <div class="stylePopup endGamePopup">
                <h1>Testo prova</h1>
                <hr>
                <h2>Punteggio: </h2>
                <div id="endContainer">
                    <?php
                        for ($i=0; $i < $len; $i++) { 
                            echo "<div class='endLetter correct'></div>";
                        }
                    ?>
                </div>
                <a href="index.php">Torna alla home</a>
            </div>
        </div>
    </div>

    <div id="section">
        <div class="playArea">
            <div class="trys">
                <?php
                    for (; $try > 0; $try--) { 
                        echo "<div class='wordContainer'>";
                        for ($i=0; $i < $len; $i++) { 
                            echo "<div class='letter'></div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <div class="keyboard">
                <div class="keyboardRow">
                    <div class="skey" id="backspace">
                        <img src="src/backspace.png" alt="backspace" class="imgKey">
                    </div>
                </div>
                <div class="keyboardRow">
                    <div class="skey" id="enter">
                        <img src="src/enter.png" alt="enter" class="imgKey">
                    </div>
                </div>
                <div class="keyboardRow"></div>
            </div>
        </div>
    </div>

    <?php
        include "view/footer.php"
    ?>
    <script type="module" src="js/wordle.js"></script>
</html>