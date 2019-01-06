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
        <title>BankUP - Ouverture compte</title>
    </head>

    <body>
        <div id="contenu">
        <?php
            if ((!isset($_POST['type_Compte'])) OR (!isset($_POST["libelle_Compte"]))) { ?>
                 <form method="post" action="ouvrir_Compte.php" style="border:1px solid #ccc">
            <div class="container">
                <h1>Création de votre compte</h1>
                <p>Merci de compléter les informations ci-dessous.</p>
                <hr>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><label for="type_Compte">Type de compte*</label> :</td>
                        <td id="type_Compte">
                            <input type="radio" name="type_Compte" value="epargne" id="epargne"  />
                            <label for="epargne">Compte Epargne</label>
                            <input type="radio" name="type_Compte" value="courant" id="courant"  />
                            <label for="courant">Compte Courant</label>
                        </td> 
                    </tr>
                    <tr>   
                        <td><label for="libelle_Compte">Libellé du compte</label> :</td>
                        <td><input type="text" name="libelle_Compte" id="libelle_Compte" size="20" minlength="2" maxlength="25" placeholder="Entrez le libellé du compte" /></td>   
                    </tr>
                </table>

            <p>En validant la création du compte, vous acceptez nos <a href="#" style="color:dodgerblue">Conditions Générales de Vente</a>.</p>

            <div class="bouton_Form">
                <button type="button" class="bouton_Annuler">Retour</button>
                <button type="submit" class="bouton_Valider">Valider</button>
            </div>
        </div>
        </form>
        <?php
            } else {
                $type_Compte = $_POST['type_Compte'];
                $libelle_Compte = $_POST['libelle_Compte'];
                $pays = $_POST['libelle_Compte'];
                $date = date('Y/m/d');
                $iban = "FR".trim(rand(100000000,999999999)).trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
                $solde_Compte = 2000;
                $bic = "BKUPFRPP";
                $autorisation_Decouvert = 100;

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bankup";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO compte (date_Ouverture_Compte, type_Compte, solde_Compte, libelle_Compte, iban_Compte, bic_Compte, autorisation_Decouvert_Compte, id_Detenteur_Compte)
                VALUES ('".$date."', '".$type_Compte."', '".$solde_Compte."', '".$libelle_Compte."', '".$iban."', '".$bic."', '".$autorisation_Decouvert."', '".$_SESSION["id"]."')";

                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Votre compte a bien été créé.</h1>
                        <p>Vous avez bénéficié de notre offre d'accueil de 1000€ ! Ils ont bien été ajoutés à votre compte..</p>
                        <hr>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Valider" onclick="location.href='espace_Client.php'">Aller sur votre espace client</button>
                        </div>
                    </div> <?php
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        ?> 
        
    </body>