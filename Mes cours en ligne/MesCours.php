<?php
session_start();

   $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');  
   
   
    
  
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
        <h1 id="Mes_Cours"> Mes cours</h1>
            
            <?php  ?>
            <table id="tblCours">
                <tr>
                    <th>
                       Code du cours 
                    </th>
                    <th>
                        Titre des mes cours
                    </th>
                    <th>
                        Note
                    </th>
                </tr>

            <?php
              
                $id_etudiant =  $_SESSION['Id_Utilisateur'];
                
 
            //   $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
                $requete = $Connexion ->prepare("SELECT * FROM tbl_Utilisateurs_Cours WHERE Id_Etudiant = ? ");
                $requete -> execute(array($id_etudiant));

                
              //requete pour selectionnez tous les champs de ma table tblCours
                $requete_titre_correspondant = $Connexion -> prepare("SELECT * FROM tblCours WHERE Code_Cours = ?");

               while($resultat = $requete -> fetch())
               {
                   echo "<tr>";
                   

                   echo"<td>".$resultat['Code_Cours']."</td>";
                   //Apres avoir trouvé la valeur du code du cours 
                   //on passe sa en paramètre à notre requete
                   $requete_titre_correspondant -> execute(array($resultat['Code_Cours']));
                   $Chercher_requete = $requete_titre_correspondant -> fetch();
                   $titre_cours = $Chercher_requete['Titre_Cours'];

                   echo "<td>".$titre_cours."</td>";
                   echo"<td>".$resultat['Note']."</td>";
                   echo "</tr>";
               }
                
               
              
            ?>
             </table>
         </div>
         <?php
            include('Pied_page.php');
        ?> 
    </body>
</html>
