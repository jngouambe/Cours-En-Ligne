<?php
    
 $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
     //Pour selectionner tous les programmes dans notre BD.
     $requete_programme = $Connexion -> query("SELECT * FROM tblProgramme");
     $requete_programme ->execute();


    //Ajout d'un programme
    if(isset($_POST['Ajouter']))
     {
             if(isset($_POST['Ajout_Programme']) && !empty($_POST['Ajout_Programme']))
             {
                 $Titre_programme = htmlspecialchars($_POST['Ajout_Programme']);
                 $Code_Programme = "CP_".substr($Titre_programme,0,3);
                 $requete_ajout = $Connexion ->prepare("INSERT INTO tblProgramme(Code_Programme,Titre_Programme) VALUES (?,?)");
                 $requete_ajout ->execute(array($Code_Programme, $Titre_programme));
             }
     } 

 //Modidification d'un programme
      if(isset($_POST['Modifier']))
     {
             if(isset($_POST['Modifier_Programme']) && !empty($_POST['Modifier_Programme']))
             {
                 //$requete = ;
                 $Ancien_titre = $_POST['Modifier_Programme'];
                 $Nouveau_Titre_Programme = htmlspecialchars($_POST['Nouveau_Titre_Programme']);
                 $Nouveau_Code_Programme = "CP_".substr($Nouveau_Titre_Programme,0,3);
                 $requete_modifier = $Connexion ->prepare("UPDATE tblProgramme SET Code_Programme = ?,Titre_Programme = ? WHERE Titre_Programme = ?");
                 $requete_modifier ->execute(array($Nouveau_Code_Programme,$Nouveau_Titre_Programme,$Ancien_titre));
                 
                 $CodeCours = "CC_".substr($Nouveau_Titre_Programme,0,3)."%";
                 //update de la table tbl_Cours_Programme
                 $requete_update = $Connexion -> prepare("UPDATE tblCours_Programme SET Code_Cours LIKE ? , Code_Programme = ?");
                 $requete_update -> execute(array($CodeCours,$Nouveau_Code_Programme));
             }
     }
    

      //Suppression d'un programme
     if(isset($_POST['Supprimer']))
     {
             if(isset($_POST['Supprimer_Programme']) && !empty($_POST['Supprimer_Programme']))
             {
                  

                 //$Titre_programme = htmlspecialchars($_POST['Ajout_Programme']);
                 $Titre_Programme = htmlspecialchars($_POST['Supprimer_Programme']);
                
                 $code_programme = "CP_".substr($Titre_Programme,0,3);
                // $requete_Ordre = $Connexion -> prepare("SELECT Ordre FROM tblCours_Programme WHERE
                 //                               Code_Programme = ? ");
  
                // $requete_Ordre -> execute(array($code_programme));

                //Création du code que nous allons passez en paramètre.
                 $code_cours = "CC_".substr($Titre_Programme,0,3).'%';
                

                 
                 //Suppression des champs correspondant dans la table tblCours_Programme
                 $requete_suppression = $Connexion -> prepare("DELETE FROM tblCours_Programme WHERE Code_Programme = ?");
                 $requete_suppression -> execute(array($code_programme));
                 //Suppression du Programme dans la table tblProgramme
                 $requete_suppression = $Connexion ->prepare("DELETE FROM tblProgramme WHERE Titre_Programme = ?");
                 $requete_suppression ->execute(array($Titre_Programme));

                 $requete_suppression_c = $Connexion -> prepare("DELETE FROM tblCours WHERE Code_Cours LIKE ? ");

                 $requete_suppression_c -> execute(array($code_cours));

             }
     }
      

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
            include('Entetes/EnteteInstructeur.php');
        ?>
         <div id="corps">
         <form action="" method="post">
           <h1 id="Mise_a_jour_programme">Mise à jour de vos programmes</h1>
            </br></br>
             <table id="MiseAJourProgramme">
             <!--Ajout d'un programme-->
                 <tr>
                     <th colspan="2">Ajouter un programme</th>
                 </tr>
                 <tr>
                     <td>Saisissez le nom du programme</td>
                     <td><input type="text" name="Ajout_Programme" placeholder="votre programme" autofocus="true"></td>
                    
                 </tr>
                 <tr>
                     <td></td>
                      <td><input type="submit" value="Ajouter Programme" name="Ajouter"></td>
                 </tr>
                
              <!--Modification d'un programme-->
                 <tr>
                     <th colspan="2">Modifier un programme </th>
                 </tr>
                  <tr>
                      <td>Choisissez le programme</td>
                      <td>
                  
            <?php
                 $requete_programme = $Connexion -> query("SELECT * FROM tblProgramme");
                 $requete_programme ->execute();
            ?>
            <select name="Modifier_Programme">
                <?php
                     while($resultat = $requete_programme -> fetch())
                     {
             
                           echo "<option>".$resultat['Titre_Programme']."</option>";
              
                     }
             
                ?>
            </select>
                      </td>
                  </tr>

                 <tr>
                     <td></td>
                     <td><input type="text" name="Nouveau_Titre_Programme" placeholder="Nom du nouveau programme"></td>
                     
                 </tr>

                 <tr>
                     <td></td>
                     <td><input type="submit" value="Modifier Programme" name="Modifier"></td>
                 </tr>
            
             <!--Supression d'un programme-->
                 <tr>
                     <th colspan="2">Supprimer un programme </th>
                 </tr>
                 <tr>
                     <td>Choisissez le programme</td>
                    <td>
            
             <?php
                 $requete_programme = $Connexion -> query("SELECT * FROM tblProgramme");
                 $requete_programme ->execute();
            ?>
            <select name="Supprimer_Programme">
                <?php
                     while($resultat = $requete_programme -> fetch())
                     {
             
                           echo "<option>".$resultat['Titre_Programme']."</option>";
              
                     }
             
                ?>
            </select>
            </td>
                </tr>
                 <tr>
                     <td></td>
                     <td><input type="submit" value="Supprimer Programme" name="Supprimer"></td>
                 </tr>
            
           </table> 
          </form>
        </div>
        <?php
            include('Pied_page.php');
        ?> 
    </body>
</html>
