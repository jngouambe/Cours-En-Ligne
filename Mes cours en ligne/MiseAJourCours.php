<?php
 $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');

   //Ajout de cours
     if(isset($_POST['Ajout_cours']))
    {
            if(isset($_POST['nouveau_cours']) && !empty($_POST['nouveau_cours'])        
            && isset($_POST['codeProgramme']) && !empty($_POST['codeProgramme'])
            && isset($_POST['duree']) && !empty($_POST['duree'])
            && isset($_POST['description']) && !empty($_POST['description']))
            {
               $nouveau_cours =htmlspecialchars($_POST['nouveau_cours']);
               $codeProgramme =htmlspecialchars($_POST['codeProgramme']);
               $duree = htmlspecialchars($_POST['duree']);
               $description =htmlspecialchars($_POST['description']);
           //
                 $requete_Nom_Cours= $Connexion->prepare("SELECT * FROM tblCours WHERE Titre_Cours= ?");
                                            $requete_Nom_Cours->execute(array($nouveau_cours));
                                            $Titre_Cours_existe =$requete_Nom_Cours->rowCount();
                //Si le titre du cours n'existe pas 
               if($Titre_Cours_existe == 0)
               {
                    //       
                   //requete pour selectionnez l'ordre maximun de notre table tblCours_Programme
                    $requete_Ordre = $Connexion -> prepare("SELECT MAX(Ordre) as ordre FROM tblCours_Programme WHERE
                                                        Code_Programme = ? ");
  
            
                     $requete_Ordre -> execute(array($codeProgramme));

                     //Allons chercher la valeur de plus grand ordre
                     $ordre = $requete_Ordre -> fetch();

                     //selectionnons l'ordre de notre tableau
                  
                      $y = 1;  //Variable incrémentant
                      $Ordre_actuel = $ordre['ordre'] + $y ;
             
                     // echo"CC_".substr($chaine,-3,3).$Ordre_actuel;
              
                     //Composition de notre Code de cours
                    // $Code_Programme = "CP_".substr($Titre_programme,0,3);
                   $code_cours = "CC_".substr($codeProgramme,-3,3).$Ordre_actuel;

                   $requete_ajout_cours = $Connexion ->prepare("INSERT INTO tblCours(Code_Cours,Titre_Cours, Duree_Cours, Description_Cours)
                                                                 VALUES (?,?,?,?)");
                    $requete_ajout_cours -> execute(array($code_cours,$nouveau_cours,$duree,$description));
                    //Ajout dans la tableCours_Programme
                    $requete_ajout_cours = $Connexion ->prepare("INSERT INTO tblCours_Programme(Code_Cours, Code_Programme, Ordre)
                                                                 VALUES (?,?,?)");
                    $requete_ajout_cours -> execute(array($code_cours,$codeProgramme,$Ordre_actuel));
          }
          else
            {
                $message = "Ce cours existe déjà dans nos données.";
            }

        }

    }

    //Modification de cours
    if(isset($_POST['Modifier_cours']))
    {
        
        if(isset($_POST['nouveau_titre_cours']) && !empty($_POST['nouveau_titre_cours'])        
        && isset($_POST['CodeCours']) && !empty($_POST['CodeCours'])
        && isset($_POST['nouvelle_duree']) && !empty($_POST['nouvelle_duree'])
        && isset($_POST['nouvelle_description']) && !empty($_POST['nouvelle_description']))
        {
           

            $nouveau_titre_cours = $_POST['nouveau_titre_cours'];
            $CodeCours = substr($_POST['CodeCours'],0,7);
            $ordre_cours = trim(substr($_POST['CodeCours'],6,1));
            //$CodeCours = $_POST['CodeCours'];
            $nouvelle_duree = $_POST['nouvelle_duree'];
            $nouvelle_description = $_POST['nouvelle_description'];
            $Code_Programme ="CP_".substr($_POST['CodeCours'],3,3);
           
          
              $requete = $Connexion ->query("SELECT * FROM tblCours");
              $requete -> execute();
               $requete_update = $Connexion -> prepare(" UPDATE tblCours SET Titre_Cours = ?,
                                                            Duree_Cours = ?, Description_Cours = ? WHERE Code_Cours = ? ");
               $requete_update -> execute(array($nouveau_titre_cours, $nouvelle_duree,$nouvelle_description, $CodeCours));
                                                     
        }
        else
        {
            
            echo"Echec de la modification";
        }
    }

    //Suppression de cours
    if(isset($_POST['Suppression_cours']))
    {
        if(isset($_POST['codeCours']) && !empty($_POST['codeCours']))
        {
            //je souhaite récupére le 7 premiers caracteres dans mon combo_box pour former mon code du cours
            $code_cours = substr($_POST['codeCours'],0,7);

            $requete_suppression_cours = $Connexion -> prepare("DELETE FROM tblCours_Programme WHERE Code_Cours = ?");
            $requete_suppression_cours -> execute(array($code_cours));

            $requete_suppression_cours = $Connexion -> prepare("DELETE FROM tblCours WHERE Code_Cours = ?");
            $requete_suppression_cours -> execute(array($code_cours));

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
            <h1 id="Mise_a_jour_cours">Mise à jour de vos cours</h1>
            <table id="MiseAJourCours">
             <!--Ajouter un cours-->
                <tr>
                    <th colspan="2">Ajouter un cours</th>
                </tr>
                <tr>
                    <td>Choisissez le code du programme :</td>
                    <td>
            
            <?php
                 $requete_programme = $Connexion -> query("SELECT * FROM tblProgramme");
                 $requete_programme ->execute();
            ?>
            <select name="codeProgramme">
                <?php
                     while($resultat = $requete_programme -> fetch())
                     {
             
                           echo "<option>".$resultat['Code_Programme']."</option>";
              
                     }
             
                ?>

            </select>
                    </td>
            </tr>

                <tr>
                    <td>Saississez le nouveau cours :</td>
                    <td><input type="text" name="nouveau_cours"></td>
                </tr>

                 <tr>
                    <td>Duree du cours :</td>
                    <td><input type="text" name="duree"></td>
                </tr>

                 <tr>
                    <td>Descripton du cours:</td>
                    <td><input type="text" name="description"></td>
                </tr>
           
                 <tr>
                    <td></td>
                    <td><input type="submit" value="Ajouter ce Cours" name="Ajout_cours"></td>
                </tr>
            
 
             <!--Modifier un cours-->
            
                <tr>
                    <th colspan="2">Modifier un cours</th>
                </tr>
                <tr>
                    <td>Choisissez le code cours :</td>
                    <td>
                
            <?php
                $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
                 $requete_programme = $Connexion -> query("SELECT * FROM tblCours");
                 $requete_programme ->execute();
            ?>
            
                <?php
                    echo"<select name=\"CodeCours\">";
                     while($resultat = $requete_programme -> fetch())
                     {
             
                            echo "<option>".$resultat['Code_Cours']." -- ".$resultat['Titre_Cours']."</option>";
              
                     }
             
                ?>
            </select></td>
             </tr>
                <tr>
                    <td>Nouveau titre de cours :</td>
                    <td><input type="text" name="nouveau_titre_cours"></td>
                </tr>
                <tr>
                    <td>Nouvelle durée du cours :</td>
                    <td><input type="text" name="nouvelle_duree"></td>
                </tr>
                 <tr>
                    <td>Nouvelle description du cours:</td>
                    <td><input type="text" name="nouvelle_description"></td>
                </tr>
                 <tr>
                    <td></td>
                    <td><input type="submit" value="Modifier ce cours" name="Modifier_cours"></td>
                </tr>
           
            

             <!--Supprimer un cours-->
            <tr>
                    <th colspan="2">Supprimer un cours</th>
                </tr>
                <tr>
                    <td> Choisissez le code cours :</td>
                    <td>
            <?php
                 $requete_cours = $Connexion -> query("SELECT * FROM tblCours");
                 $requete_cours ->execute();
            ?>
            <select name="codeCours">
                <?php
                     while($resultat = $requete_cours -> fetch())
                     {
             
                           echo "<option>".$resultat['Code_Cours']." -- ".$resultat['Titre_Cours']."</option>";
              
                     }
             
                ?>
            </select>
                </td>
            </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Supprimer ce cours" name="Suppression_cours"></td>
                </tr>
            
            
                
                </table>
            <?php
                if($message)
                {
                    echo"<p>";
                    echo $message;
                    echo"<a href=\"MiseAJourCours.php\">Veillez saisir de nouveau le titre du cours</a>";
                    echo"</p>";
                }
            ?>
            </form>
            </div>
        <?php
            include('Pied_page.php');
        ?> 
    </body>
</html>
