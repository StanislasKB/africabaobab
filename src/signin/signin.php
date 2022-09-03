<?php
#########################################
require('../assets/database.php');
//Connexion à la base de donnée
$bdd=seconnecterDb();
$success=false;
$type=0;
if(isset($_POST['type_user']))
{
  echo "ici";
  $type=$_POST['type_user'];
}
/****Inscription d'un assistant******/
if(isset($_POST['nomAT']) AND isset($_POST['surnameAT']) AND isset($_POST['telAT']) AND isset($_POST['mailAT']) AND isset($_POST['ATpassword']) AND isset($_POST['secondpassword']))
{
   if($_POST['ATpassword']==$_POST['secondpassword'])
   {
    $req=$bdd->prepare('INSERT INTO users(nom,prenom,tel,email,mot_pass,edit,type_user)
                        VALUES(:nom,:prenom,:telephone,:mail,:pass,:editu,:typeu)');
    echo $type;
    $req->execute([
        ':nom'=>htmlspecialchars($_POST['nomAT']),
        ':prenom'=>htmlspecialchars($_POST['surnameAT']),
        ':telephone'=>htmlspecialchars($_POST['telAT']),
        ':mail'=>htmlspecialchars($_POST['mailAT']),
        ':pass'=>sha1($_POST['ATpassword']),
        ':editu'=>1,
        ':typeu'=>$type,
    ]);
    if($req)
    echo "succès";
    $req->closeCursor();
    $success=true;


   }
   else
   {
        $success=false;
   }
  header('Location:../signin/index.php?code='.$success);
}
/****Inscription d'un assistant */
$success=false;
 if(isset($_POST['nomAssist'],$_POST['prenomAssist'],$_POST['mailAssist'],$_POST['telAssist'],$_POST['userID'],$_POST['passAssist'],$_POST['passAgain']))
 { echo $_POST['userID'];
    if($_POST['passAssist']==$_POST['passAgain']){
      echo "in if2";
    $req2=$bdd->prepare('INSERT INTO assistant(id_user,nom,prenom,email,mot_pass,etat,tel)
                       VALUES(:id,:nomAssist,:prenomAssist,:mailAssist,:pass,:et,:telAssist)');
    $req2->execute([
 
      'id'=>htmlspecialchars($_POST['userID']),
      'nomAssist'=>htmlspecialchars($_POST['nomAssist']),
      'prenomAssist'=>htmlspecialchars($_POST['prenomAssist']),
      'mailAssist'=>htmlspecialchars($_POST['mailAssist']),
      'pass'=>sha1($_POST['passAssist']),
      'et'=>0,
      'telAssist'=>htmlspecialchars($_POST['telAssist']),
    
    ]);
    if($req2){echo "succès";}
    $success=true;
 header('Location:../dashboard/index.php');  
  }   else
  {
    echo "in else";
    $success=false;
    header('Location:../dashboard/index.php?possible='.$success); 
  }       
 }

?>