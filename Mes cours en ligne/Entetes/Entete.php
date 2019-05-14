<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="Css/Authentification.css">
        <link rel="stylesheet" href="Css/Accueil.css">
    </head>
    <body>
        <div id="banner1">
            <img src="Images/grif.jpg" alt="ecole"><em> Mes cours en ligne</em>
            <div id="connexion">
                
                <?php 
                    include('Authentification.php');
                ?>
            </div>
        </div>
        <div id="nav-bar">
            <ul>
                <li><a  href="Index.php" id="Accueil">Accueil</a></li>
                <li><a  href="Programmes.php">Programmes et Cours </a></li>
                <li><a  href="Inscription.php">Inscrivez-vous</a></li>
                
            </ul>
        </div>
    </body>
</html>