<?php

            $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
            //requete pour la liste de programme
             $requete_programme = $Connexion -> query("SELECT Titre_Programme FROM tblProgramme");
             $requete_programme ->execute();

             //$listeProgramme = $requete_programme -> fetch_assoc();
            // $liste =array($listeProgramme);

            //Si l'utilisateur appuie sur le bouton S'inscrire.  
        if(isset($_POST['Enregistrer']))
        {
            //Variables de notre application web.
            //$erreur=FALSE;
            
            $Nom_Utilisateur = htmlspecialchars(trim($_POST['Nom_Utilisateur']));
            $Mot_Passe = htmlspecialchars(trim($_POST['Mot_Passe']));
            
            $Nom = htmlspecialchars(trim($_POST['Nom']));
            $Prenom = htmlspecialchars(trim($_POST['Prenom']));
            $Adresse_Courriel = htmlspecialchars(trim($_POST['Adresse_Courriel']));
            $Programme = htmlspecialchars(trim($_POST['Programme']));
            $Code_Programme = 'CP_'.substr($Programme,0,3);
            
            if(isset($Nom_Utilisateur) && !empty($Nom_Utilisateur) && isset($Mot_Passe) && !empty($Mot_Passe) &&
            isset($Nom) && !empty($Nom) && isset($Prenom) && !empty($Prenom) && isset($Adresse_Courriel) && !empty($Adresse_Courriel))
            {
                if(strlen($Nom_Utilisateur) < 50)
                {
                    if(strlen($Mot_Passe) < 30)
                    {
                        if(strlen($Nom) < 50)
                        {
                            if(strlen($Prenom) < 30)
                            {
                                if(filter_var($Adresse_Courriel,FILTER_VALIDATE_EMAIL))
                                {
                                        $requete_Nom_Utilisateur= $Connexion ->prepare("SELECT * FROM tbl_Utilisateurs where Nom_Utilisateur= ?");
                                        $requete_Nom_Utilisateur->execute(array($Nom_Utilisateur));
                                        $Nom_Utilisateur_existe =$requete_Nom_Utilisateur->rowCount();
                                        //Si le nom d'utilisateur n'existe pas 
                                        if($Nom_Utilisateur_existe == 0)
                                        {
                                                    //En cas de succès à toutes ces épreuvres
                                                    //Insertion de l'étudiant dans notre table tbl_Utilisateurs
                                                        $requete = $Connexion->prepare("INSERT INTO tbl_Utilisateurs(Nom_Utilisateur, Mot_Passe, Nom, Prenom, Adresse_Courriel, Code_Programme) VALUES (?,?,?,?,?,?)");
                                                        $requete->execute(array($Nom_Utilisateur, $Mot_Passe, $Nom, $Prenom, $Adresse_Courriel, $Code_Programme));
                                                       // $message="Vous étudiant ".$Nom." avez été inscrit avec succès,";
                                                        header("Location: EnregistrementCours.php");
                                        }
                                        else  //sinon
                                        {
                                            $message="Ce nom d'utilisateur existe déjà !";
                                        }
                                }
                                else
                                {
                                    //$erreur=TRUE;
                                    $message="Adresse de courriel invalide.";
                                }
                            }
                            else
                            {
                                //$erreur=TRUE;
                                $message="Votre prénom doit comporter moins de 30 caractères.";
                            }
                        }
                        else
                        {
                           //$erreur=TRUE;
                            $message="Votre nom de famille doit comporter moins de 50 caractères.";
                        }
                    
                    }
                    else
                    {
                      // $erreur=TRUE;
                       $message="Votre mot de passe doit comporter moins de 30 caractères.";
                    }
                }
                else
                {
                  // $erreur=TRUE;
                   $message="Votre nom d'utilisateur doit comporter moins de 50 caractères.";   
                }
            }
            else
            {
               //$erreur=TRUE;
               $message="Tous les champs doivent être complétés.";
            }
                                                          
       }
       
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="Css/Inscription.css">
        <link rel="stylesheet" href="Css/Accueil.css">
    </head>
    <body>
        <?php
           include('Entetes/Entete.php');
       ?>
        
        <div id="banner2"><h1><em>L'inscription</em> sera votre premier pas !<img src="Images/cours.jpg" alt="cours"></h1></div>
        <div id="corps">
        <div id="form">
           <form id="formulaire" name="MonFormulaire" action="Inscription.php" method="post">
               <h2>veillez remplir ce formulaire d'inscription</h2>
               <p id="consigne"><em>*Tous les champs sont obligatoires.</em></p> 
            <table id="tbl_inscription">
                <tr>
                    <th><label for="NomUtilisateur" >Nom d'utilisateur</label></th>
                </tr>
                <tr>
                    <td><input type="text" name="Nom_Utilisateur" id="NomUtilisateur" value="<?php echo"";?>"  autofocus="true"/></td>
                </tr>
                <tr>
                    <th><label for="MotPasse">Mot de passe</label></th>
                </tr>
                <tr>
                    <td><input type="password" name="Mot_Passe" id="MotPasse"  /></td>
                </tr>
                <tr>
                    <th><label for="Nom">Nom de famille</label></th>
                </tr>
                <tr>
                    <td><input type="text" name="Nom" id="Nom" /></td>
                </tr>
                <tr>
                    <th><label for="Prenom">Prénom</label></th>
                </tr>
                <tr>
                    <td><input type="text" name="Prenom" id="Prenom"  /></td>
                </tr>
                <tr>
                    <th><label for="Courriel">Adresse de courriel</label></th>
                </tr>
                <tr>
                    <td><input type="email" name="Adresse_Courriel" id="Courriel" /></td>
                </tr>
               <tr>
                    <th><label>Choisissez votre programme </label></th>
              </tr>
               <tr>
                   <td>
                       <select name="Programme">
                    <?php
                        while($progr = $requete_programme ->fetch())
                        {
                            echo"<option>".$progr['Titre_Programme']."</option>";
                        }
                    ?>
                         </select>
                      </td>
                </tr> 
       </table>
               <p id="message">
           <?php
                 if($message)
                  {
                   echo $message;
                  }
              ?> 
                </p>
               <p><input type="submit" name="Enregistrer" value="Je m'inscris"><input type="reset" value="Effacer"></p>
    </form> 
       </div>         
   </div>
         
        <?php
            include('Pied_page.php');
        ?>
    </body>
</html>
