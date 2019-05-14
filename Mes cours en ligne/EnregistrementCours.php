<?php
session_start();    
 $Connexion = new PDO('mysql:host=127.0.0.1;dbname=MonCollege','root','');

 $ListeCarte = array('Mastercard','Visa');
         if(isset($_POST['numero_Carte_Credit']))
         {
             $message ="Les frais d'inscription de 100.00\$ vous serons chargés !";
         }
       
    
       $requete_cours = $Connexion -> query('select Nom_Utilisateur from tbl_Utilisateurs');
       $requete_cours ->execute();

      
        if(isset($_POST['InscriptionCours']))
       {
           if(isset($_POST['titre_Cours']) && !empty($_POST['titre_Cours']) && 
           isset($_POST['choix_CarteCredit']) && !empty($_POST['choix_CarteCredit']) && 
           isset($_POST['numero_CarteCredit']) && !empty($_POST['numero_CarteCredit']))
           {
               ////
               $titre_Cours = trim(substr($_POST['titre_Cours'],10));
               $Code = trim(substr($_POST['titre_Cours'],0,8));

               //$requete_titre_Cours = $Connexion->prepare("SELECT * FROM tblCours where Titre_Cours= ?");
                //                            $requete_titre_Cours->execute(array($titre_Cours));
                $requete_titre_Cours =$Connexion ->prepare("SELECT Id_Etudiant, Code_Cours FROM tbl_Utilisateurs_Cours WHERE Code_Cours IN (SELECT Code_Cours FROM tblCours WHERE Code_Cours = ?)");
                 $requete_titre_Cours->execute(array($Code));
                                            $Titre_Cours_existe = $requete_titre_Cours ->rowCount();
                //Si le titre du cours n'existe pas 
               if($Titre_Cours_existe == 0)
               {
               ////
               

               $requete_insertion = $Connexion ->prepare("INSERT INTO tbl_Utilisateurs_Cours(Id_Etudiant, Code_Cours, Note) VALUES(?, ?, 'Pas encore de note')");
               $requete_insertion -> execute(array($_SESSION['Id_Utilisateur'], $Code));
               $message = "Vous vous êtes inscrit à un nouveau cours intitulé ".$titre_Cours;

               }
               else
               {
                   $message1 = "Vous ne pouvez pas vous inscrire à un cours auquel vous êtes déja !";
                  
                   
               }
           }
           else
           {
              $message = "Veillez remplir tous les champs !";
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
            include('Entetes/EnteteEtudiant.php');
        ?>
        <div id="div-EnteteUtilisateur">
        <form method="post" action="">
           <h1 id="Enregistrement_cours">Enregistrement à un cours</h1>
            <table id="enregistremntCours">
                <tr>
                    <th colspan="2">Voici la liste de cours offerts pour votre programme</th>
                </tr>
                <tr>
                    <td>Faites votre choix</td>
                    <td>
          
            <?php 

             //Requete pour trouver le id de l'utilisateur en ligne 
             $requete_membre = $Connexion-> prepare("SELECT * FROM tbl_Utilisateurs WHERE Id_Utilisateur = ?");
             $requete_membre -> execute(array($_SESSION['Id_Utilisateur']));
             $requete_info = $requete_membre->fetch();

             //extraction du code du programme de notre tableau $requte_info.
             $code_programme = $requete_info['Code_Programme'];

             //Trouvons tous les code qui commence par 'CC_' suivi des 3 premiers caratères de notre Code programme  suivi de
             //"n'importe quel chaine sachant que ce sont des chiffres allant de 1 à l'infini."
             $Code_cours = 'CC_'.substr($code_programme,-3,3)."%";
             $requete_cours = $Connexion -> prepare('select * from tblCours where Code_Cours LIKE ?');
              $requete_cours ->execute(array($Code_cours));
 
 
         ?>


          <select name="titre_Cours">
                <?php
                    while($resultat = $requete_cours -> fetch())
                    {
                        echo"<option>".$resultat['Code_Cours']." -- ".$resultat['Titre_Cours']."</option>";
                    }
                ?> 
                          
          </select>
            </td>
          </tr>
                <tr>
                    <td>Type de carte de crédit : </td>
                    <td>
               
              <select name="choix_CarteCredit">
            <?php
                foreach($ListeCarte as $Carte)
                {
                   echo"<option>$Carte</option>";
                }
                
            ?>
            </select>
                  </td>
            </tr>
                <tr>
                   <td>Numéro carte de crédit : </td>
                   <td>
            
            <input type="text" name="numero_CarteCredit" id="numeroCarteCredit"  />
                       </td>
               </tr>
                </td>
               <tr>
                   <td><input type="submit" name="InscriptionCours" value="Je m'inscris à ce cours"></td>
                   <td><input type="reset" value="Effacer"></td>
               </tr>
            
            
            
                </table>
            <?php
                if($message)
                {
                    echo $message;
                  
                }
                if($message1)
                {
                    echo $message1;
                    echo"<a href=\"EnregistrementCours.php\">Réessayer</a>";
                }
            ?>
           </form>
            </div> 
         <?php
            include('Pied_page.php');
        ?>
    </body>
</html>
