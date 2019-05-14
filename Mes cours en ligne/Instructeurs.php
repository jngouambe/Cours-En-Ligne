<?php
     $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');
     //Pour selectionner tous les programmes dans notre BD.
     $requete_programme = $Connexion -> query("SELECT * FROM tblProgramme");
     $requete_programme ->execute();

    
    
    
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
        <div id="div-EnteteUtilisateur">
        <form action="" method="post" id="Profil">
           
           <h1>Yves Desharnais</h1>
            <table id="tblInstructeur">
            <tr>
                <th>Nom d'utilisateur :</th>
                <td> <?php echo $requete_info['Nom_Utilisateur'];?></td>
            </tr>
                <tr>
                <th>Mon adresse de courriel :</th>
                <td> <?php echo $requete_info['Adresse_Courriel'];?></td>
            </tr>
            </br>
             
            </br>

            <!---->
             <?php
                 if($requete_info['Id_Utilisateur'] == $_SESSION['Id_Utilisateur'])
                 {
             ?>
            
             
            </table>
           <p id="optiondeconnexion"> <a href="Deconnexion1.php">Deconnexion</a></p>
             <?php
                 }
            ?>
        </form>
             
       </div>
        <?php
            include('Pied_page.php');
        ?> 
    </body>
</html>
