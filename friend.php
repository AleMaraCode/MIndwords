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
    <link rel="stylesheet" href="css/friend.css">
    <link rel="icon" type="image/x-icon" href="src/icon.ico">
    <title>MindWords</title>
</head>
<body>
    <?php
        if (!isset($_SESSION["UtenteMindWords"])) {
            header("Location: index.php"); 
        }
        include "logic/dbconnection.php";
        echo "<script> const user = '". $_SESSION["UtenteMindWords"]."';</script>";
    ?>
    <nav>
        <a class="linkLogo" href="index.php">
            <img class="icon" src="src/game.png" alt="Logo MindWords">
            <h1>MindWords</h1>
        </a>
        <div class="NavLeftElem">
            <a class="linkLogo" href="user.php">
                <img class="iconSmall" src="src/user.png" alt="Pagin Utente">
            </a>
        </div>
    </nav>

    <div id="section">
        <div class="main">
            <h3>Cerca Utente:</h3>
            <div class="bar">
                <input type="text" id="search" placeholder="Nome utente">
                <div class="imgStyle">
                    <img id="mGlass" src="src/search.png" alt="Cerca">
                </div>
            </div>
            <div id="result"></div>
            <hr>
            <div class="requests">
                <h3>Richieste di amicizia in sospeso</h3>
                <?php
                    $sql = "select p.sender, p.dataInvio from pending as p where p.reciver = ?";
                    $users = [];
                    if ($stmt = $db_connection->prepare($sql)) {
                        $stmt->bind_param("s", $_SESSION["UtenteMindWords"]);
                        if ($stmt->execute()) {
                            $data = $stmt->get_result();
                            $stmt->close();
                            while ($row = $data->fetch_assoc()) {
                                echo "
                                <div class='request'>
                                    <div>
                                        <h4>".$row["sender"]."</h4>
                                        <p>".$row["dataInvio"]."</p>
                                    </div>
                                    <img src='src/decline.png' alt='Rifiuta' class='rifiuta'>
                                    <img src='src/accept.png' alt='Accetta' class='accetta'>
                                </div>";
                                $users[] = $row["sender"];
                            }
                            echo "<script> const sender = ". json_encode($users) ."</script>";
                        }                        
                    }
                    $db_connection->close();
                ?>
            </div>
        </div>
    </div>
    <?php include "view/footer.php" ?>
    <script src="js/friend.js"></script>
</body>
</html>