<?php
    include('menu.php');
    if ($_SESSION['connecte']!=1) {
        header('Location: connexion.php');
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
    // Réaliser requête
    $requete = $conn->prepare("SELECT client.*, agence.* FROM client, agence WHERE agence.id = client.agence AND client.adresse_Mail = '".$_SESSION['identifiant']."'");
    $requete->execute();
    $resultat = $requete->get_result();
    $association = $resultat->fetch_assoc();
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
                <form method="post" action="modif_Infos.php" style="border:1px solid #ccc">
                    <div class="container">
                        <h1>Vos informations</h1>
                        <p>Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
                        <hr>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="civilite">Civilité</label> :</td>
                                <td id="civilite">
                                    <input type="radio" name="civilite" value="madame" id="madame" <?php if ($association['civilite']=='F') {echo "checked='checked'";}  ?> />
                                    <label for="madame">Mme</label>
                                    <input type="radio" name="civilite" value="monsieur" id="monsieur"  <?php if ($association['civilite']=='H') {echo "checked='checked'";}  ?>  />
                                    <label for="monsieur">M.</label>
                                </td> 
                            </tr>
                            <tr>   
                                <td><label for="nom">Nom</label> :</td>
                                <td><input type="text" name="nom" id="nom" size="20" minlength="2" maxlength="25" value="<?php echo ($association['nom']) ?>" /></td>   
                            </tr>
                            <tr>
                                <td><label for="prenom">Prénom</label> :</td>
                                <td><input type="text" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" value="<?php echo ($association['prenom']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="date_Naissance">Date de naissance</label> :</td>
                                <td><input type="date" name="date_Naissance" id="date_Naissance" value="<?php echo ($association['date_Naissance']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="pays">Pays :</label></td>
                                <td><select name="pays" id="pays" required>
                                <?php
                                            $id_fichier= fopen("liste_pays.txt","r");
                                            while($ligne=fgets($id_fichier,1024))
                                            {
                                                $ligne=explode(chr(9),$ligne);
                                                if ($ligne[1]=='France') // à remplacer par $association['pays']
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
                                    <input type="text" name="numero_Voie" id="numero_Voie" size="5" minlength="0" maxlength="5" placeholder="Entrez votre n° voie" value="<?php echo ($association['num_Voie']) ?>"  />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="voie">Voie</label> :
                                    <input type="text" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" value="<?php echo ($association['voie']) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>    
                                    <label for="code_Postal">Code postal</label> :
                                    <input type="text" name="code_Postal" id="code_Postal" size="5" minlength="5" maxlength="5" placeholder="Entrez votre code postal" value="<?php echo ($association['code_Postal']) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="ville">Ville</label> :
                                    <input type="text" name="ville" id="ville" size="10" minlength="5" maxlength="25" placeholder="Entrez votre ville" value="<?php echo ($association['ville']) ?>" />
                                </td>
                            </tr>

                            </tr>
                            <tr>
                                <td><label for="email">Adresse mail</label> :</td>
                                <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" value="<?php echo ($association['adresse_Mail']) ?>" /></td>
                            </tr>
                            <tr>
                                <td><label for="telephone">Téléphone</label> :</td>
                                <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" value="<?php echo ($association['telephone']) ?>" /></td>
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
                </form> <!--
                <hr>
                <h2>Votre agence</h2>
                <div>
                    <?php // echo($association['agence.num_Voie']) ?>
            </div> -->

            <div id="comptes" class="item_EC">
                <h3>Vos comptes</h3>
                <p>REQUETES SQL + lien détails compte pour chaque compte + lien ouvrir compte</p>
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