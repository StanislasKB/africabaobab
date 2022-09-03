 <?php 
 #######################################################
 #       FICHIER DE MODIFICATION DE MOT DE PASSE       #
 #######################################################
 session_start();
 require('../assets/database.php');
 //Connexion à la base de donnée
 $bdd=seconnecterDb();
 $succes=false;

 if(isset($_POST['ancien'],$_POST['nouveau'],$_POST['confirmation']))
 {
   //vérification de l'exactitude de l'ancien  mot de passe
    $req=$bdd->prepare('SELECT mot_pass FROM users WHERE mot_pass=? AND id_user=?');
    $req->execute([sha1($_POST['ancien']),$_SESSION['id']]);
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
            echo '4';
            $requete=$bdd->prepare('UPDATE users SET mot_pass=? WHERE mot_pass=? AND id_user=?');
            $requete->execute([sha1($_POST['nouveau']),sha1($_POST['ancien']),$_SESSION['id']]);
            $succes=true;    
        }
    }

 }
  header('Location:index.php?code='.$succes);
 ?>