<?php
//Démarrage de la session
    session_start();
    if (!isset($_SESSION["connecte"])) {
        $_SESSION["connecte"] = 0;
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
        $origine = $_SERVER["HTTP_REFERER"];
    }
    else {
        $origine = "";
    }
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <script type="text/javascript" src="bouton_Haut.jsx"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    </head>

    <header>
        <nav>
            <div class="blank"></i> </a></div>
            <div><a href="index.php" title="Accueil"><img id="logo_BankUP" src="logo.png" onclick="location.href='index.php'"alt="Accueil" /></a></div>
            <div id="item_Menu"></div>
            <div id="item_Menu"></div>
            <?php if ($_SESSION['connecte']==1) { ?>
                <div id="item_Menu"><button type="button" onclick="location.href='deconnexion.php'" title="Déconnexion" class="bouton_Connexion">DECONNEXION</button></div>
                <div id="item_Menu"><button type="button" onclick="location.href='espace_Client.php'" title="Espace Client" class="bouton_Inscription">ESPACE CLIENT</button></div>
            <?php } else {?>
                <div id="item_Menu"><button type="button" onclick="location.href='connexion.php'" title="Connexion" class="bouton_Connexion">CONNEXION</button></div>
                <div id="item_Menu"><button type="button" onclick="location.href='inscription.php'" title="Inscription" class="bouton_Inscription">DEVENIR CLIENT</button></div>
           <?php } ?>
                <div class="blank"></div>
        </nav>
    </header>

    <body> <br />
        <button onclick="topFunction()" id="bouton_Haut" title="Haut de la page"><i class="fas fa-angle-up"></i></button>
        <script>
        // When the user scrolls the page, execute myFunction 
        window.onscroll = function() {myFunction()};

        function myFunction() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        document.getElementById("myBar").style.width = scrolled + "%";
        }
        </script>
    </body>


    <footer>
        <div></div>
    </footer>

</html>




