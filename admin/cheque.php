<?php
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

    // Opérations sur compte si chèque validé
    if (isset($_POST['id_Cheque_Ajout'])) {
        // Réaliser requête chèques
        $requete = $conn->prepare("SELECT operation.* FROM operation WHERE operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'");
        $requete->execute();
        $resultat = $requete->get_result();
        $cheque = $resultat->fetch_assoc();

        $montant = $cheque['montant_Operation'];

        $sql0 = "UPDATE compte SET solde_Compte = solde_Compte - ".$montant." WHERE compte.id_Compte = '".$cheque['id_Emetteur_Operation']."'";
        $sql1 = "UPDATE compte SET solde_Compte = solde_Compte + ".$montant." WHERE compte.id_Compte = '".$cheque['id_Recepteur_Operation']."'";
        $sql2 = "UPDATE operation SET operation.validite_Operation = 1 WHERE operation.id_Operation = '".$_POST['id_Cheque_Ajout']."'";
        if ($conn->query($sql0) === TRUE AND $conn->query($sql1) === TRUE AND $conn->query($sql2)) {
            header('Location: espace_Admin.php');
        } else {
            echo "Error: " . $sql0 . "<br>" . $conn->error. "<br>";
            echo "Error: " . $sql1 . "<br>" . $conn->error. "<br>";
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    } else { // Suppression de l'opération si chèque refusé
        if (isset($_POST['id_Cheque_Suppression'])) {
            $sql = "DELETE FROM operation WHERE operation.id_Operation = '".$_POST['id_Cheque_Suppression']."'";
            if ($conn->query($sql) === TRUE) { 
                header('Location: espace_Admin.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else { // Pas de donnée, retour sur Espace Admin
            header('Location: espace_Admin.php');
        }
    }
    $conn->close();

?>