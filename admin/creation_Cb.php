<?php
    $num_Cb = trim(rand(10000000,99999999)).trim(rand(10000000,99999999));
    $cryptogramme = rand(100,999);

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
    // Réaliser requête
    $sql = "INSERT INTO cb (id_Compte_Rattache, num_Cb, cryptogramme_Cb, date_Expiration_Cb)
    VALUES ('".$_POST['id_Compte']."', '".$num_Cb."', '".$cryptogramme."', DATE_ADD(NOW(),INTERVAL 5 YEAR))";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: espace_Client.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>