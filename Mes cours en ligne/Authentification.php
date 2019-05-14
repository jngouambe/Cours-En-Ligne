<?php
session_start();
    if(isset($_POST['Authentification']))
    {
        $Connexion= new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
   
       if(mysqli_errno())
         {
            echo"Echec de connexion à la base de données:".mysqli_error();
         } 
        $Nom_Utilisateur_connect = htmlspecialchars(trim($_POST['Nom_Utilisateur_connect']));
        $Mot_Passe_connect = trim($_POST['Mot_Passe_connect']); 
        if(!empty($Nom_Utilisateur_connect) && !empty($Mot_Passe_connect))
        {
            $requete_membre = $Connexion->prepare("SELECT * FROM tbl_Utilisateurs WHERE Nom_Utilisateur = ? and Mot_Passe = ?");
            $requete_membre -> execute(array($Nom_Utilisateur_connect, $Mot_Passe_connect));
            $membre_existe = $requete_membre -> rowCount();
            //Si l'utilisateur est trouvé
            if($membre_existe==1)
            {
                $membre_info = $requete_membre -> fetch();
                //Déclaration de nos variables de session
                $_SESSION['Id_Utilisateur']= $membre_info['Id_Utilisateur'];
                $_SESSION['Nom_Utilisateur']= $membre_info['Nom_Utilisateur'];
                $_SESSION['Mot_Passe']= $membre_info['Mot_Passe'];

                //Ajout de l'ID de l'étudiant dans la table UtilisateurEnLigne
                
                $requete_ajout = $Connexion -> prepare('INSERT INTO UtilisateurEnLigne (Id_Utilisateur, Nom_Utilisateur) VALUES (?, ?)');
                $requete_ajout ->execute(array($_SESSION['Id_Utilisateur'],$_SESSION['Nom_Utilisateur']));
               

                header("location:FenetrePrincipale.php?id=".$_SESSION['Id_Utilisateur']);
            }
            else // Sinon
            {
                $erreur="Adresse de courriel ou mot de passe incorrect !";
            }
        }
        else
        {
             $erreur="Tous les champs doivent être complétés.";
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
         
        <form action="" method="post">
            <input type="text" id="Nom_Utilisateur_connect" placeholder="Nom d'utilisateur" value="" name="Nom_Utilisateur_connect" autofocus="true">
            <input type="password" placeholder="Mot de passe" value="" name="Mot_Passe_connect">
            <!--<input type="reset" value="Effacer">-->
            <input type="submit" id="submit_connexion" value="Se connecter" name="Authentification">
        </form>
        <p id="erreur">
             <?php 
                    if($erreur)
                    {
                        echo $erreur;
                    }

                ?>
      </p>
    </body>
</html>
