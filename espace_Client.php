<?php
    include('menu.php');
    if ($_SESSION['connecte']!=1) {
        header('Location: connexion.php');
    }
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <script type="text/javascript" src="menu_EC.jsx"></script>
        <title>BankUP - Espace Client</title>
    </head>


    <body>
        <div id="contenu">
            <button class="lienEC" onclick="openPage('informations', this, '#E80969')">Vos informations</button>
            <button class="lienEC" onclick="openPage('comptes', this, '#E80969')" id="defaultOpen">Vos comptes</button>
            <button class="lienEC" onclick="openPage('virement', this, '#E80969')">Faire un virement</button>
            <button class="lienEC" onclick="openPage('beneficiaire', this, '#E80969')">Vos bénéficiaires</button>

            <div id="informations" class="item_EC">
                <h3>Vos informations</h3>
                <p>REQUETES SQL + lien pour modifier informations</p>
            </div>

            <div id="comptes" class="item_EC">
                <h3>Vos comptes</h3>
                <p>REQUETES SQL + lien pour voir détails compte pour chaque compte</p>
            </div>

            <div id="virement" class="item_EC">
                <h3>Faire un virement</h3>
                <p>Formulaire pour réaliser virement</p>
            </div>

            <div id="beneficiaire" class="item_EC">
                <h3>Vos bénéficiares</h3>
                <p>REQUETES SQL liste bénéficiaires + bouton ajout bénéficiaire</p>
            </div> 
        </div>

    </body>


    <footer>
        <div></div>
    </footer>

</html>