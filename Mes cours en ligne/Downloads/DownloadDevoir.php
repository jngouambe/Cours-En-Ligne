<?php
$Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
     
    
  if(isset($_GET['chemin']))
  {
      $Chemin_Fichier = $_GET['chemin'];
      $requete_devoir = $Connexion -> query("SELECT * FROM Devoir_Etudiant WHERE Chemin_Fichier = '$Chemin_Fichier'");
      
      header('Content-Type : application / octet-stream');
      header('Content-Disposition : attachement; filename = "'.basename($Chemin_Fichier).'" ');
      header('Content-Length :'.filesize($Chemin_Fichier));
      readfile($Chemin_Fichier);
  }
?>
