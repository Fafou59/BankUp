<?php
//Démarrage de la session
    session_start();
    $_SESSION['connexion']='';
    include('menu.php');
    if (isset($_SERVER["HTTP_REFERER"])) {
        $origine = $_SERVER["HTTP_REFERER"];
    }
    else {
        $origine = "";
    }
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
                <h1>Création de votre compte</h1>
                <p>Merci de compléter les informations ci-dessous pour que nous puissons ouvrir votre compte.</p>
                <hr>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><label for="type_Compte">Type de compte*</label> :</td>
                        <td id="type_Compte">
                            <input type="radio" name="type_Compte" value="epargne" id="epargne"  />
                            <label for="madame">Compte Epargne</label>
                            <input type="radio" name="type_Compte" value="courant" id="courant"  />
                            <label for="monsieur">Compte Courant</label>
                        </td> 
                    </tr>
                    <tr>   
                        <td><label for="nom">Nom</label> :</td>
                        <td><input type="text" name="nom" id="nom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre nom" autofocus  /></td>   
                    </tr>
                    <tr>
                        <td><label for="prenom">Prénom</label> :</td>
                        <td><input type="text" name="prenom" id="prenom" size="20" minlength="2" maxlength="25" placeholder="Entrez votre prénom" autofocus  /></td>
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
                            <input type="text" name="numero_Voie" id="numero_Voie" size="5" minlength="0" maxlength="5" placeholder="Entrez votre n° voie" autofocus  />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="voie">Voie</label> :
                            <input type="text" name="voie" id="voie" size="75" minlength="" maxlength="75" placeholder="Entrez votre voie" autofocus  />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>    
                            <label for="code_Postal">Code postal</label> :
                            <input type="text" name="code_Postal" id="code_Postal" size="5" minlength="5" maxlength="5" placeholder="Entrez votre code postal" autofocus  />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="ville">Ville</label> :
                            <input type="text" name="ville" id="ville" size="10" minlength="5" maxlength="25" placeholder="Entrez votre ville" autofocus  />
                        </td>
                    </tr>

                    </tr>
                    <tr>
                        <td><label for="email">Adresse mail</label> :</td>
                        <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez votre adresse mail" autofocus  /></td>
                    </tr>
                    <tr>
                        <td><label for="email">Confirmation</label> :</td>
                        <td><input type="email" name="email" id="email" size="50" minlength="5" maxlength="70" placeholder="Entrez à nouveau votre adresse mail" autofocus  /></td>
                    </tr>
                    <tr>
                        <td><label for="telephone">Téléphone</label> :</td>
                        <td><input type="text" name="telephone" id="telephone" size="10" minlength="10" maxlength="10" placeholder="Entrez votre numéro de téléphone" autofocus  /></td>
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
                <button type="button" class="bouton_Annuler">Annuler</button>
                <button type="submit" class="bouton_Valider">Valider</button>
            </div>
        </div>
        </form>

    </body>


    <footer>
        <div></div>
    </footer>

</html>
