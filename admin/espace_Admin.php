<?php
    include('menu_Admin.php');
    if ($_SESSION['admin_Connecte']!=1) {
        header('Location: connexion_Admin.php');
    }
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }

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

    // Réaliser requête client
    $requete = $conn->prepare("SELECT client.* FROM client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."'");
    $requete->execute();
    $clients = $requete->get_result();

    // Réaliser requête bénéficiaires
    $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE beneficiaire.validite_Beneficiaire = 0 AND beneficiaire.id_Client_Emetteur IN (SELECT client.id_Client FROM client WHERE client.agence_Client = '".$_SESSION['admin_Agence']."')");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    // Réaliser requête chèques
    $requete = $conn->prepare("SELECT operation.*, chequier.* FROM operation, chequier WHERE operation.validite_Operation = 0 AND operation.id_Chequier_Operation = chequier.id_Chequier AND chequier.id_Chequier IN (SELECT chequier.id_Chequier FROM chequier, client, compte WHERE client.agence_Client = '".$_SESSION['admin_Agence']."' AND client.id_Client = compte.id_Detenteur_Compte AND chequier.id_Compte_Rattache = compte.id_Compte)");
    $requete->execute();
    $cheques = $requete->get_result();



?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <script type="text/javascript" src="menu_EC.jsx"></script>
        <title>ADMIN BankUP - Espace Admin</title>
    </head>


    <body>
        <div id="contenu">
            <button class="lienEC" onclick="openPage('clients', this, '#E80969')" id="defaultOpen">Liste des clients</button>
            <button class="lienEC" onclick="openPage('beneficiaires', this, '#E80969')" >Bénéficiaires à valider</button>
            <button class="lienEC" onclick="openPage('cheques', this, '#E80969')">Chèques à valider</button>
            <button class="lienEC" onclick="openPage('autorisations', this, '#E80969')">Autorisations découvert</button>

            <div id="clients" class="item_EC">
                <h1>Les clients de votre agence</h1>
                <p>
                    Tous les clients de votre agence sont affichés ci-dessous. Vous pouvez également créer un nouveau client.
                    <button type="submit" class="bouton_Valider" onclick="location.href='inscription_Admin.php'">Créer un client</button>
                    <hr>
                </p>
                <div class="container">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th>N°</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Adresse mail</th>
                            <th>Accéder au profil</th>
                        </tr>
                        <?php 
                        $i = 1;
                        while($client = $clients->fetch_row()) { ?>
                            <tr>
                                <td><?php echo($i)?></td>
                                <td><?php echo($client[3])?></td>
                                <td><?php echo($client[2])?></td>
                                <td><?php echo($client[6])?></td>
                                <td><form method="post" action="mirroring_Admin.php">
                                    <button name="id_Client" type="submit" class="bouton_Profil" value="<?php echo ($client[0]) ?>">Profil</button>
                                </form></td>
                            </tr>
                            <?php
                            $i = $i + 1;
                        } ?>
                    </table>
                </div>
            </div>

            <div id="beneficiaires" class="item_EC">
                <h1>Les bénéficiaires à valider</h1>
                <p>Vous pouvez consulter ci-dessous les chèques en attente de validation.</p>
                <hr>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Client demandeur</th>
                        <th>Compte bénéficiaire</th>
                        <th>Détenteur compte</th>
                        <th>Valider</th>
                        <th>Supprimer</th>
                    </tr>
                    <?php
                    while($beneficiaire = $beneficiaires->fetch_row()) { ?>
                        <tr>
                            <td><?php
                                $requete = $conn->prepare("SELECT client.* FROM client WHERE client.id_Client = ".$beneficiaire[2]);
                                $requete->execute();
                                $resultat = $requete->get_result();
                                $emetteur_detail = $resultat->fetch_assoc();
                                echo($emetteur_detail['prenom_Client'].' '.$emetteur_detail['nom_Client']); ?>
                            </td>
                            <td><?php 
                                $requete = $conn->prepare("SELECT compte.*, client.* FROM compte, client WHERE compte.id_Compte = ".$beneficiaire[1]." AND compte.id_Detenteur_Compte = client.id_Client");
                                $requete->execute();
                                $resultat = $requete->get_result();
                                $beneficiaire_detail = $resultat->fetch_assoc();
                                echo($beneficiaire_detail['libelle_Compte'].' - IBAN : '.$beneficiaire_detail['iban_Compte']); ?>
                            </td>
                            <td><?php
                                echo($beneficiaire_detail['prenom_Client'].' '.$beneficiaire_detail['nom_Client']); ?>
                            </td>
                            <td><form method="post" action="validation_Beneficiaire.php">
                                <button name="id_Beneficiaire" type="submit" class="bouton_Ajout" value="<?php echo ($beneficiaire[0]) ?>">Valider</button>
                            </form></td>
                            <td><form method="post" action="suppression_Beneficiaire.php">
                                <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>">Supprimer</button>
                            </form></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div id="cheques" class="item_EC">
                <h1>Les chèques à valider</h1>
                <p>Ci-dessous est affichée la liste des chèques en attente d'une validation.</p>
                <hr>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Client émetteur</th>
                        <th>Compte bénéficiaire</th>
                        <th>Détenteur compte</th>
                        <th>Montant du chèque</th>
                        <th>Valider</th>
                        <th>Supprimer</th>
                    <tr>
                    <?php
                    while($cheque = $cheques->fetch_row()) { ?>
                        <tr>
                            <td><?php
                                $requete = $conn->prepare("SELECT client.prenom_Client, client. nom_Client FROM client, compte WHERE client.id_Client = compte.id_Detenteur_Compte AND compte.id_Compte = ".$cheque[2]);
                                $requete->execute();
                                $resultat = $requete->get_result();
                                $emetteur_detail = $resultat->fetch_assoc();
                                echo($emetteur_detail['prenom_Client'].' '.$emetteur_detail['nom_Client']); ?>
                            </td>
                            <td><?php 
                                $requete = $conn->prepare("SELECT compte.*, client.* FROM compte, client WHERE compte.id_Compte = ".$cheque[3]." AND compte.id_Detenteur_Compte = client.id_Client");
                                $requete->execute();
                                $resultat = $requete->get_result();
                                $beneficiaire_detail = $resultat->fetch_assoc();
                                echo($beneficiaire_detail['libelle_Compte'].' - IBAN : '.$beneficiaire_detail['iban_Compte']); ?>
                            </td>
                            <td><?php
                                echo($beneficiaire_detail['prenom_Client'].' '.$beneficiaire_detail['nom_Client']); ?>
                            </td>
                            <td><?php
                                echo($cheque[5].'€');?>
                            </td>
                            <td><form method="post" action="cheque.php">
                                <button name="id_Cheque_Ajout" type="submit" class="bouton_Ajout" value="<?php echo ($cheque[0]) ?>">Valider</button>
                            </form></td>
                            <td><form method="post" action="cheque.php">
                                <button name="id_Cheque_Suppression" type="submit" class="bouton_Suppression" value="<?php echo ($cheque[0]) ?>">Supprimer</button>
                            </form></td>                            
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div id="autorisations" class="item_EC">
                <h1>Autorisations de découvert</h1>
                <p>Vous pouvez paramétrer les autorisations de découvert des comptes des clients de votre agence.</p>
                <hr>

            </div>
        </div>

    </body>


    <footer>
        <div></div>
    </footer>

    <script>
        document.getElementById("defaultOpen").click();
    </script>

</html>