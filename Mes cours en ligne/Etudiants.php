<?php
     $Connexion= new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="Css/Utilisateurs.css">
    </head>
    <body>
        <?php
            include('Entetes/EnteteEtudiant.php');
        ?>
        <div id="div-EnteteUtilisateur">
        <form action="" method="post" id="Profil">
            <h1><?php echo $requete_info['Nom'];?></h1>
           <table id="tableProfil">
               <tr>
                <th> Photo profil : </th>
                <td><img src="Images/willy.jpg" alt="willy" id="willy"></td>
            </tr>
            <tr>
                <th> Nom d'utilisateur : </th>
                <td><?php echo $requete_info['Nom_Utilisateur'];?></td>
            </tr>
            </br>
            <tr>
                <th>Mon adresse de courriel : </th>
                <td><?php echo $requete_info['Adresse_Courriel'];?></td>
            </tr>
            </br>
           <tr>
                <th>Code de mon programme : </th>
                <td><?php echo $requete_info['Code_Programme'];?></td>
            </tr>
            </br>
            
            <?php
                $Connexion= new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
                $requete_Titre = $Connexion ->prepare("SELECT Titre_Programme FROM tblProgramme WHERE Code_Programme = ?");
                $requete_Titre -> execute(array($requete_info['Code_Programme']));
                $resultat_requete = $requete_Titre -> fetch();
            ?>
               <tr>
                <th>Nom du programme auquel je suis inscrit : </th>
                <td><?php echo $resultat_requete['Titre_Programme'];?></td>
            </tr>
            </br>
            
             
             <?php
                 if($requete_info['Id_Utilisateur'] == $_SESSION['Id_Utilisateur'])
                 {
             ?>
            
           
               </table>
          <p id="optionprofil"><a href="modifier.php">Modifier mon profil</a>
            <a href="Deconnexion1.php">Deconnexion</a></p>

             <?php
                }
            ?>
        </form>
             
       </div>
        <?php
            include('Pied_page.php');
        ?> 
    </body>
</html>
