<?php
    include('menu.php');
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
            if ((!isset($_POST['civilite'])) OR (!isset($_POST["mdp"])) OR (!isset($_POST['telephone'])) OR (!isset($_POST['email'])) OR (!isset($_POST['ville'])) OR (!isset($_POST['code_Postal'])) OR (!isset($_POST['voie'])) OR (!isset($_POST['numero_Voie'])) OR (!isset($_POST['nom'])) OR (!isset($_POST['prenom'])) OR (!isset($_POST['date_Naissance'])) OR (!isset($_POST['pays']))) { ?>
                 <form method="post" action="creation_Compte.php" style="border:1px solid #ccc">
            <div class="container">
                <h1>Création de votre compte</h1>
                <p>Merci de compléter les informations ci-dessous.</p>
                <hr>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><label for="type_Compte">Type de compte*</label> :</td>
                        <td id="type_Compte">
                            <input type="radio" name="type_Compte" value="epargne" id="epargne"  />
                            <label for="madame">Compte Epargne</label>
                            <input type="radio" name="type_Compte" value="courant" id="courant"  />
                            <label for="monsieur">Compte Courant</label>
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
                if ($_POST['civilite'] == "monsieur") {
                    $civilite = "H";
                }
                else {
                    $civilite = "F";
                }
                $nom = $_POST['nom'];
                $date_Naissance = $_POST['date_Naissance'];
                $prenom = $_POST['prenom'];
                $pays = $_POST['pays'];
                $numero_Voie = $_POST['numero_Voie'];
                $voie = $_POST['voie'];
                $code_Postal = $_POST['code_Postal'];
                $ville = $_POST['ville'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $mdp = sha1($_POST['mdp']);
                if (substr($code_Postal,0,2)==75) {
                    $agence = 2;
                } else {
                    $agence = 1;
                }

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

                $sql = "INSERT INTO client (civilite, nom, prenom, date_Naissance, adresse_Mail, telephone, num_Voie, voie, code_Postal, ville, mdp, agence)
                VALUES ('".$civilite."', '".$nom."', '".$prenom."', '".$date_Naissance."', '".$email."', '".$telephone."', '".$numero_Voie."', '".$voie."', '".$code_Postal."', '".$ville."', '".$mdp."','".$agence."')";

                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Votre compte a bien été créé.</h1>
                        <p>Vous avez bénéficié de notre offre d'accueil de 1000€ ! Ils ont bien été ajoutés à votre compte..</p>
                        <hr>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Valider" onclick="location.href='espace_CLient.php'">Aller sur votre espace client</button>
                        </div>
                    </div> <?php
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        ?> 
        
    </body>