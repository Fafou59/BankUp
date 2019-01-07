<?php
    include('menu.php');
    if ($_SESSION['connecte']!=1) {
        header('Location: connexion.php');
    }
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
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
    //$requete = $conn->prepare("SELECT client.*, agence.* FROM client, agence WHERE client.id_Client = '".$_SESSION['id']."' AND agence.id_Agence = client.id_Client");
    $requete = $conn->prepare("SELECT client.* FROM client WHERE client.id_Client = '".$_SESSION['id']."'");
    $requete->execute();
    $resultat = $requete->get_result();
    $client = $resultat->fetch_assoc();

    //Réaliser requête agence
    $requete = $conn->prepare("SELECT agence.* FROM agence, client WHERE client.agence_Client = agence.id_Agence");
    $requete->execute();
    $resultat = $requete->get_result();
    $agence = $resultat->fetch_assoc();

    // Réaliser requête compte
    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_SESSION['id']."' = compte.id_Detenteur_Compte");
    $requete->execute();
    $resultat = $requete->get_result();

    // Réaliser requête bénéficiaires
    $requete3 = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE '".$_SESSION['id']."' = beneficiaire.id_Client_Emetteur");
    $requete3->execute();
    $resultat3 = $requete3->get_result();
    
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
            <button class="lienEC" onclick="openPage('informations', this, '#E80969')" id="defaultOpen">Vos informations</button>
            <button class="lienEC" onclick="openPage('comptes', this, '#E80969')" >Vos comptes</button>
            <button class="lienEC" onclick="openPage('virement', this, '#E80969')">Faire un virement</button>
            <button class="lienEC" onclick="openPage('beneficiaires', this, '#E80969')">Vos bénéficiaires</button>

            <div id="informations" class="item_EC">
                <h1>Vos informations</h1>
                <p>Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
                <form method="post" action="modif_Infos.php" style="border:1px solid #ccc">
                    <div class="container">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="civilite">Civilité</label> :</td>
                                <td id="civilite">
                                    <input type="radio" name="civilite" value="madame" id="madame" <?php if ($client['civilite_Client']=='F') {echo "checked='checked'";}  ?> />
                                    <label for="madame">Mme</label>
                                    <input type="radio" name="civilite" value="monsieur" id="monsieur"  <?php if ($client['civilite_Client']=='H') {echo "checked='checked'";}  ?>  />
                                    <label for="monsieur">M.</label>
                                </td> 
                            </tr>
                            <tr>   
                                <td><label for="nom">Nom</label> :</td>
                                <td><input type="text" name="nom" id="nom" size="20" minlength="2" maxlength="25" value="<?php echo ($client['nom_Client']) ?>" /></td>   
                            </tr>
                            <tr>
                                <td><label for="prenom">Prénom</label> :</td>
                                <td><input type="text" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" value="<?php echo ($client['prenom_Client']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="date_Naissance">Date de naissance</label> :</td>
                                <td><input type="date" name="date_Naissance" id="date_Naissance" value="<?php echo ($client['date_Naissance_Client']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="pays">Pays :</label></td>
                                <td><select name="pays" id="pays" required>
                                <?php
                                            $id_fichier= fopen("liste_pays.txt","r");
                                            while($ligne=fgets($id_fichier,1024))
                                            {
                                                $ligne=explode(chr(9),$ligne);
                                                if ($ligne[1]=='France') // France est sélectionné par défaut
                                                print '<option value='.$ligne[0].' selected="selected">'.$ligne[1].'</option>';
                                                else
                                                print '<option value='.$ligne[0].'>'.$ligne[1].'</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Adresse postale</label> :</td>
                                <td>
                                    <label for="numero_Voie">N° de voie</label> :
                                    <input type="text" name="numero_Voie" id="numero_Voie" size="5" minlength="0" maxlength="5" placeholder="Entrez votre n° voie" value="<?php echo ($client['num_Voie_Client']) ?>"  />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="voie">Voie</label> :
                                    <input type="text" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" value="<?php echo ($client['voie_Client']) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>    
                                    <label for="code_Postal">Code postal</label> :
                                    <input type="text" name="code_Postal" id="code_Postal" size="5" minlength="5" maxlength="5" placeholder="Entrez votre code postal" value="<?php echo ($client['code_Postal_Client']) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="ville">Ville</label> :
                                    <input type="text" name="ville" id="ville" size="10" minlength="5" maxlength="25" placeholder="Entrez votre ville" value="<?php echo ($client['ville_Client']) ?>" />
                                </td>
                            </tr>

                            </tr>
                            <tr>
                                <td><label for="email">Adresse mail</label> :</td>
                                <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" value="<?php echo ($client['adresse_Mail_Client']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="telephone">Téléphone</label> :</td>
                                <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" value="<?php echo ($client['telephone_Client']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="mdp">Mot de passe</label> :</td>
                                <td><input type="password" name="mdp" id="mdp" size="30" minlength="" maxlength="30" placeholder="Entrez votre mot de passe" /></td>
                            </tr>
                        </table><br />
                        <div class="bouton_Form">
                            <button type="submit" class="bouton_Valider">Modifier</button>
                            <button type="button" class="bouton_Annuler">Annuler</button>
                        </div>
                    </div>
                </form>
                <br /><hr>
                <h2>Votre agence</h2>
                <div>
                    <?php echo("BankUP ".$agence['ville_Agence']."<br />".$agence['num_Voie_Agence']." ".$agence['voie_Agence']."<br />".$agence['code_Postal_Agence']." ".$agence['ville_Agence']."<br />"); ?>
                </div>
            </div>

            <div id="comptes" class="item_EC">
                <h1>Vos comptes</h1>
                <p>Vous pouvez consulter ci-dessous vos comptes.<br />Vous pouvez également ouvrir un compte en cliquant sur le bouton situé en bas de la page.</p>
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

            <div id="virement" class="item_EC">
                <h1>Faire un virement</h1>
                <p>Formulaire pour réaliser virement</p>
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
                    <?php 
                    $i = 1;
                    while($beneficiaire = $resultat3->fetch_row()) {
                        echo("<p><h4>Bénéficiaire ".$i." :</h4><b>Libellé du bénéficiaire : ".$beneficiaire[2]."</b><br />Statut : ".$beneficiaire[3]."</p>");                      
                        echo "<hr>";
                        $i = $i + 1;
                    }
                    ?>
                </p>
            </div>
        </div>

    </body>


    <footer>
        <div></div>
    </footer>

</html>