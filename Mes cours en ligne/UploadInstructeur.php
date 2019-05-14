<?php
    
    $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
     
    $requete_devoir = $Connexion -> query("SELECT * FROM Devoir_Etudiant");
    $requete_devoir -> execute();

                    

  
   if(isset($_POST['Corriger']))
   {
           $Code_Cours = $_POST['Code_Cours'];
           $Id_Etudiant = $_POST['Id_Etudiant'];
           $Note = $_POST['Note'];

       if(isset($Code_Cours) && !empty($Code_Cours) &&
       isset($Note) && !empty($Note) && isset($Id_Etudiant) && !empty($Id_Etudiant))
       {
          
           if($Note > 0)

           {
            
               $requete_Id = $Connexion -> prepare("SELECT * FROM Devoir_Etudiant WHERE Id_Etudiant = ? AND Code_Cours = ? ");
               $requete_Id -> execute(array($Id_Etudiant,$Code_Cours));
               $IdEtudiant_existe = $requete_Id -> rowCount();
               //Si l'id de l'utilisateur existe
                if($IdEtudiant_existe != 0)
                {
                    $requete_note = $Connexion ->prepare("SELECT * FROM tbl_Utilisateurs_Cours WHERE Id_Etudiant = ? AND Code_Cours = ?") ;
                    $requete_note -> execute(array($Id_Etudiant,$Code_Cours));

                    $tableau_note = $requete_note -> fetch();

                    $valeur_note = $tableau_note['Note'];



                    if($valeur_note == "Pas encore de note")
                    {
                         //Mise à jour de la table tbl_Utilisateurs_cours
                     $requete_update_note = $Connexion -> prepare("UPDATE tbl_Utilisateurs_Cours SET Note = ? WHERE Code_Cours = ? AND Id_Etudiant = ?");
                     $requete_update_note -> execute(array($Note,$Code_Cours,$Id_Etudiant));
                     
                     //Suppression du devoir déjà corrigé de la table Devoir_Etudiant
                     $requete_suppression_devoir = $Connexion -> prepare("DELETE FROM Devoir_Etudiant WHERE Code_Cours = ? AND Id_Etudiant = ?");
                     $requete_suppression_devoir -> execute(array($Code_Cours,$Id_Etudiant));

                     $message= "Votre correction est envoyé à l'étudiant correspondant";
                    }
                    elseif($message1)
                    {
                       $message1="Cet étudiant possède déjà une note pour ce cours<br/>";
                       // $message1.="<form method=\"post\" >";
                        $message1.="<input type=\"submit\" value=\"Supprimer son devoir!\" name=\"Suppression_Etudiant\">";
                      //  $message1.="</form>";

                        
                    }
                   
                } 
                else //Sinon
                {
                    $message = "Vous ne pouvez pas corriger un devoir inexistant.";
                }  
           }
           else
           {
               $message = "Vous devez saisir une note valide.";
           }
       }
       else
       {
           $message = "Vous devez saisir des valeurs pour ces champs.";
       }

        ///Suppression
        
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
         <?php
            include('Entetes/EnteteInstructeur.php');
        ?>
        <div id="corps">
            
           <?php
            include('Upload/Upload_cours.php');
        ?>
           <table id="tblCours_telecharger">
         <tr>
             <th colspan="4">Réception de travaux</th>
         </tr>
         <tr>
             <th>Id de l'étudiant</th>
             <th>Code du cours</th>
             <th>Nom du document</th>
             <th>Télécharger</th>
         </tr>
         <?php
            while($resultat = $requete_devoir -> fetch())
            {
                $Id_Fichier = $resultat['Id_Fichier'];
                $Nom_Fichier = $resultat['Nom_Fichier'];
                $Chemin_Fichier = $resultat['Chemin_Fichier'];
                $Id_Utilisateur =$resultat['Id_Etudiant'];
                $code_cours = $resultat['Code_Cours'];
                
                echo"<tr>";
                echo"<td>".$Id_Utilisateur."</td>";
                echo"<td>".$code_cours."</td>";
                echo"<td>".$Nom_Fichier."</td>";
                echo"<td>";
                echo"<a href=\"Downloads/DownloadDevoir.php?chemin=$Chemin_Fichier\">
                <img src=\"Images/download.jpg\" alt=\"download\" id=\"download\"></a>";
                echo"</td>";
                echo"</tr>";
            }
        ?>
         </table>

          <form method="post" id="FormUploadInstructeur">

           <table id="tblCours_corriger">
                <tr>
                    <th colspan="3">Correction des devoirs</th>
                </tr>
               
                  <tr>
                      <td><input type="text" name="Id_Etudiant" placeholder="Saisissez le id de l'étudiant"></td>
                      <td>
                          <select name="Code_Cours">
                        <?php
                              
                      $requete_devoir = $Connexion -> query("SELECT * FROM Devoir_Etudiant");
                      $requete_devoir -> execute();
            
                         while($resultat = $requete_devoir -> fetch())
                            {
                            
                                echo "<option>".$resultat['Code_Cours']."</option>";
                            
                            }
                          ?>
                          </select>
                      </td>
                      <td><input type="text" name="Note" placeholder="Saisissez une note"></td>
                      
                  </tr>
               
            </table>
           
              <input id="input_Corriger" type="submit" name="Corriger" value="Corriger"/>
                   
              </form>
               <p id="messageCorrection">
           <?php
                 if($message)
                  {
                    echo $message;
                  }
             ?> 
                 </p>
            <form method="post">
                <?php
                    if($message1)
                    {
                        echo $message1; 
                    }
                ?>
            </form>
          
        </div>

        <?php
            include('Pied_page.php');
        ?> 
    </body>
</html>
