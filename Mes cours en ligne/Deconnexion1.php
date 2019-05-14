<?php
session_start();
       
       $Connexion= new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
       $requete_suppression = $Connexion ->prepare("DELETE FROM UtilisateurEnLigne WHERE Id_Utilisateur = ?");
       $requete_suppression ->execute(array($_SESSION['Id_Utilisateur']));
$_SESSION[] = array();
session_destroy();

header('Location:Index.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
    </body>
</html>