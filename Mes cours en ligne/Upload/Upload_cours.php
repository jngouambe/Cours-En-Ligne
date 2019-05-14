<?php
session_start();    
    $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
        if(isset($_POST['OK']))
        {
            $nom_doc =$_POST['nom_doc'];
            $informations = $_FILES['Fichier'];
            $nom_fichier = $informations['name'];
            $temp_file = $informations['tmp_name'];
            $Code_Cours = trim(substr($_POST['Code_Cours'],0,7));
            $Code_Programme = 'CP_'.substr($_POST['Code_Cours'],3,3);

            if($nom_fichier)
            {
                $destination ="FichierInstructeurs/".$nom_fichier;
                 move_uploaded_file($temp_file,utf8_decode($destination));
                  
                 $id_etudiant =  $_SESSION['Id_Utilisateur'];
               
                    //$requete = $Connexion -> prepare("INSERT INTO tbl_Cours_Etudiant(Code_Cours, Nom_Fichier, Chemin_Fichier) VALUES(?,?,?,?)");
                  //  $requete -> execute(array($Code_Cours,$nom_doc,$destination));
                    //header("Location : UploadEtudiant.php");
               
                    $requete = $Connexion -> prepare("INSERT INTO Cours_Etudiant(Code_Cours, Nom_Fichier, Chemin_Fichier,Code_Programme) VALUES(?,?,?,?)");
                    $requete -> execute(array($Code_Cours, $nom_doc, $destination,$Code_Programme));
            }
            else
            {
                    echo "Erreur de téléversement !" ;
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            
            <table id="envoiCours">
                <tr>
                    <th colspan="2">Envoi d'un cours</th>
                </tr>
                
                <tr>
                    <th>Code du cours</th>
                    <?php
                         //recherche des codes de cours auxquels est inscrit l'étudiant.
                        $id_etudiant =  $_SESSION['Id_Utilisateur'];
                     $requeteCode = $Connexion ->query("SELECT * FROM tblCours");
                     $requeteCode -> execute();
                   ?> 
                    <td>
                        <select name="Code_Cours">
                        <?php
                            while($Code = $requeteCode -> fetch())
                            {
                                echo"<option>";
                                echo $Code['Code_Cours']." -- ".$Code['Titre_Cours'];
                                echo"</option>";
                            }
                        ?>
                         </select>
                    </td>
                </tr>
                <tr>
                    <th>Nom du fichier :</th>
                    <td><input type="text" name="nom_doc"></td>
                </tr>
                 <tr>
                     <th>Sélectionnez votre fichier</th>
                     <td><input type="file" name="Fichier"></td>
                 </tr>   
                 <tr>
                     <td></td>
                     <td><input type="submit" value="Transférer" name="OK"></td>
                 </tr>
            </table> 
        </form>
    </body>
</html>
