<!--validate-->
<?php
    session_start();
    include "logic\gameconstmastermind.php";
    include "logic\gameconstwordle.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user.css">
    <link rel="icon" type="image/x-icon" href="src/icon.ico">
    <title>Pagina utente</title>
</head>
<body>
    <?php
        if (!isset($_SESSION["UtenteMindWords"])) {
            header("Location: index.php"); 
        }
        include "logic/dbconnection.php";
    ?>
    <nav>
        <a class="linkLogo" href="index.php">
            <img class="icon" src="src/game.png" alt="Logo MindWords">
            <?php
                echo "<h2>Ciao, ".$_SESSION["UtenteMindWords"]."!</h2>";
            ?>
        </a>
        <form action="user.php" method="get" class="selector">
            <div class="container">
                <p>Tentativi:</p>
                <div class="option">
                    <p class="start">Facile</p>
                    <p class="middle">Medio</p>
                    <p class="end">Difficile</p>
                </div>
                <input type="text" name="trys" id="trys" readonly>
            </div>

            <div class="container">
                <p>Lunghezza:</p>
                <div class="option">
                    <p class="start">Facile</p>
                    <p class="middle">Medio</p>
                    <p class="end">Difficile</p>
                </div>
                <input type="text" name="len" id="len" readonly>
            </div>
            
            <div class="container">
                <p>Modalità:</p>
                <div class="option">
                    <p class="start selected">Wordle</p>
                    <p class="middle">Mistermind</p>
                    <input class="optionSubmit" type="submit" value="Invia">
                </div>
                <input type="text" name="mod" id="mod" value="0" readonly>
            </div>
        </form>
        <div class="NavLeftElem">
            <a href="logic/logout.php">Logout</a>
        </div>
        <script>let userData = null; </script>
    </nav>

    <div id="section">
        <div class="data">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["trys"]) && isset($_GET["len"]) && isset($_GET["mod"])) {
                    
                    $trys = "";
                    $len = "";

                    // struttura contenente i dati su i giochi
                    $configs = [
                        "Wordle" => [
                            "trys" => [
                                "Facile" => EasyWordleTrys,
                                "Normale" => StdWordleTrys,
                                "Difficile" => HardWordleTrys,
                            ],
                            "len" => [
                                "Facile" => EasyWordleLen,
                                "Normale" => StdWordleLen,
                                "Difficile" => HardWordleLen,
                            ]
                        ],
                        "Mastermind" => [
                            "trys" => [
                                "Facile" => EasyMasterTrys,
                                "Normale" => StdMasterTrys,
                                "Difficile" => HardMasterTrys,
                            ],
                            "len" => [
                                "Facile" => EasyMasterSeq,
                                "Normale" => StdMasterSeq,
                                "Difficile" => HardMasterSeq,
                            ]
                        ],
                    ];
                    
                    $mode = $_GET["mod"] == 1 ? "Mastermind" : "Wordle";

                    $difficultyTrys = ""; 
                    $TrysSelected = 0; 
                    switch ($_GET["trys"]) {
                        case 0:
                            $difficultyTrys = "Facile";
                            break;
                        case 1:
                            $difficultyTrys = "Normale";
                            break;
                        case 2:
                            $difficultyTrys = "Difficile";
                            break;

                        default:
                            $TrysSelected = 1;
                            break;
                    }

                    $difficultyLen = ""; 
                    $LenSelected = 0; 
                    switch ($_GET["len"]) {
                        case 0:
                            $difficultyLen = "Facile";
                            break;
                        case 1:
                            $difficultyLen = "Normale";
                            break;
                        case 2:
                            $difficultyLen = "Difficile";
                            break;
                        default:
                            $LenSelected = 1;
                            break;
                    }

                    if (!$TrysSelected) {
                        $trys = $configs[$mode]["trys"][$difficultyTrys];
                    }
                    if (!$LenSelected) {
                        $len = $configs[$mode]["len"][$difficultyLen];
                    }
                   
                    echo "<h2> Modalità: ".$mode. ($trys > 0 ? (", Numero tentativi: " . $trys) : "") . ($len > 0 ? (", Lunghezza sequenza: " . $len) : "") . "</h2>";
                    
                    $sql = "SELECT s.inizio, floor(avg(time_to_sec(p.tempo))) as tempoMedio, avg(p.tentativi) as avgTentativi, sum(p.punteggio) as totSessione
                        from sessione as s left outer join partita as p on p.userSessione = s.iduser and p.inizioSessione = s.inizio 
                        inner join modalita as m on m.idmodalita = s.modalita
                        where s.iduser = ? and m.nomemodalita = ? and (s.tentativiMax = ? or ?) and (s.lughezzaSequenza = ? or ?)  
                        group by s.iduser, s.inizio, s.modalita
                        order by s.inizio limit 15";
                    if ($stmt = $db_connection->prepare($sql)) {
                        $stmt->bind_param('ssiiii', $_SESSION["UtenteMindWords"],  $mode, $trys, $TrysSelected, $len, $LenSelected);
                        if ($stmt->execute()) {
                            $data = $stmt->get_result();
                        }
                        $stmt->close();
                        $jsdata = [];
                        while ($row = $data->fetch_assoc()) {
                            $jsdata[] = $row;
                        }
                        echo "<script>userData = " . json_encode($jsdata) . ";</script>";
                    }
                }else {
                    echo "<h2>Nessuna modalità selezionata, selezionare almeno la modalià per vedere i propri risultati</h2>";
                }
            ?> 
            <hr>

            <h3>Punteggio totale:</h3>
            <canvas width="800" height="200" id="punteggio"></canvas>

            <h3>Tentativi medi:</h3>
            <canvas width="800" height="200" id="tentativi"></canvas>

            <h3>Tempo medio:</h3>
            <canvas width="800" height="200" id="tempo"></canvas>
        </div>

        <div class="leaderBoard">
            <div class="title">
                <h1>Leaderboard</h1> 
                <a href="friend.php">Aggiungi nuovi amici</a>
            </div>
            <div class="spacing">
                <div class="scroll">
                    <?php
                        if (($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["trys"]) && isset($_GET["len"]) && isset($_GET["mod"]))) {
                            $sqlboard = "SELECT g.iduser, cast(max(g.inizio) as date) as inizioTop, lughezzaSequenza, tentativiMax, punteggioSessione
                            from (
                                Select iduser, inizio, lughezzaSequenza, tentativiMax, ifnull(sum(p.punteggio), 0) as punteggioSessione
                                from sessione as s inner join modalita as a on a.idmodalita = s.modalita left outer join partita as p on s.iduser = p.userSessione and s.inizio = p.inizioSessione
                                where a.nomemodalita = ? and s.iduser in (
                                    select *
                                    from (
                                        select user1 as amico FROM friend as f1 where f1.user2 = ? or f1.user1 = ?
                                        union 
                                        select user2 as amico FROM friend as f2 where f2.user2 = ? or f2.user1 = ?
                                        union
                                        select ? as amico
                                    ) u
                                )
                                group by s.iduser, s.inizio
                            ) g
                            where (g.punteggioSessione) = (
                                select max(g2.punteggioSessione)
                                from (
                                    Select iduser, inizio, ifnull(sum(p.punteggio), 0) as punteggioSessione
                                    from sessione as s inner join modalita as a on a.idmodalita = s.modalita left outer join partita as p on s.iduser = p.userSessione and s.inizio = p.inizioSessione
                                    where a.nomemodalita = ? and s.iduser in (
                                        select *
                                        from (
                                            select user1 as amico FROM friend as f1 where f1.user2 = ? or f1.user1 = ?
                                            union 
                                            select user2 as amico FROM friend as f2 where f2.user2 = ? or f2.user1 = ?
                                            union
                                            select ? as amico
                                        ) u
                                    )
                                    group by s.iduser, s.inizio
                                ) g2
                                where g2.iduser = g.iduser
                            )
                            group by g.iduser
                            order by g.punteggioSessione desc, g.Inizio";

                            echo "<div class='head'>
                                    <p>Utente</p>
                                    <p class='dataspacer middle'>Data</p>
                                    <p class='middle'>Try</p>
                                    <p class='middle'>Len</p>
                                    <p class='last'>Point</p>
                                </div>";

                            if ($stmt = $db_connection->prepare($sqlboard)) {
                                $stmt->bind_param('ssssssssssss', $mode, $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"],$_SESSION["UtenteMindWords"], $mode, $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"]);
                                if ($stmt->execute()) {
                                    $data = $stmt->get_result();
                                }else{
                                    echo "<h1>Qualcosa è andato storto con la esecuzione query</h1>";
                                }
                                $stmt->close();
                                while ($row = $data->fetch_assoc()) {
                                    if ($row["iduser"] == $_SESSION["UtenteMindWords"]) {
                                        echo "<div class='me'>";
                                    }else{
                                        echo "<div>";
                                    }
                                    echo "<p>".$row["iduser"]."</p>
                                        <p class='dataspacer middle'>". str_replace('-', '/', $row["inizioTop"] )."</p>
                                        <p class='middle'>".$row["tentativiMax"]."</p>
                                        <p class='middle'>".$row["lughezzaSequenza"]."</p>
                                        <p class='last'>".$row["punteggioSessione"]."</p>
                                    </div>";
                                }
                            }else{
                                echo "<h1>Qualcosa è andato storto con la query</h1>";
                            }
                        }else{
                            $sqlfriend = "SELECT if(user1 = ?, user2, user1) as amico FROM friend as f1 where f1.user2 = ? or f1.user1 = ?";
                            echo "<div class='head'><p>Amici</p></div>";

                            if ($stmt = $db_connection->prepare($sqlfriend)) {
                                $stmt->bind_param('sss', $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"], $_SESSION["UtenteMindWords"]);
                                if ($stmt->execute()) {
                                    $data = $stmt->get_result();
                                }
                                $stmt->close();
                                while ($row = $data->fetch_assoc()) {
                                    echo "<div><p>" .$row["amico"]."<p></div>";
                                }
                            }
                        }
                        $db_connection->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
        include "view/footer.php"
    ?>
    <script src="js/user.js"></script>
</body>
</html>