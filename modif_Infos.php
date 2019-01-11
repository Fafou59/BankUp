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
            if ((!isset($_POST['telephone'])) OR (!isset($_POST['email']))) {
                header('Location: espace_Client.php');
            } else {
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];

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

                $sql = "UPDATE client SET adresse_Mail_Client = '".$email."', telephone_Client = '".$telephone."' WHERE client.id_Client = '".$_SESSION['id']."'";

                if ($conn->query($sql) === TRUE) { ?>
                    <div class="container">
                        <h1>Votre profil a bien été modifié.</h1>
                        <button type="button" class="bouton_Annuler" onclick="location.href='espace_Client.php'">Aller sur Espace Client</button>
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





