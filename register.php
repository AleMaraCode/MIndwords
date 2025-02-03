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
            <form action="register.php" method="post">
                <div class="topForm">
                    <img class="icon" src="src/game.png" alt="Logo MindWords">
                    <h2>Benvnuto!</h2>
                    <p>Inserisci gentilmente i tuoi dettagli per registrarti</p>
                </div>
                <hr>
                <?php 
                    include "logic/registerlogic.php";
                ?>
                <div class="bottomForm">
                    <b class="textLabelFrom">Username</b>
                    <input name="RegisterUsername" type="text" placeholder="Il tuo username" maxlength="30">
                    <b class="textLabelFrom">Password</b>
                    <div class="visible">
                        <input name="RegisterPassword" type="password" placeholder="la tua Password" maxlength="50">
                        <div class="btnBg">
                            <img class="eye" src="src/visible.png" alt="visualizza password">
                        </div>
                    </div>
                    <b class="textLabelFrom">Conferma la password</b>
                    <div class="visible">
                        <input name="RegisterPasswordVerify" type="password"  placeholder="la tua Password di nuovo" maxlength="50">
                        <div class="btnBg">
                            <img class="eye" src="src/visible.png" alt="visualizza password">
                        </div>
                    </div>
                    <b class="textLabelFrom">Domanda di sicurezza</b>
                    <select name="RegisterQuestion">
                        <?php 
                            $sql = "SELECT keydomanda, domanda FROM domandadisicurezza";
                            if ($stmt = $db_connection->prepare($sql)) {
                                $stmt->execute();
                                $data = $stmt->get_result();
                                $stmt->close();
                                while ($row = $data->fetch_assoc()) {
                                    echo "<option value=".$row["keydomanda"].">".$row['domanda']."</option>"; 
                                }
                            }
                            $db_connection->close();
                        ?>
                    </select> 
                    <b class="textLabelFrom">Risposta</b>
                    <input name="RegisterAnswer" type="text" placeholder="la tua risposta super segreta">
                </div>
                <input class="confirmBtn" type="submit" value="Registrati">
            </form>
        </div>
    </div>

    <?php
        include "view/footer.php"
    ?>
    <script src="js/password.js"></script>
</body>
</html>