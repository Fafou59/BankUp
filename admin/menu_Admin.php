<?php
//Démarrage de la session
    session_start();
    if (!isset($_SESSION["admin_Connecte"])) {
        $_SESSION["admin_Connecte"] = 0;
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
            <div id="item_Menu"></i> </a></div>
            <div id="item_Menu"><a href="index.php" title="Accueil"><img id="logo_BankUP" src="logo2.png" onclick="location.href='connexion_Admin.php'"alt="Accueil" /></a></div>
            <div id="item_Menu"></div>
            <div id="item_Menu"></div>
            <?php if ($_SESSION['admin_Connecte']==1) { ?>
                <div id="item_Menu"><button type="button" onclick="location.href='deconnexion_Admin.php'" title="Déconnexion" class="bouton_Connexion">DECONNEXION</button></div>
                <div id="item_Menu"><button type="button" onclick="location.href='espace_Admin.php'" title="Espace Admin" class="bouton_Inscription">ESPACE ADMIN</button></div>
            <?php } else {?>
                <div id="item_Menu"></div>
                <div id="item_Menu"><button type="button" onclick="location.href='connexion_Admin.php'" title="Connexion" class="bouton_Connexion">CONNEXION</button></div>
           <?php } ?>
                <div id="item_Menu"></div>
        </nav>
    </header>

    <body> <br />
        <button onclick="topFunction()" id="bouton_Haut" title="Haut de la page"><i class="fas fa-angle-up"></i></button>
    </body>


    <footer>
        <div></div>
    </footer>

</html>




