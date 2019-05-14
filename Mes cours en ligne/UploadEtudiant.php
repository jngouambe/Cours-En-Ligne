<?php
session_start();    
     $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');

     $id_Utilisateur = $_SESSION['Id_Utilisateur'];
     //Allons chercherher le code de programme de l'utilisateur en cours
     $requeteCode_Programme = $Connexion -> prepare("SELECT * FROM tbl_Utilisateurs WHERE Id_Utilisateur = ?");
     $requeteCode_Programme -> execute(array($id_Utilisateur));
     $ok = $requeteCode_Programme -> fetch();
     $Code_programme = $ok['Code_Programme'];
     //requete pour chercher le code cours auquel est inscrit l'étudiant
     //$requete_code = $Connexion -> prepare("SELECT * FROM tbl_Utilisateurs_Cours Id_Etudiant =? ");
    // $requete_code ->execute(array($_SESSION['Id_Utilisateur']));
    // $resulat = $requete_code -> fetch();


     
     //$Code_Cours = $resulat['Code_Cours'];

    $requete_devoir = $Connexion -> prepare("SELECT * FROM Cours_Etudiant WHERE Code_Programme = ?");
    $requete_devoir -> execute(array($Code_programme));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="Css/Accueil.css">
        
    </head>
    <body>
        <?php
            include('Entetes/EnteteEtudiant.php');
        ?>
        <div id="corps">
            
        <?php
            include('Upload/Upload_devoir.php');
        ?>
       
     <table id="tblCours_telecharger1">
         <tr>
             <th colspan="2">Réception de cours</th>
         </tr>
         <tr>
             <th>Nom du document</th>
             <th>Télécharger</th>
         </tr>
         <?php
            while($resultat = $requete_devoir -> fetch())
            {
                $Id_Fichier = $resultat['Id_Fichier'];
                $Nom_Fichier = $resultat['Nom_Fichier'];
                $Chemin_Fichier = $resultat['Chemin_Fichier'];
                echo"<tr>";
                echo"<td>".$Nom_Fichier."</td>";
                echo"<td>";
                echo"<a href=\"Downloads/DownloadCours.php?chemin=$Chemin_Fichier\">
                <img src=\"Images/download.jpg\" alt=\"download\" id=\"download\"></a>";
                echo"</td>";
                echo"</tr>";
            }
        ?>
         </table>
           </div>
        <?php
            include('Pied_page.php');
        ?>
    </body>
</html>
