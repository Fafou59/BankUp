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
            if ((!isset($_POST['civilite'])) OR (!isset($_POST['telephone'])) OR (!isset($_POST['email'])) OR (!isset($_POST['ville'])) OR (!isset($_POST['code_Postal'])) OR (!isset($_POST['voie'])) OR (!isset($_POST['numero_Voie'])) OR (!isset($_POST['nom'])) OR (!isset($_POST['prenom'])) OR (!isset($_POST['date_Naissance'])) OR (!isset($_POST['pays']))) {
                header('Location: espace_Client.php');
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

                $sql = "UPDATE client SET civilite_Client = '".$civilite."', nom_Client = '".$nom."', prenom_Client = '".$prenom."', date_Naissance_Client = '".$date_Naissance."', adresse_Mail_Client = '".$email."', telephone_Client = '".$telephone."', num_Voie_Client = '".$numero_Voie."', voie_Client = '".$voie."', code_Postal_Client = '".$code_Postal."', ville_Client = '".$ville."', agence_Client = '".$agence."', pays_Client = '".$pays."'";

                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Votre profil a bien été modifié.</h1>
                        <p>Un mail vous a été envoyé à l'adresse renseignée.</p>
                        <hr>
                    </div> <?php
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





