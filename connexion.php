<?php
//Démarrage de la session
    session_start();
    $_SESSION['connexion']='';
    include('menu.php');
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
    </head>

    <header>
        
    </header>

    <body>
        <form action="connexion_Profil.php" style="border:1px solid #ccc">
            <div class="container">
                <h1>Connexion à votre espace client</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <hr>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>   
                        <td><label for="identifiant">Indentifiant</label> :</td>
                        <td><input type="text" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                    </tr>
                    <tr>
                        <td><label for="mot_De_Passe">Mot de passe</label> :</td>
                        <td><input type="text" name="mot_De_Passe" id="mot_De_Passe" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" autofocus /></td>
                    </tr>
    

            <div class="bouton_Form">
            <button type="button" class="bouton_Annuler">Annuler</button>
            <button type="submit" class="bouton_Valider">Valider</button>
            </div>
        </div>
        </form>

    </body>


    <footer>
        <div></div>
    </footer>

</html>
