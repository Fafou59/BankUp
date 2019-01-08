<?php
    if ($_SESSION['admin_Connecte']==1) {
      header('Location: espace_Admin.php');
    } else {
      header('Location: connexion_Admin.php');
    }
?>