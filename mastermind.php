<!--validato-->
<?php
    session_start();
    include "logic/gameconstmastermind.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mastermind.css">
    <link rel="icon" type="image/x-icon" href="src/icon.ico">
    <title>Mistermind</title>
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

        switch ($_POST["masterTrys"]) {
            case 'Facile':
                $try = EasyMasterTrys;
                $points -= 25;
                break;

            case 'Difficile':
                $try = HardMasterTrys;
                $points += 25;
                break;
            
            default:
                $try = StdMasterTrys;
                break;
        }

        switch ($_POST["masterLen"]) {
            case 'Facile':
                $len = EasyMasterSeq;
                $points -= 25;
                break;

            case 'Difficile':
                $len = HardMasterSeq;
                $points += 25;
                break;
            
            default:
                $len = StdMasterSeq;
                break;
        }

        echo "
        <script> 
            const isLogged = ". (isset($_SESSION["UtenteMindWords"]) ? "true" : "false") . ";
            const numberTrys = ".$try.";
            const lenSeq = ".$len.";
            const maxPoint = ".$points.";
        </script>";

        if (isset($_SESSION["UtenteMindWords"])) {
            include "logic/dbconnection.php";
            $mode = "Mastermind";
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
            <div class="colorPopup stylePopup"></div>
        </div>
        <div class="box sparire">
            <div class="stylePopup errorPopUp">
                <h1>Inserisci tutti i colori</h1>
                <button id="notFull">Ok, scusa</button>
            </div>
        </div>
        <div class="box sparire">
            <div class="stylePopup endGamePopup">
                <h1>Testo prova</h1>
                <hr>
                <h2>Punteggio: </h2>
                <div class="try" id="result">
                    <?php
                        for ($i=0; $i < $len; $i++) { 
                            echo "<div class='resultColor'></div>";
                        }
                    ?>
                </div>
                <a href="index.php">Torna alla home</a>
            </div>
        </div>
    </div>

    <div id="section">
        <div class="playArea">
            <?php
                for (; $try > 0; $try--) { 
                    echo "
                        <div>
                            <div class='try'>
                    ";
                    for ($i=0; $i < $len; $i++) { 
                        echo 
                            "<div class='colorResult'> 
                                <div class='color'></div>
                            </div>";
                    }
                    echo "
                        </div>
                            <button class='guess'></button>
                        </div>
                    ";
                }
            ?>
        </div>
    </div>
    <?php
        include "view/footer.php"
    ?>
    <script type="module" src="js/mastermind.js"></script>
</body>
</html>