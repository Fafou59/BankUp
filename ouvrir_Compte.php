<?php
    // Ajout du menu
    include('support/menu.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BankUP - Ouverture compte</title>
    </head>

    <body>
        <div id="contenu">
        <?php
            // Si données indisponibles, formulaire de création de compte
            if ((!isset($_POST['type_Compte'])) OR (!isset($_POST["libelle_Compte"]))) { ?>
                <div class="container">
                <h1>Création de votre compte</h1>
                <p>Merci de compléter les informations ci-dessous.</p>
                <hr>
                <form method="post" action="ouvrir_Compte.php" style="border:1px solid #ccc">
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
                    <div class="bouton_Form">
                        <button type="button" class="bouton_Annuler">Retour</button>
                        <button type="submit" class="bouton_Valider">Valider</button>
                    </div>
                </form>
            </div>
        <?php
            // Si données fournies
            } else {
                $type_Compte = $_POST['type_Compte'];
                $libelle_Compte = $_POST['libelle_Compte'];
                $pays = $_POST['libelle_Compte'];
                // Adaptation de la donnée date
                $date = date('Y/m/d');
                // Génération aléatoire de l'IBAN (27 caractères, dont 25 chiffres)
                $iban = "FR".trim(rand(100000000,999999999)).trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
                // Octroie de l'offre de bienvenue pour les comptes courants
                if ($type_Compte == "courant") {
                    $solde_Compte = 1000;
                } else {
                    $solde_Compte = 0;
                }
                $bic = "BKUPFRPP";
                $autorisation_Decouvert = 0;

                // COnnexion à bdd
                include('support/connexion_bdd.php');

                // Requête ajout du compte
                $sql = "INSERT INTO compte (date_Ouverture_Compte, type_Compte, solde_Compte, libelle_Compte, iban_Compte, bic_Compte, autorisation_Decouvert_Compte, id_Detenteur_Compte)
                VALUES ('".$date."', '".$type_Compte."', '".$solde_Compte."', '".$libelle_Compte."', '".$iban."', '".$bic."', '".$autorisation_Decouvert."', '".$_SESSION["id"]."')";

                // Si ajout réalisé
                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Votre compte a bien été créé.</h1>
                        <?php if ($type_Compte == "courant") { ?>
                            <p>Vous avez bénéficié de notre offre d'accueil de 1000€ ! Ils ont bien été ajoutés à votre compte..</p>
                        <?php } ?>
                        <hr>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Valider" onclick="location.href='espace_Client.php'">Aller sur votre espace client</button>
                        </div>
                    </div> <?php
                // Si requête KO
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        ?> 
        
    </body>