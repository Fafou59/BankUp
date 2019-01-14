<?php
    // Ajout du menu
    include('support/menu_Admin.php');
    
    // Vérifier si admin connecté, si non renvoie vers page de connexion
    if (!isset($_SESSION['admin_Id'])) {
        header("Location: connexion_Admin.php");
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>ADMIN BankUP - Inscription</title>
    </head>

    <body>
        <?php
            // Si les données ne sont pas entrées
            if (!isset($_POST['civilite'], $_POST["mdp"], $_POST['telephone'], $_POST['email'], $_POST['ville'], $_POST['code_Postal'], $_POST['voie'], $_POST['numero_Voie'], $_POST['nom'], $_POST['prenom'], $_POST['date_Naissance'], $_POST['pays'])) { ?>
                <form class="formulaire" method="post" action="inscription_Admin.php" style="border:1px solid #ccc">
                    <div class="container">
                        <h1>Création de votre profil</h1>
                        <p>Merci de compléter les informations ci-dessous.</p>
                        <hr>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><label for="civilite">Civilité*</label> :</td>
                                <td id="civilite">
                                    <input type="radio" name="civilite" value="madame" id="madame" required />
                                    <label for="madame">Mme</label>
                                    <input type="radio" name="civilite" value="monsieur" id="monsieur" required />
                                    <label for="monsieur">M.</label>
                                </td> 
                            </tr>
                            <tr>   
                                <td><label for="nom">Nom</label> :</td>
                                <td><input type="text" name="nom" id="nom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre nom" required /></td>   
                            </tr>
                            <tr>
                                <td><label for="prenom">Prénom</label> :</td>
                                <td><input type="text" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" required /></td>
                            </tr>
                            <tr>
                                <td><label for="date_Naissance">Date de naissance</label> :</td>
                                <td><input type="date" name="date_Naissance" id="date_Naissance" required /></td>
                            </tr>
                            <tr>
                                <td><label for="pays">Natonalité :</label></td>
                                <td><select name="pays" id="pays" required>
                                    <?php // Rechercher la liste des pays dans le fichier correspondant pour alimenter la liste
                                        $id_fichier= fopen("support/liste_pays.txt","r");
                                        while($ligne=fgets($id_fichier,1024))
                                        {
                                            $ligne=explode(chr(9),$ligne);
                                            if ($ligne[1]=='France') // France est sélectionné par défaut
                                            print '<option value='.$ligne[0].' selected="selected">'.$ligne[1].'</option>';
                                            else
                                            print '<option value='.$ligne[0].'>'.$ligne[1].'</option>';
                                        }
                                    ?>
                                </select></td>
                            </tr>
                            <tr>
                                <td><label>Adresse postale</label> :</td>
                                <td>
                                    <label for="numero_Voie">N° de voie</label> :
                                    <input type="number" name="numero_Voie" id="numero_Voie" min="0" max="99999" placeholder="Entrez votre n° voie" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="voie">Voie</label> :
                                    <input type="text" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" required />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>    
                                    <label for="code_Postal">Code postal</label> :
                                    <input type="number" name="code_Postal" id="code_Postal" size="5" min="0" max="99999" placeholder="Entrez votre code postal" required />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="ville">Ville</label> :
                                    <input type="text" name="ville" id="ville" size="10" minlength="0" maxlength="25" placeholder="Entrez votre ville" required />
                                </td>
                            </tr>
                            </tr>
                            <tr>
                                <td><label for="email">Adresse mail</label> :</td>
                                <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" required /></td>
                            </tr>
                            <tr>
                                <td><label for="telephone">Téléphone</label> :</td>
                                <td><input type="tel" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" required /></td>
                            </tr>
                            <tr>
                                <td><label for="mdp">Mot de passe</label> :</td>
                                <td><input type="password" name="mdp" id="mdp" size="30" minlength="" maxlength="30" placeholder="Entrez votre mot de passe" required /></td>
                            </tr>
                        </table>
                        <p>En créant votre profil, vous acceptez nos <a href="#" style="color:dodgerblue">Conditions Générales d'utilisation</a>.</p>
                        <div class="bouton_Form">
                            <button type="button" class="bouton_Annuler" >Retour</button>
                            <button type="submit" class="bouton_Valider">Valider</button>
                        </div>
                    </div>
                </form> <?php
            // Si les données sont disponibles
            } else {
                // Adaptation de la donnée civilité
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
                // Répartition de l'agence entre parisiens/provinciaux
                if (substr($code_Postal,0,2)==75) {
                    $agence = 1;
                } else {
                    $agence = 2;
                }

                // Connexion à la bdd
                include('support/connexion_bdd.php');

                // Exécution de la requête pour ajouter le client
                $sql = "INSERT INTO client (civilite_Client, nom_Client, prenom_Client, date_Naissance_Client, adresse_Mail_Client, telephone_Client, num_Voie_Client, voie_Client, code_Postal_Client, ville_Client, mdp_Client, agence_Client, pays_Client)
                VALUES ('".$civilite."', '".$nom."', '".$prenom."', '".$date_Naissance."', '".$email."', '".$telephone."', '".$numero_Voie."', '".$voie."', '".$code_Postal."', '".$ville."', '".$mdp."','".$agence."','".$pays."')";

                // Si la requête s'effectue correctement
                if ($conn->query($sql) === TRUE) { ?>
                    <!-- Redirection après 3 secondes -->
                    <meta http-equiv="Refresh" content="3;URL=espace_Admin.php">
                    <div class="container">
  				        <table>
                            <tr>
                                <td><img id="ckeck_icon" src="images/bouton_Ok.png" style="width: 60px; margin-left: 30px; margin-right: 30px;"></td>
                                <td><h1 style="font-variant: small-caps;">Le profil a bien été créé.</h1></td>	
                            </tr>
                        </table>
                        <hr>
                        <h2>Vous allez être redirigé vers l'espace administrateur.</h2>
                    </div> <?php
                // Si requête KO
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        ?> 
    </body>

</html>