<?php
session_start();
 require('../assets/database.php');
 //Connexion à la base de donnée
 $bdd=seconnecterDb();


 /**********/

 if(isset($_GET['campagneID'],$_GET['userID']))
 {
    
    $requete=$bdd->prepare('SELECT edition_campagne FROM campagne WHERE id_campagne=?');
    $requete->execute([htmlspecialchars($_GET['campagneID'])]);
    $data=$requete->fetch();
    $edition=$data['edition_campagne'];
    $req=$bdd->prepare('SELECT id_comcam FROM association_cuc WHERE id_user=? AND id_campagne=?');
    $req->execute([htmlspecialchars($_GET['userID']),htmlspecialchars($_GET['campagneID'])]);
    $data0=$req->fetch();
    $req2=$bdd->prepare('SELECT commune FROM commune_campagne WHERE id_comcam=?');
    $req2->execute([$data0['id_comcam']]);
    $data=$req2->fetch();
    $commune=$data['commune'];
    $matricule=generateMatricule(getLastMatricule($bdd));
while(isMatriculeExist($bdd,$matricule))
{
    $matricule=generateMatricule(getLastMatricule($bdd));
}

    echo $matricule;
    echo " ".$commune;
    echo " ".$edition;
}

 if(isset($_POST['campagneid'],$_POST['userid']))
 {
  
    $requete=$bdd->prepare('SELECT edition_campagne FROM campagne WHERE id_campagne=?');
    $requete->execute([htmlspecialchars($_POST['campagneid'])]);
    $edition="";
    while($data=$requete->fetch()){ $edition=$data['edition_campagne'];}
   
    $req=$bdd->prepare('SELECT id_comcam FROM association_cuc WHERE id_user=? AND id_campagne=?');
    $req->execute([htmlspecialchars($_POST['userid']),htmlspecialchars($_POST['campagneid'])]);
   $commune="";
    while($data0=$req->fetch()){
    $req2=$bdd->prepare('SELECT commune FROM commune_campagne WHERE id_comcam=?');
    $req2->execute([$data0['id_comcam']]);
    while($data=$req2->fetch())
    {$commune=$data['commune'];}
    }
    $matricule=generateMatricule(getLastMatricule($bdd));
while(isMatriculeExist($bdd,$matricule))
{
    $matricule=generateMatricule(getLastMatricule($bdd));
}
 if(isset($_POST['nomWoman'],$_POST['surnameWoman'],$_POST['age'],$_POST['activite'],
 $_POST['matrimonial'],$_POST['contact'],$_POST['village'],$_POST['groupement'],$_POST['statut'],
 $_POST['collecte'],$_POST['observation'],$_FILES['photo']))
 {  
    
   
    if ( !empty($_FILES['photo']['name'])) {
        $temps_actuel = date("U");
      
        $extentionsValides = array('jpg', 'jpeg','png');
        $extentionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
        if (in_array($extentionUpload, $extentionsValides)) {
            $chemin = '../assets/images/femme/' . $temps_actuel . "." . $extentionUpload;
            $resultat=move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
            if($resultat)
           { $route=$temps_actuel . "." . $extentionUpload;}
        }
    }else{$route="default.png";}
    echo $chemin;
     //$dateEnregistrement = date('d/m/Y');
     $req=$bdd->prepare('INSERT INTO femmes(nom,prenom,age,matricule,activite,stmatrimoniale,telephone,commune,village,nom_regroupement,statut,edition_campagne,capacite,observations,photo,id_user,id_assistant,date_recensement)
                         VALUES(:nomW,:prenomW,:ageW,:matriculeW,:activiteW,:stmatrimonialeW,:telephoneW,:communeW,:villageW,:nom_regroupementW,:statutW,:edition_campagneW,:capaciteW,:observationsW,:picture,:iduser,:idA,CURDATE() )');

     $req->execute([
         ':nomW'=>htmlspecialchars($_POST['nomWoman']),
         ':prenomW'=>htmlspecialchars($_POST['surnameWoman']),
         ':ageW'=>htmlspecialchars($_POST['age']),
         ':matriculeW'=>$matricule,
         ':activiteW'=>htmlspecialchars($_POST['activite']),
         ':stmatrimonialeW'=>htmlspecialchars($_POST['matrimonial']),
         ':telephoneW'=>htmlspecialchars($_POST['contact']),
         ':communeW'=>$commune,
         ':villageW'=>htmlspecialchars($_POST['village']),
         ':nom_regroupementW'=>htmlspecialchars($_POST['groupement']),
         ':statutW'=>htmlspecialchars($_POST['statut']),
         ':edition_campagneW'=>$edition,
         ':capaciteW'=>htmlspecialchars($_POST['collecte']), +
         ':observationsW'=>htmlspecialchars($_POST['observation']),
         ':picture'=>$route,
         ':iduser'=>htmlspecialchars($_POST['userid']),
         ':idA'=>$_SESSION['id_assistant']
         //':date_recensementW'=>$dateEnregistrement,
        
     ]);
    
     $req->closeCursor();
     header('Location:../dashboard/recensementAssistant.php');
     

   
 }
}

 


function generateMatricule($ancien)
{
    $decoupage=explode("-",$ancien);
    $nbr=intval($decoupage[1]);
    $nbr++;
    $a=strval($nbr);
    $matricule=$decoupage[0].'-'.$a;
    return $matricule;

}
function getLastMatricule($bd)
{
    $req=$bd->query('SELECT matricule FROM femmes ORDER BY id_femme DESC LIMIT 1');
    $data=$req->fetch();
    return $data['matricule'];
}
function isMatriculeExist($bd,$mat)
{
    $req=$bd->prepare('SELECT matricule FROM femmes WHERE matricule=?');
    $req->execute([$mat]);
    $verify=$req->rowCount();
   $exist=false;
    if($verify>0)
    {
        $exist=true;
    }
    else{$exist=false;}
    return $exist;
}

    

?>

