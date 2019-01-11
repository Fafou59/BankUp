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
    $requete3 = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE beneficiaire.id_Client_Emetteur = '".$_SESSION['id']."'");
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
        <div id="contenu" style="width:100%">
            <div class="lienEC" style="width: 14%"> </div> 
            <button class="lienEC" onclick="openPage('informations', this, '#f1f1f1')" style="width: 18%" id="defaultOpen">vos informations</button>
            <button class="lienEC" onclick="openPage('comptes', this, '#f1f1f1')"style="width: 18%" >vos comptes</button>
            <button class="lienEC" onclick="openPage('operations', this, '#f1f1f1')" style="width: 18%">vos opérations</button>
            <button class="lienEC" onclick="openPage('beneficiaires', this, '#f1f1f1')" style="width: 18%" >vos bénéficiaires</button>
            <div class="lienEC" style="width: 14%"> </div>
        </div>

        <div id="informations" class="item_EC">
            <form method="post" action="modif_Infos.php" >
                <div class="container">
                    <h1 style="font-variant: small-caps; margin-bottom: 0px;">vos informations</h1>
                    <p style="font-size: 15px">Vous pouvez modifier vos informations. N'oubliez pas de valider.</p>
                    <hr>
                    <button type="submit" class="bouton_Valider"><img src="pencil.png" style="width:25px; margin-right:20px;">Modifier</button>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><label for="civilite">civilité</label> :</td>
                            <td id="civilite">
                                <label>
                                    <?php if ($client['civilite_Client']=='F') 
                                        {echo ("mme");
                                    } else {
                                        echo ("m.");
                                    }  
                                    ?>
                                </label>
                            </td> 
                        </tr>
                        <tr>   
                            <td><label for="nom">nom</label> :</td>
                            <td id="infos"><?php echo ($client['nom_Client']) ?></td>   
                        </tr>
                        <tr>
                            <td><label for="prenom">prénom</label> :</td>
                            <td id="infos"><?php echo ($client['prenom_Client']) ?></td>
                        </tr>
                        <tr>
                            <td><label for="date_Naissance">date de naissance</label> :</td>
                            <td id="infos"><?php echo ($client['date_Naissance_Client']) ?></td>
                        </tr>
                        <tr>
                            <td><label for="pays">nationalité :</label></td>
                            <td id="infos"><?php echo($client['pays_Client']) ?></td>
                        </tr>
                        <tr>
                            <td><label>adresse postale</label> :</td>
                            <td>
                                <label for="numero_Voie">n° de voie</label> :
                                <div id="infos"><?php echo ($client['num_Voie_Client'])?></div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <label for="voie">voie</label> :
                                <div id="infos"><?php echo ($client['voie_Client']) ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> 
                                <label for="code_Postal">code postal</label> :
                                <div id="infos"><?php echo ($client['code_Postal_Client'])?> </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <label for="ville">ville</label> :
                                <div id="infos"><?php echo ($client['ville_Client'])?></div>
                            </td>
                        </tr>

                        </tr>
                        <tr>
                            <td><label for="email">adresse mail</label> :</td>
                            <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" value="<?php echo ($client['adresse_Mail_Client']) ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="telephone">téléphone</label> :</td>
                            <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" value="<?php echo ($client['telephone_Client']) ?>" /></td>
                        </tr>
                    </table><br />
                </form>
                <br /><hr>
                <h1 style="font-variant: small-caps; margin-bottom: 0px;">votre agence</h1>
                <p>Vous trouverez ci-dessous les informations sur votre agence de rattachement.</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>   
                        <td><label for="nom">nom de l'agence</label> :</td>
                        <td id="infos"><?php echo ("BankUP ".$agence['ville_Agence']) ?></td>   
                    </tr>
                    <tr>
                        <td><label>adresse postale de l'agence</label> :</td>
                        <td>
                            <label for="numero_Voie"></label>
                            <div id="infos"><?php echo ($agence['num_Voie_Agence']." ".$agence['voie_Agence'])?></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="voie"></label>
                            <div id="infos"><?php echo ($agence['code_Postal_Agence']." ".$agence['ville_Agence']) ?></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="comptes" class="item_EC">
            <h1 style="font-variant: small-caps; margin-bottom: 0px;">vos comptes</h1>
            <p style="font-size: 15px">Vous pouvez consulter ci-dessous vos comptes. Vous pouvez également ouvrir un compte en cliquant sur le bouton situé en bas de la page.</p>
            <hr>
            <button type="submit" class="bouton_Valider" onclick="location.href='ouvrir_Compte.php'"><img src="add-plus-button.png" style="width:25px; margin-right:20px;">Ouvrir un compte</button><br /><br />
            <?php 
                $i = 1;
                while($compte = $resultat->fetch_row())  {

                    
                    /*echo("<table><tr><td><table><tr><td><p><h3>n°compte</p></td><td>".$i."</td></tr></table></td><td><button type="submit" class="bouton_Valider" onclick="toggle_div(this,'id-du-div');"><img src="add-plus-button.png" style="width:25px; margin-right:20px;"></button></td></tr></table>
                    <div id="id-du-div" style="display:none;"><table><tr><td><p><h3>libellé du compte</p></td><td>".$compte[4]."</td></tr><tr><td><p><h3>date ouverture</p></td><td>".$compte[1]."</td></tr><tr><td><p><h3>solde</p></td><td>".$compte[3]."</td></tr><tr><td><p><h3>iban</p></td><td>".$compte[5]."</td></tr><tr><td><p><h3>bic</p></td><td>".$compte[6]."</td></tr><tr><td><p><h3>autorisation découvert</p></td><td>".$compte[7]."</td></tr></table>
                    </div>
                    
                    <script type="text/javascript">
                    function toggle_div(bouton, id) { // On déclare la fonction toggle_div qui prend en param le bouton et un id
                    var div = document.getElementById(id); // On récupère le div ciblé grâce à l'id
                    if(div.style.display=="none") { // Si le div est masqué...
                        div.style.display = "block"; // ... on l'affiche...
                        bouton.innerHTML = "-"; // ... et on change le contenu du bouton.
                    } else { // S'il est visible...
                        div.style.display = "none"; // ... on le masque...
                        bouton.innerHTML = "+"; // ... et on change le contenu du bouton.
                    }
                    }
                    </script>";)*/

                    echo ("<table><tr><td><h3>n°compte</td><td>".$i."</td></tr><tr><td><h3>libellé du compte</td><td>".$compte[4]."</td></tr><tr><td><h3>date ouverture</td><td>".$compte[1]."</td></tr><tr><td><h3>solde</td><td>".$compte[3]."</td></tr><tr><td><h3>iban</td><td>".$compte[5]."</td></tr><tr><td><h3>bic</td><td>".$compte[6]."</td></tr><tr><td><h3>autorisation découvert</td><td>".$compte[7]."</td></tr></table>");
                    //Gérer les CB et chéquiers//
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
                        $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$compte[0]." AND validite_Chequier = 1");
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
                    $i = $i + 1;
                }
            ?>
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
                            <td><input type="text" name="libelle_Beneficiaire" id="libelle_Beneficiaire" size="30" minlength="2" maxlength="30" placeholder="Entrez le libellé du bénéficiaire" required /></td>
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
                echo("<tr><td>N°</td><td>Libellé du bénéficiaire</td><td>Statut</td><td>Effectuer virement</td><td>Supprimer</td></tr>");
                while($beneficiaire = $resultat3->fetch_row()) {
                    if ($beneficiaire[3]==1) {
                        echo("<tr><td>".$i."</td><td>".$beneficiaire[2]."</td><td>Actif</td>"); ?>
                        <td><form method="post" action="virement.php">
                            <button name="id_Beneficiaire" type="submit" class="bouton_Virement" value="<?php echo ($beneficiaire[0]) ?>">Faire virement</button><br /><br />
                        </form></td>
                        <td><form method="post" action="suppression_Beneficiaire.php">
                            <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>">Supprimer</button><br /><br />
                        </form></td></tr>
                    <?php } else {
                        echo("<tr><td>".$i."</td><td>".$beneficiaire[2]."</td><td>En attente</td><td></td>"); ?>
                        <td><form method="post" action="suppression_Beneficiaire.php">
                            <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>">Supprimer</button><br /><br />
                        </form></td></tr>
                    <?php }
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