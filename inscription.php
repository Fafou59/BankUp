<?php
    include('menu.php');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
    </head>

    <header>
        
    </header>

    <body>
        <form method="post" action="creation_Profil.php" style="border:1px solid #ccc">
            <div class="container">
                <h1>Création de votre profil</h1>
                <p>Merci de compléter les informations ci-dessous.</p>
                <hr>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><label for="civilite">Civilité*</label> :</td>
                        <td id="civilite">
                            <input type="radio" name="civilite" value="madame" id="madame"  />
                            <label for="madame">Mme</label>
                            <input type="radio" name="civilite" value="monsieur" id="monsieur"  />
                            <label for="monsieur">M.</label>
                        </td> 
                    </tr>
                    <tr>   
                        <td><label for="nom">Nom</label> :</td>
                        <td><input type="text" name="nom" id="nom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre nom" /></td>   
                    </tr>
                    <tr>
                        <td><label for="prenom">Prénom</label> :</td>
                        <td><input type="text" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" /></td>
                    </tr>
                    <tr>
                        <td><label for="date_Naissance">Date de naissance</label> :</td>
                        <td><input type="date" name="date_Naissance" id="date_Naissance" /></td>
                    </tr>
                    <tr>
                        <td><label for="pays">Choisissez un Pays :</label></td>
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
                            <input type="text" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>    
                            <label for="code_Postal">Code postal</label> :
                            <input type="text" name="code_Postal" id="code_Postal" size="5" minlength="5" maxlength="5" placeholder="Entrez votre code postal" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="ville">Ville</label> :
                            <input type="text" name="ville" id="ville" size="10" minlength="5" maxlength="25" placeholder="Entrez votre ville" />
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td><label for="email">Adresse mail</label> :</td>
                        <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" /></td>
                    </tr>
                    <tr>
                        <td><label for="telephone">Téléphone</label> :</td>
                        <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" /></td>
                    </tr>
                    <tr>
                        <td><label for="mdp">Mot de passe</label> :</td>
                        <td><input type="password" name="mdp" id="mdp" size="30" minlength="" maxlength="30" placeholder="Entrez votre mot de passe" /></td>
                    </tr>
                    <tr>
                        <td><label for="confirmation_Mdp">Confirmation</label> :</td>
                        <td><input type="password" name="confirmation_Mdp" id="confirmation_Mdp" size="30" minlength="5" maxlength="30" placeholder="Entrez à nouveau votre mot de passe"  /></td>
                    </tr>
                </table>

            <p>En créant votre profil, vous acceptez nos <a href="#" style="color:dodgerblue">Conditions Générales d'utilisation</a>.</p>

            <div class="bouton_Form">
                <button type="button" class="bouton_Annuler" >Retour</button>
                <button type="submit" class="bouton_Valider">Valider</button>
            </div>
        </div>
        </form>

    </body>


    <footer>
        <div></div>
    </footer>

</html>
