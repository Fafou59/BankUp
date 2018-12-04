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
            <div id="item_Menu"><a href="index.php" title="Accueil"><img id="logo_BankUP" src="logo.png" onclick="location.href='index.php'"alt="Accueil" /></a></div>
            <div id="item_Menu"><a href="index.php" title="Accueil"> </a></div>
            <div id="item_Menu"></i> </a></div>
            <div id="item_Menu"></i> </a></div>
            <?php if ($_SESSION['connexion']=='') { ?>
                <div id="item_Menu"><button type="button" onclick="location.href='connexion.php'" title="Connexion" class="bouton_Connexion">CONNEXION</button></div>
                <div id="item_Menu"><button type="button" onclick="location.href='inscription.php'" title="Inscription" class="bouton_Inscription">DEVENIR CLIENT</button></div>
            <?php } else {?>
                <div id="item_Menu"><a href="#" title="Espace client">Espace client</a></div>
                <div id="item_Menu"><a href="#" title="Se déconnecter">Se déconnecter</a></div>
            <?php } ?>
        </nav>
    </header>

    <body>
        <button onclick="topFunction()" id="bouton_Haut" title="Haut de la page"><i class="fas fa-angle-up"></i></button>
    </body>


    <footer>
        <div></div>
    </footer>

</html>
