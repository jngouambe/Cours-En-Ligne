<?php
  
$Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');

   if(isset($_POST['Voir']) && !empty($_POST['Titre_Cours']))
     {
         $titre_cours =$_POST['Titre_Cours'];
         
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
        <div id="banner2"><h1><em>Informations sur notre cours de <?php echo $titre_cours;?></em><img src="Images/cours.jpg" alt="cours"></h1></div>
        <div id="corps">
            <table id="information_cours">
                <?php
                    $requete_info_cours =  $Connexion -> prepare ("SELECT * FROM tblCours WHERE Titre_Cours = ?");
                    $requete_info_cours -> execute(array($titre_cours));

                    $resultat = $requete_info_cours -> fetch();
                ?>
                <tr>
                    <th>Code du cours</th>
                    <th>Titre du cours</th>
                    <th>Durée du cours</th>
                    <th>Brève desciption du cours</th>
                </tr>
                <tr>
                    <?php
                        echo"<td>".$resultat['Code_Cours']."</td>";
                        echo"<td>".$resultat['Titre_Cours']."</td>";
                        echo"<td>".$resultat['Duree_Cours']." Heures</td>";
                        echo"<td>".$resultat['Description_Cours']."</td>";
                    ?>
                    
                </tr>
            </table>
            <a href="Inscription.php">Vous inscrire au programme qui comporte ce cours ?</a>
            
        </div>
       <?php
            include('Pied_page.php');
        ?>
    </body>
</html>
