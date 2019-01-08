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
            <button class="lienEC" onclick="openPage('cheques', this, '#E80969')" >Chèques à valider</button>
            <button class="lienEC" onclick="openPage('operations', this, '#E80969')">Vos opérations</button>
            <button class="lienEC" onclick="openPage('beneficiaires', this, '#E80969')">Vos bénéficiaires</button>

            <div id="clients" class="item_EC">
                <h1>Les clients de votre agence</h1>
                <p>
                    Tous les clients de votre agence sont affichés ci-dessous.<br />
                    Vous pouvez également créer un nouveau client.
                    <button type="submit" class="bouton_Valider" onclick="location.href='inscription_Admin.php'">Créer un client</button>
                    <hr>
                </p>
                <div class="container">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php 
                        $i = 1;
                        echo("<tr><td>N°</td><td>Prénom</td><td>Nom</td><td>Adresse mail</td><td>Accéder au profil</td></tr>");
                        while($client = $clients->fetch_row()) {
                            echo("<tr><td>".$i."</td><td>".$client[3]."</td><td>".$client[2]."</td><td>".$client[6]."</td>"); ?>
                            <td><form method="post" action="mirroring_Admin.php">
                                <button name="id_Client" type="submit" class="bouton_Profil" value="<?php echo ($client[0]) ?>">Profil</button><br /><br />
                            </form></td></tr>
                            <?php
                            $i = $i + 1;
                        }
                    ?>
                    </table>
                </div>

            <div id="cheques" class="item_EC">
                <h1>Les chèques à valider</h1>
                <p>Vous pouvez consulter ci-dessous les chèques en attente de validation.</p>
                <hr>
                <?php 
                    $i = 1;
                    while($compte = $resultat->fetch_row()) {
                        echo("<p><h3>Compte ".$i." :</h3><b>Libellé du compte : ".$compte[4]."</b><br />Date ouverture : ".$compte[1]."<br />Type : ".$compte[2]."<br />Solde : ".$compte[3]."€<br />IBAN : ".$compte[5]."<br />BIC : ".$compte[6]."<br />Autorisation découvert : ".$compte[7]."€</p>");                      
                        
                        //Gérer les CB et chéquiers
                        if ($compte[2]=="courant") {
                            //CB
                            $requete = $conn->prepare("SELECT cb.* FROM cb WHERE cb.id_Compte_Rattache = ".$compte[0]);
                            $requete->execute();
                            $resultat2 = $requete->get_result();
                            $cb = $resultat2->fetch_assoc();
                            if ($cb['id_Compte_Rattache']==$compte[0]) {
                                echo("<p><h4>Carte bancaire associée :</h4>Numéro de carte : ".$cb['num_Cb']."<br />Cryptogramme : ".$cb['cryptogramme_Cb']."<br />Date expiration : ".$cb['date_Expiration_Cb']."</p>");
                            } else {
                                ?>
                                <form method="post" action="creation_Cb.php">
                                    <button name="id_Compte" type="submit" class="bouton_Cb" value="<?php echo ($compte[0]) ?>">Demander une carte</button><br /><br />
                                </form>
                            <?php }
                            
                            //Chéquier
                            $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$compte[0]);
                            $requete->execute();
                            $resultat2 = $requete->get_result();
                            $chequier = $resultat2->fetch_assoc();
                            if ($chequier['id_Compte_Rattache']==$compte[0]) {
                                echo("<p><h4>Chequier associé :</h4>Date d'émission : ".$chequier['date_Emission_Chequier']."</p>"); ?>
                                <form method="post" action="creation_Chequier.php">
                                    <button name="id_Compte" type="submit" class="bouton_Chequier" value="<?php echo ($compte[0]) ?>">Demander un nouveau chéquier</button><br /><br />
                                </form>
                            <?php } else {
                                ?>
                                <form method="post" action="creation_Chequier.php">
                                    <button name="id_Compte" type="submit" class="bouton_Chequier" value="<?php echo ($compte[0]) ?>">Demander un chéquier</button><br /><br />
                                </form>
                            <?php }
                        }

                        echo "<hr>";
                        $i = $i + 1;
                    }
                ?>
                <button type="submit" class="bouton_Valider" onclick="location.href='ouvrir_Compte.php'">Ouvrir un compte</button><br /><br />
            </div>

            <div id="operations" class="item_EC">
                <h1>Vos opérations</h1>
                <p>Liste des opérations passées + lien vers formulaire virement</p>
            </div>

            <div id="beneficiaires" class="item_EC">
                <h1>Vos bénéficiaires</h1>
                <p>
                    Vous trouverez ci-dessous la liste de vos bénéficiaires.<br />
                    Vous pouvez ajouter un bénéficiaire avec le formulaire ci-dessous, et supprimer les bénéficiaires déjà enregistrés.
                </p>
                <hr>
                <h3>Ajout d'un bénéficiaire</h3>
                <p>Merci de compléter les informations ci-dessous pour ajouter un bénéficiaire.</p>
                <form class="formulaire" method="post" action="creation_Beneficiaire.php" style="border:1px solid #ccc">
                    <div class="container">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="libelle_Beneficiaire">Libellé du bénéficiaire</label> :</td>
                                <td><input type="text" name="libelle_Beneficiaire" id="libelle_Beneficiaire" size="20" minlength="2" maxlength="25" placeholder="Entrez le libellé du bénéficiaire" required /></td>
                            </tr>
                            <tr>   
                                <td><label for="iban">IBAN</label> :</td>
                                <td><input type="text" name="iban" id="iban" size="27" minlength="27" maxlength="27" placeholder="Entrez l'IBAN du bénéficiaire" required /></td>   
                            </tr>
                        </table>
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Valider">Ajouter</button>
                        </div>
                    </div>
                </form>
                <p>
                    <h3>Vos bénéficiaires enregistrés</h3>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php 
                    $i = 1;
                    echo("<tr><td>N°</td><td>Libellé du bénéficiaire</td><td>Statut</td><td>Effectuer virement</tr>");
                    while($beneficiaire = $resultat3->fetch_row()) {
                        if ($beneficiaire[3]==1) {
                            echo("<tr><td>".$i."</td><td>".$beneficiaire[2]."</td><td>Actif</td>"); ?>
                            <td><form method="post" action="virement.php">
                                <button name="id_Beneficiaire" type="submit" class="bouton_Cb" value="<?php echo ($compte[0]) ?>">Demander une carte</button><br /><br />
                            </form></td></tr>
                        <?php } else {
                            echo("<tr><td>".$i."</td><td>".$beneficiaire[2]."</td><td>En attente</td>");
                        }
                        $i = $i + 1;
                    }
                    ?>
                    </table>
                </p>
            </div>
        </div>

    </body>


    <footer>
        <div></div>
    </footer>

</html>