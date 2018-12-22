<?php
    include('menu.php');
?>

<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="code.css" />
        <title>BankUP - Informations modifiées</title>
    </head>

    <body>
        <?php
        if (($origine == "http://localhost/site/inscription.php") OR ($origine == "http://localhost/site/inscription.php#")) {
            if ((!isset($_POST['civilite'])) OR (!isset($_POST["mdp"])) OR (!isset($_POST['telephone'])) OR (!isset($_POST['email'])) OR (!isset($_POST['ville'])) OR (!isset($_POST['code_Postal'])) OR (!isset($_POST['voie'])) OR (!isset($_POST['numero_Voie'])) OR (!isset($_POST['nom'])) OR (!isset($_POST['prenom'])) OR (!isset($_POST['date_Naissance'])) OR (!isset($_POST['pays']))) {
                //header('Location: inscription.php');
            }
            else {
                if ($_POST['civilite'] == "monsieur") {
                    $civilite = "M";
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

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "test";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "UPDATE test (nom, prenom)
                VALUES ('".$nom."', '".$prenom."')";

                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Vos informations ont bien été modifiées.</h1>
                        <p>Un mail vous a été envoyé à l'adresse renseignée.</p>
                        <hr>
                        <div class="bouton_Form">
                            <button type="button" onclick="location.href='espace_Client.php'" class="bouton_Annuler">Retour</button>
                        </div>
                    </div> <?php
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            $conn->close();
            }
        } else {
            //header('Location: inscription.php');
        }
        ?> 

<!-- A supprimer, uniquement pour afficher du contenu en test -->
        <div id="contenu">
            <h1>Vos informations ont bien été modifiées.</h1>
            <p>Un mail vous a été envoyé à l'adresse renseignée.</p>
            <hr>
            <div class="bouton_Form">
                <button type="button" onclick="location.href='espace_Client.php'" class="bouton_Valider">Retour</button>
            </div>
        </div>
        
    </body>


    <footer>
        
    </footer>

</html>





