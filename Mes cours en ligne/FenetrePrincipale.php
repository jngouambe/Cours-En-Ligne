<?php
session_start();
   // if(isset($_POST['connexion']))
   // {
        $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
   
     //  if(mysqli_errno())
     //    {
      //      echo"Echec de connexion à la base de données:".mysqli_error();
     //    } 
         

         if(isset($_GET['id']) && $_GET['id'] > 0)
         {
             $obtenir_id = intval($_GET['id']);
             $requete_membre = $Connexion-> prepare("SELECT * FROM tbl_Utilisateurs WHERE Id_Utilisateur = ?");
             $requete_membre -> execute(array($obtenir_id));
             $requete_info = $requete_membre->fetch();
             
             if($_GET['id'] == 1)
             {
              include('Instructeurs.php');
              exit();
             }
             else
             {
         
   // }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
         <?php
             include('Etudiants.php');
         ?>
    </body>
</html>
<?php
   }

 }
?>
