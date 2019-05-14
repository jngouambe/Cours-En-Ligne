<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link href="Css/Accueil.css" rel="stylesheet">
    </head>
    <body>
       <?php
           include('Entetes/Entete.php');
       ?>
        
        <div id="banner2"><h1>Bienvenue sur<em> Mes cours en ligne</em><img src="Images/cours.jpg" alt="cours"></h1></div>
        <div id="corps">
            <h1 id="histo_accueil">Historique</h1>
          <!-- <p id="Historique">-->
         <?php
             include('Fichiers/historique1.txt');
         ?>
            <!--  </p>-->
        </div>
        <?php
            include('Pied_page.php');
        ?>
        
    </body>
</html>