<?php 
####################################################################
#       FICHIER DE MODIFICATION DE MOT DE PASSE POUR ASSISTANT     #
####################################################################
 session_start();
 require('../assets/database.php');
 //Connexion à la base de donnée
 $bdd=seconnecterDb();
 $succes=false;

 if(isset($_POST['ancien'],$_POST['nouveau'],$_POST['confirmation']))
 {
   //vérification de l'excatitude du mot de passe
    $req=$bdd->prepare('SELECT mot_pass FROM assistant WHERE mot_pass=? AND id_assistant=?');
    $req->execute([sha1($_POST['ancien']),$_SESSION['id_assistant']]);
    $verify=$req->rowCount();
    $exist=false;
    if($verify>0)
    {
      
        $exist=true;
    }
    if($exist)
    {
        //Modification du mot de passe
        if($_POST['nouveau']==$_POST['confirmation'])
        {
            
            $requete=$bdd->prepare('UPDATE assistant SET mot_pass=? WHERE mot_pass=? AND id_assistant=?');
            $requete->execute([sha1($_POST['nouveau']),sha1($_POST['ancien']),$_SESSION['id_assistant']]);
            $succes=true;    
        }
    }

 }
  header('Location:profilAssistant.php?code='.$succes);
 ?>