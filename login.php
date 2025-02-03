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
    <title>Login</title>
</head>
<body>
    <?php
        if (isset($_SESSION["UtenteMindWords"])) {
            header("Location: index.php"); 
        }
    ?>
    <nav>
        <a class="linkLogo" href="index.php">
            <img class="icon" src="src/game.png" alt="Logo MindWords">
            <h1>MindWords</h1>
        </a>
    </nav>

    <div id="section">
        <div>
            <form action="Login.php" method="post">
                <div class="topForm">
                    <img class="icon" src="src/game.png" alt="Logo MindWords">
                    <h2>Bentornato</h2>
                    <p>Inserisci gentilmente i tuoi dettagli per fare il login</p>
                </div>
                <hr>
                <?php 
                    include "logic/loginlogic.php";
                ?>
                <div class="bottomForm">
                    <b class="textLabelFrom">Username</b>
                    <input name="LoginUsername" type="text" placeholder="Il tuo username" maxlength="30">
                    <div class="textLabelFrom displayFlex">
                        <b>Password</b> 
                        <a style="margin-left: auto" href="forget.php">Dimenticato la password?</a>
                    </div>
                    <div class="visible">
                        <input name="LoginPassword" type="password" placeholder="la tua Password" maxlength="50">
                        <div class="btnBg">
                            <img class="eye" src="src/visible.png" alt="visualizza password">
                        </div>
                    </div>
                </div>
                <div>
                    <input class="confirmBtn" type="submit" value="Accedi">
                    <div class="textCenter">
                        <p>Non sei ancora regisrato?<a href="register.php"><b>Cosa aspetti!</b></a></p> 
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
        include "view/footer.php"
    ?>
    <script src="js/password.js"></script>
</body>
</html>