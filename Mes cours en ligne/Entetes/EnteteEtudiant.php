<?php
session_start();
   // if(isset($_POST['connexion']))
   // {
        $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
   
     if(mysqli_errno())
       {
          echo"Echec de connexion à la base de données:".mysqli_error();
       } 
         

        
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="Css/Accueil.css">
    </head>
    <body>
        <div id="banner1">
            <img src="Images/grif.jpg" alt="ecole"><em> Mes cours en ligne</em>
            <div id="connexion">
            <a href="Deconnexion1.php"><img id="exit" src="Images/exit.jpg" alt="exit"></a><label for="exit">Deconnexion</label> 
            </div> 
        </div>
        <div id="nav-bar1">
            <ul id="ul_enteteetudiant">
                <li><a  href="Index.php" id="Accueil">Accueil</a></li>
                <li><a  href="FenetrePrincipale.php?id=<?php echo $_SESSION['Id_Utilisateur'];?>">Mon profil</a></li>
                <li><a  href="MesCours.php">Mes cours</a></li>
                <li><a  href="UploadEtudiant.php">reception cours et envoi travaux</a></li>
                <li><a  href="EnregistrementCours.php">Enregistrement de cours</a></li>
                
            </ul>
        </div>
                <div id="banner2"><img src="Images/cours.jpg" alt="cours"></div>

    </body>
</html>