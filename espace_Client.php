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
    $requete = $conn->prepare("SELECT client.*, agence.* FROM client, agence WHERE client.id_Client = '".$_SESSION['id']."' AND agence.id_Agence = client.id_Client");
    $requete->execute();
    $resultat = $requete->get_result();
    $client = $resultat->fetch_assoc();

    // Réaliser requête compte
    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_SESSION['id']."' = compte.id_Detenteur_Compte");
    $requete->execute();
    $resultat = $requete->get_result();
    //$compte = $resultat->fetch_row();
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
                <form method="post" action="modif_Infos.php" style="border:1px solid #ccc">
                    <div class="container">
                        <h1>Vos informations</h1>
                        <p>Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
                        <hr>
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
                    <?php echo("BankUP ".$client['ville_Agence']."<br />".$client['num_Voie_Agence']." ".$client['voie_Agence']."<br />".$client['code_Postal_Agence']." ".$client['ville_Agence']."<br />"); ?>
                </div>
            </div>

            <div id="comptes" class="item_EC">
                <h1>Vos comptes</h1>
                <p>Vous pouvez consulter ci-dessous vos comptes.<br />Vous pouvez également ouvrir un compte en cliquant sur le bouton situé en bas de la page.</p>
                <hr>
                <?php 
                    //echo("<p>Compte 1 :<br />".$compte['libelle_Compte']."<br />Type : ".$compte['type_Compte']."<br />Solde : ".$compte['solde_Compte']."<br />IBAN : ".$compte['iban_Compte']."<br />BIC : ".$compte['bic_Compte']."<br />Date ouverture : ".$compte['date_Ouverture_Compte']."<br />Autorisation découvert : ".$compte['autorisation_Decouvert_Compte']);
                    $i = 1;
                    while($compte = $resultat->fetch_row()) {
                        echo("<h3>Compte ".$i." :</h3>Libellé du compte : ".$compte[4]."<br />Date ouverture : ".$compte[1]."<br />Type : ".$compte[2]."<br />Solde : ".$compte[3]."€<br />IBAN : ".$compte[5]."<br />BIC : ".$compte[6]."<br />Autorisation découvert : ".$compte[7]);
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
                <h1>Vos bénéficiares</h1>
                <p>REQUETES SQL liste bénéficiaires + bouton ajout bénéficiaire</p>
            </div>
            </div>
        </div>

    </body>


    <footer>
        <div></div>
    </footer>

</html>