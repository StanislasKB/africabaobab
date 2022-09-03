<?php
#########################################################
#               FICHIER DE GESTION DE COMMUNE           #
#########################################################
require "../assets/database.php";
//Connexion à la base de donnée
$bdd=seconnecterDb();
if(isset($_POST['category'],$_POST['secret']))
{   //Association des communes à une campagne
    foreach($_POST['category'] as $key => $value)
    {
        $req=$bdd->prepare('INSERT INTO commune_campagne(id_campagne, commune, etat)
        VALUES(:ide,:comm,:ett)');
        $req->execute([
            'ide'=>htmlspecialchars($_POST['secret']),
            'comm'=>htmlspecialchars($value),
            'ett'=>1,
        ]);
    }
    $req->closeCursor();

    header('Location:../dashboard/campagne.php');
}

if(isset($_POST['confirmPass']))
{   //Vérification de l'identité de l'utilisateur
    $exist=false;
    $requete=$bdd->query('SELECT mot_pass FROM users WHERE type_user=1');
    while($donne=$requete->fetch())
    {
        if($donne['mot_pass']==sha1($_POST['confirmPass']))
        {
            $exist=true;
            break;
        }
    }
    if($exist==true)
    {
        if(isset($_POST['secretPass']))
        {
            
         $req=$bdd->prepare('SELECT etat_campagne FROM campagne WHERE id_campagne=?');
         $req->execute([htmlspecialchars($_POST['secretPass'])]);
        while($donne=$req->fetch()) { $etat=$donne['etat_campagne'];}
        $req->closeCursor();
        //Changement de l'état d'une campagne(campagne fermée ou ouverte)
        $req2=$bdd->prepare('UPDATE campagne SET etat_campagne=? WHERE id_campagne=?');
      $state=0;
       if($etat==0){$state=1;}else{$state=0;}
       $req2->execute([$state,$_POST['secretPass']]);
       header('Location:../dashboard/campagne.php');
    } 
    else{header('Location:../dashboard/campagne.php');}   
    }else{header('Location:../dashboard/campagne.php');}

}
else{header('Location:../dashboard/campagne.php');}
//Changement du droit d'un Agent de terrain (droit accordé ou pas)
if(isset($_POST['secretUser'],$_POST['choix'],$_POST['secretCampagne']))
{
    $requete=$bdd->prepare('UPDATE association_cuc SET id_comcam=? WHERE id_user=? AND id_campagne=?');
    $requete->execute([htmlspecialchars($_POST['choix']),htmlspecialchars($_POST['secretUser']),htmlspecialchars($_POST['secretCampagne'])]);
    
}