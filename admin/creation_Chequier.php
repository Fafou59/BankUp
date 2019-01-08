<?php

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
    // Recherche d'un chéquier rattaché
    $requete = $conn->prepare("SELECT chequier.* FROM chequier WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte']);
    $requete->execute();
    $resultat2 = $requete->get_result();
    $chequier = $resultat2->fetch_assoc();

    if (isset($chequier)) {
        $sql1 = "UPDATE chequier SET validite_Chequier = 0 WHERE chequier.id_Compte_Rattache = ".$_POST['id_Compte'];
        $sql2 = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier) VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
        if ($conn->query($sql1) === TRUE) {
            if ($conn->query($sql2) === TRUE) {
                header('Location: mirroring_Admin.php');
            } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }
    } else {
        $sql = "INSERT INTO chequier (id_Compte_Rattache, date_Emission_Chequier, validite_Chequier)
        VALUES ('".$_POST['id_Compte']."', NOW(), 1)";
        if ($conn->query($sql) === TRUE) {
            header('Location: mirroring_Admin.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


?>
