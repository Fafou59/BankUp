<?php
    include('menu_Admin.php');
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <title>BankUP ADMIN - Inscription</title>
    </head>

    <body>
        <?php
            if ((!isset($_POST['civilite'])) OR (!isset($_POST["mdp"])) OR (!isset($_POST['telephone'])) OR (!isset($_POST['email'])) OR (!isset($_POST['ville'])) OR (!isset($_POST['code_Postal'])) OR (!isset($_POST['voie'])) OR (!isset($_POST['numero_Voie'])) OR (!isset($_POST['nom'])) OR (!isset($_POST['prenom'])) OR (!isset($_POST['date_Naissance'])) OR (!isset($_POST['pays']))) { ?>
                <form class="formulaire" method="post" action="inscription_Admin.php" style="border:1px solid #ccc">
                <div class="container">
                    <h1>Création du profil client</h1>
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
                                <input type="text" name="numero_Voie" id="numero_Voie" size="5" minlength="0" maxlength="5" placeholder="Entrez votre n° voie" />
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
                                <input type="text" name="code_Postal" id="code_Postal" size="5" minlength="5" maxlength="5" placeholder="Entrez votre code postal" required />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <label for="ville">Ville</label> :
                                <input type="text" name="ville" id="ville" size="10" minlength="5" maxlength="25" placeholder="Entrez votre ville" required />
                            </td>
                        </tr>
    
                        </tr>
                        <tr>
                            <td><label for="email">Adresse mail</label> :</td>
                            <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" required /></td>
                        </tr>
                        <tr>
                            <td><label for="telephone">Téléphone</label> :</td>
                            <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" required /></td>
                        </tr>
                        <tr>
                            <td><label for="mdp">Mot de passe</label> :</td>
                            <td><input type="password" name="mdp" id="mdp" size="30" minlength="2" maxlength="30" placeholder="Entrez votre mot de passe" required /></td>
                        </tr>
                    </table>    
                <div class="bouton_Form">
                    <button type="button" class="bouton_Annuler" >Retour</button>
                    <button type="submit" class="bouton_Valider">Valider</button>
                </div>
            </div>
            </form> <?php
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
                    $agence = 1;
                } else {
                    $agence = 2;
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

                $sql = "INSERT INTO client (civilite_Client, nom_Client, prenom_Client, date_Naissance_Client, adresse_Mail_Client, telephone_Client, num_Voie_Client, voie_Client, code_Postal_Client, ville_Client, mdp_Client, agence_Client, pays_Client)
                VALUES ('".$civilite."', '".$nom."', '".$prenom."', '".$date_Naissance."', '".$email."', '".$telephone."', '".$numero_Voie."', '".$voie."', '".$code_Postal."', '".$ville."', '".$mdp."','".$agence."','".$pays."')";

                if ($conn->query($sql) === TRUE) { 
                    header('Location: espace_Admin.php');
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        ?> 
        
    </body>


    <footer>
        
    </footer>

</html>
