<?php
    include('menu.php');
    if ($_SESSION['connecte']==1) {
        header('Location: espace_Client.php');
    }
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <title>BankUP - Connexion</title>
    </head>

    <header>
        
    </header>

<?php
    if (isset($_POST["identifiant"]) AND isset($_POST["mdp"])) {
        $identifiant = $_POST["identifiant"];
        $mdp = $_POST["mdp"];
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bankup";

        // Se connecter à la bdd
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Vérifier connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Réaliser requête
        $requete = $conn->prepare("SELECT id_Client, adresse_Mail_Client, mdp_Client FROM client WHERE adresse_Mail_Client = '".$identifiant."'");
        $requete->execute();
        $resultat = $requete->get_result();
        $association = $resultat->fetch_assoc();

        if ($association['mdp_Client']==sha1($_POST['mdp'])) {
            $_SESSION['connecte'] = 1;
            $_SESSION['identifiant'] = $identifiant;
            $_SESSION['id'] = $association['id_Client'];
            header("Location: espace_Client.php");
        }
        else { ?>
    <body>
        <form class="formulaire" method="post" action="connexion.php" style="border:1px solid #ccc">
            <div class="container">
                <h1>Connexion à votre espace client</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <hr>
                <p style="color:red">Nom d'utilisateur ou mot de passe éroné, veuillez réessayer.</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>   
                        <td><label for="identifiant">Identifiant</label> :</td>
                        <td><input type="text" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                    </tr>
                    <tr>
                        <td><label for="mdp">Mot de passe</label> :</td>
                        <td><input type="password" name="mdp" id="mdp" size="20" minlength="2" maxlength="25" placeholder="Entrez votre mot de passe" autofocus /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> <br />
                            <a href="#" title="Mot de passe oublié">Mot de passe oublié ?</a>
                        </td>
                    </tr>
                </table><br />
                <div class="bouton_Form">
                    <button type="submit" class="bouton_Valider">Valider</button>
                    <button type="button" class="bouton_Annuler">Annuler</button>
                </div>
            </div>
        </form>
    </body>
        <?php }
    } else {
?>
    <body>
        <form class="formulaire" method="post" action="connexion.php" style="border:1px solid #ccc">
            <div class="container">
                <h1>Connexion à votre espace client</h1>
                <p>Merci de renseigner vos identifiants de connexion.</p>
                <hr>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>   
                        <td><label for="identifiant">Identifiant</label> :</td>
                        <td><input type="text" name="identifiant" id="identifiant" size="20" minlength="2" maxlength="25" placeholder="Entrez votre identifiant" autofocus /></td>   
                    </tr>
                    <tr>
                        <td><label for="mdp">Mot de passe</label> :</td>
                        <td><input type="password" name="mdp" id="mdp" size="20" minlength="2" maxlength="25" placeholder="Entrez votre mot de passe" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href="#" title="Mot de passe oublié">Mot de passe oublié ?</a>
                        </td>
                    </tr>
                </table>
                <div class="bouton_Form">
                    <button type="button" class="bouton_Annuler">Annuler</button>
                    <button type="submit" class="bouton_Valider">Se connecter</button>
                </div>
            </div>
        </form>
    </body>
    <?php }
?>

    <footer>
        <div></div>
    </footer>

</html>