<?php
    // Ajout du menu
    include('menu.php');

    // Vérifier si client connecté, sinon renvoie vers connexion
    if (!isset($_SESSION['id'])) {
        header("Location: connexion.php");
    }
    
    include('connexion_bdd.php');
    // Réaliser requête client & agence rattaché à l'id client
    $requete = $conn->prepare("SELECT client.*, agence.* FROM client, agence WHERE client.id_Client = '".$_SESSION['id']."' AND agence.id_Agence = client.agence_Client");
    $requete->execute();
    $resultat = $requete->get_result();
    $client = $resultat->fetch_assoc();

    // Réaliser requête comptes rattachés au client
    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$_SESSION['id']."' = compte.id_Detenteur_Compte");
    $requete->execute();
    $resultat = $requete->get_result();

    // Réaliser requête bénéficiaires rattachés au client
    $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire WHERE beneficiaire.id_Client_Emetteur = '".$_SESSION['id']."'");
    $requete->execute();
    $beneficiaires = $requete->get_result();

    // Réaliser requête opérations débitrice du client
    $requete = $conn->prepare("SELECT operation.*, compte.* FROM operation, compte WHERE ((id_Compte = id_Emetteur_Operation) AND (operation.id_Emetteur_Operation IN (SELECT compte.id_Compte FROM compte WHERE compte.id_Detenteur_Compte = '".$_SESSION['id']."')))");
    $requete->execute();
    $operations_emetteur = $requete->get_result();

    // Réaliser requête opérations créditrice du client
    $requete = $conn->prepare("SELECT operation.*, compte.* FROM operation, compte WHERE((id_Compte = id_Recepteur_Operation) AND (operation.id_Recepteur_Operation IN (SELECT compte.id_Compte FROM compte WHERE compte.id_Detenteur_Compte = '".$_SESSION['id']."')))");
    $requete->execute();
    $operations_recepteur = $requete->get_result();
    
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <script type="text/javascript" src="menu_EC.jsx"></script>
        <script type="text/javascript" src="tri.jsx"></script>
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
                        <td id="infos"><?php echo ("BankUP ".$client['ville_Agence']) ?></td>   
                    </tr>
                    <tr>
                        <td><label>adresse postale de l'agence</label> :</td>
                        <td>
                            <label for="numero_Voie"></label>
                            <div id="infos"><?php echo ($client['num_Voie_Agence']." ".$client['voie_Agence'])?></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="voie"></label>
                            <div id="infos"><?php echo ($client['code_Postal_Agence']." ".$client['ville_Agence']) ?></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

                <div id="comptes" class="item_EC">
            <h1 style="font-variant: small-caps;">vos comptes</h1>
            <p style="font-size: 15px">Vous pouvez consulter ci-dessous vos comptes. Vous pouvez également ouvrir un compte en cliquant sur le bouton situé en bas de la page.</p>
            <hr>
            <button type="submit" class="bouton_Ouvrir" onclick="location.href='ouvrir_Compte.php'"><img src="add-plus-button.png" style="width:25px; margin-right:20px;">Ouvrir un compte</button><br /><br />
            <br>
            <hr>
            <?php 
                $i = 1;
                while($compte = $resultat->fetch_row())  {
                    ?>
                    <table class="onglet_compte" style="background-color: #E80969; width:100%;"><tr><td style="color: white; padding-left:5px; padding-right:5px; width: 8%;"><h3>COMPTE</h3></td><td style="color: white; width:30%"><h3><?php echo $compte[4]?></h3></td><td style="color: white; padding-right:5px; width: 45%;text-align:right;font-weight: normal; font-variant: small-caps;">solde</td><td style="color: white;text-align:left;font-weight: normal; font-variant: small-caps; padding-left:5px"><?php echo $compte[3]?> €</td><td style="width:10%"><button type="submit" class="bouton_Compte" onclick="toggle_div(this,<?php echo $i;?>);"><img src="angle-arrow-down.png" style="width:25px"></button></td></tr></table>
                    
                    <div id=<?php echo $i;?> style="display:none;"><table style="margin-left:30px;"><tr><td><p><h3>type de compte</p></td><td style="text-transform: capitalize; padding-left:40px;"><?php echo $compte[2]?></td></tr><tr><td><p><h3>date ouverture</p></td><td style="padding-left:40px;"><?php echo $compte[1]?></td></tr><tr><td><p><h3>iban</p></td><td style="padding-left:40px;"><?php echo $compte[5]?></td></tr><tr><td><p><h3>bic</p></td><td style="padding-left:40px;"><?php echo $compte[6]?></td></tr><tr><td><p><h3>autorisation découvert</p></td><td style="padding-left:40px;"><?php echo $compte[7]?> €</td></tr></table><?php

                    ?>
                    
                    <?php
                    if ($compte[2]=="courant") {
                
                        ?> <table>
                        <?php
                        //CB
                        $requete = $conn->prepare("SELECT cb.* FROM cb WHERE cb.id_Compte_Rattache = ".$compte[0]);
                        $requete->execute();
                        $resultat2 = $requete->get_result();
                        $cb = $resultat2->fetch_assoc();
                        $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 5 digit int
                        ?><tr>
                        <?php
                        if ($cb['id_Compte_Rattache']==$compte[0]) {
                            ?> <table class="onglet_Paiement"><tr><td style="color: white; padding-left:5px; padding-right:5px; width: 300px;"><h3>carte associée</h3></td><td><button type="submit" class="bouton_Mini_Compte" style="background-color: #555;" onclick="toggle_div(this,<?php echo $random_number;?>);"><img src="angle-arrow-down.png" style="width:25px; float:right;"></button></td></tr></table>
                            <div id="<?php echo $random_number;?>" style="display:none;"><table style="margin-top:0px; margin-left: 30px;"><tr><td><h3>numéro de carte</td><td style="text-transform: capitalize; padding-left:40px;"><?php echo $cb['num_Cb']?></td></tr><tr><td><p><h3>cryptogramme</p></td><td style="padding-left:40px;"><?php echo $cb['cryptogramme_Cb']?></td></tr><tr><td><p><h3>date d'expiration</p></td><td style="padding-left:40px;"><?php echo $cb['date_Expiration_Cb'] ?></td></tr></table></div>
                        <?php } else {
                            ?> <table>
                            <tr><p style="padding-left:30px; padding-bottom:10px;">Vous n'avez pas encore de carte.</p>
                            </tr><tr><form method="post" action="creation_Cb.php">
                                <button name="id_Compte" type="submit" class="bouton_Ouvrir" style="padding-left: 15px;margin-left: 30px; text-align:left;" value="<?php echo ($compte[0]) ?>"><img src="add-plus-button.png" style="width:25px; margin-right:20px;">Nouvelle carte</button><br /><br />
                            </form></tr></table>
                        <?php }
                        ?></tr>
                        <?php

                        //Chéquier
                        $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$compte[0]." AND validite_Chequier = 1");
                        $requete->execute();
                        $resultat2 = $requete->get_result();
                        $chequier = $resultat2->fetch_assoc();
                        $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 5 digit int
                        ?><tr>
                        <?php    
                        if ($chequier['id_Compte_Rattache']==$compte[0]) {
                            ?><table class="onglet_Paiement"><tr><td style="color: white; padding-left:5px; padding-right:5px; width: 300px;"><h3>chéquier associé</h3></td><td><button type="submit" class="bouton_Mini_Compte" onclick="toggle_div(this,<?php echo $random_number ;?>)"><img src="angle-arrow-down.png" style="width:25px; float:right;"></button></td></tr></table>
                            <div id= <?php echo $random_number;?> style="display:none;">
                            <table style="margin-top:0px; margin-bottom:5px; margin-left: 30px;"><tr><td><p><h3>date d'émission</p></td><td style="text-transform: capitalize; padding-left:40px;"><?php echo $chequier['date_Emission_Chequier']?></td></tr></table>
                            <form method="post" action="creation_Chequier.php" style="height:80px">
                                <button name="id_Compte" type="submit" class="bouton_Ouvrir" style="padding-left: 15px; margin-left: 30px;text-align:left;" value="<?php echo ($compte[0]) ?>"><img src="add-plus-button.png" style="width:25px; margin-right:20px;">nouveau chéquier</button><br /><br />
                            </form></div>
                        <?php } else {
                            ?><table style="padding-top:25px;">
                            <tr><p style="padding-left:30px; padding-bottom:10px;">Vous n'avez pas encore de chéquier.</p>
                            </tr><tr><form method="post" action="creation_Chequier.php" style="height:80px">
                                <button name="id_Compte" type="submit" class="bouton_Ouvrir" style="padding-left: 15px;margin-left: 30px; text-align:left;" value="<?php echo ($compte[0]) ?>"><img src="add-plus-button.png" style="width:25px; margin-right:20px;">nouveau chéquier</button><br /><br />
                            </form></tr></table>
                        <?php }
                        ?> </tr></table>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                    $i = $i + 1;
                } 
                    ?> 
                    <script type="text/javascript">
                            function toggle_div(bouton, id) { // On déclare la fonction toggle_div qui prend en param le bouton et un id
                            var div = document.getElementById(id); // On récupère le div ciblé grâce à l'id
                            if(div.style.display=="none") { // Si le div est masqué...
                                div.style.display = "block"; // ... on l'affiche...
                                bouton.innerHTML = "<img src=\"up-arrow.png\" width=\"25px\" margin-right=\"20px\">"; // ... et on change le contenu du bouton.
                            } else { // S'il est visible...
                                div.style.display = "none"; // ... on le masque...
                                bouton.innerHTML = "<img src=\"angle-arrow-down.png\" width=\"25px\" margin-right=\"20px\">"; // ... et on change le contenu du bouton.
                            }
                            }
                            
                    </script>
        </div>

        <div id="operations" class="item_EC">
            <h1 style="font-variant: small-caps; margin-bottom: 0px;">vos opérations</h1>
            <p style="font-size: 15px">Retrouvez la liste de vos opérations passées. Vous pouvez également faire un virement un cliquant sur le bouton correspondant.</p>
            <hr>
            <button type="submit" class="bouton_Ouvrir" onclick="location.href='virement.php'"><img src="add-plus-button.png" style="width:25px; margin-right:20px;">Faire un virement</button><br><br>
            <br>
            <hr>
                    <table id='liste_Operations' width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th onclick="sortTable(0)">Date</th>
                    <th onclick="sortTable(1)">Type opération</th>
                    <th onclick="sortTable(2)">Compte</th>
                    <th onclick="sortTable(3)">Montant</th>
                    <th onclick="sortTable(4)">Statut</th>
                </tr>
            <?php while($operation = $operations_emetteur->fetch_row()) { ?>
                <tr>
                    <td><?php echo($operation[1]) ?></td>
                    <td><?php echo($operation[4]) ?></td>
                    <td><?php echo($operation[13]) ?></td>
                    <td style="font-weight:bold"><?php echo('<font color="red">-'.$operation[5].'€</font>') ?></td>
                    <td><?php if ($operation[8]==1) {echo('Effectué');} else {echo('En attente de validation');}?>
                </tr>
            <?php }
            while($operation = $operations_recepteur->fetch_row()) { ?>
                <tr>
                    <td><?php echo($operation[1]) ?></td>
                    <td><?php echo($operation[4]) ?></td>
                    <td><?php echo($operation[13]) ?></td>
                    <td style="font-weight:bold"><?php echo('<font color="green">+'.$operation[5].'€</font>') ?></td>
                    <td><?php if ($operation[8]==1) {echo('Effectué');} else {echo('En attente de validation');}?>
                </tr>
            <?php } ?>
            </table>
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
                while($beneficiaire = $beneficiaires->fetch_row()) {
                    if ($beneficiaire[4]==1) {
                        echo("<tr><td>".$i."</td><td>".$beneficiaire[3]."</td><td>Actif</td>"); ?>
                        <td><form method="post" action="virement.php">
                            <button name="id_Beneficiaire" type="submit" class="bouton_Virement" value="<?php echo ($beneficiaire[0]) ?>">Faire virement</button><br /><br />
                        </form></td>
                        <td><form method="post" action="suppression_Beneficiaire.php">
                            <button name="id_Beneficiaire" type="submit" class="bouton_Suppression" value="<?php echo ($beneficiaire[0]) ?>">Supprimer</button><br /><br />
                        </form></td></tr>
                    <?php } else {
                        echo("<tr><td>".$i."</td><td>".$beneficiaire[3]."</td><td>En attente</td><td></td>"); ?>
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

    <script>
        document.addEventListener("load", sortTable(0));
        document.addEventListener("load", sortTable(0));
        document.getElementById("defaultOpen").click();
    </script>

</html>
