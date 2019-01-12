<?php
    include('menu.php');
    $libelle_Beneficiaire = $_POST['libelle_Beneficiaire'];
    $iban = $_POST['iban'];
    $id_Emetteur = $_SESSION['id'];

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

    $requete = $conn->prepare("SELECT compte.* FROM compte WHERE '".$iban."' = compte.iban_Compte");
    $requete->execute();
    $resultat = $requete->get_result();
    $compte = $resultat->fetch_assoc();

    if (isset($compte)) {
        if ($compte['id_Detenteur_Compte']==$id_Emetteur) {
            header('Location: espace_Client.php');
        } else {
            $requete = $conn->prepare("SELECT beneficiaire.* FROM beneficiaire, compte WHERE '".$id_Emetteur."' = beneficiaire.id_Client_Emetteur AND '".$compte['id_Compte']."' = beneficiaire.id_Compte_Beneficiaire");
            $requete->execute();
            $resultat = $requete->get_result();
            $beneficiaire = $resultat->fetch_assoc();

            if (($beneficiaire['id_Compte_Beneficiaire']==$compte['id_Compte']) AND ($beneficiaire['id_Client_Emetteur']==$id_Emetteur)) {
                header('Location: espace_Client.php');
            } else {
                // Réaliser requête
                $sql = "INSERT INTO beneficiaire (id_Compte_Beneficiaire, id_Client_Emetteur, libelle_Beneficiaire, validite_Beneficiaire)
                VALUES ('".$compte['id_Compte']."', '".$id_Emetteur."', '".$libelle_Beneficiaire."', 0)";
                
                if ($conn->query($sql) === TRUE) {
                    header('Location: espace_Client.php');
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        //messsage compte non trouvé
        header('Location: espace_Client.php');
    }
?>
