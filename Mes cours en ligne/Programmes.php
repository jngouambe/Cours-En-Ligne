<?php
  
 $Connexion= new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');

 $requete_programme = $Connexion -> query("SELECT * FROM tblProgramme");
 $requete_programme ->execute();
 //$resulat = $requete_programme ->fetch();
 // $requete_Cours_programme = $Connexion -> query("SELECT * FROM ")
     
     if(isset($_POST['Voir']))
     {
         $titre_cours = $_POST['Titre_Cours'];
         header("location:Cours.php");
         exit();
     }
    

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="Css/Accueil.css">
        <link rel="stylesheet" href="Css/Cours.css">
    </head>
    <body>
        <?php
            include('Entetes/Entete.php');
        ?>
        <div id="banner2"><h1><em>Nos Programmes offerts</em><img src="Images/cours.jpg" alt="cours"></h1></div>
        <div id="corps">
        <form method="post" action="Cours.php">
        <h1 id="Liste_De_Programme">Liste des programmes</h1>
        <table id="ListeProgramme">
            <tr>
                 <th>Code Programme</th>
                 <th>Titre Programme</th>
                 <th>Cours proposés</th>
            </tr>
       <?php
           
           while($resultat = $requete_programme -> fetch())
           {
               echo "<tr>";
               echo "<td>".$resultat['Code_Programme']."</td>";
               echo "<td><strong>".$resultat['Titre_Programme']."</strong></td>";
               //Affectation de la valeur de du code du programme à notre variable programme
               $Code_Programme = $resultat['Code_Programme'];
               //requte preparée 
               $requete_cours = $Connexion -> prepare("SELECT Code_Cours, Titre_Cours FROM tblCours WHERE Code_Cours IN
                                    (SELECT Code_Cours FROM tblCours_Programme WHERE Code_Programme = ?) ");
               $requete_cours ->execute(array($Code_Programme));
               //
               
               echo"<td><select id=\"Titre_Cours\" name=\"Titre_Cours\">";
               while($resultat_cours = $requete_cours -> fetch())
               {
                   echo "<option>".$resultat_cours['Titre_Cours']."</option>";
                   
               }
               echo"</select><input type=\"submit\" value=\"Voir\" name=\"Voir\"></td>";
               echo "</tr>";
           }
            
        ?>
           
        </table>
        </form>
   </div>
        
         <?php
              include('Pied_page.php');
         ?>     
          </body>
</html>