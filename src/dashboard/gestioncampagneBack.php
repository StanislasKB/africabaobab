<?php
#####################################################
#         FICHIER D'INITIATION DE CAMPAGNE          #
#####################################################
require('../assets/database.php');
//Connexion à la base de donnée
$bdd=seconnecterDb();
if(isset($_POST['campagneEdit'],$_POST['campagneTitre']))
{
    $req=$bdd->prepare('INSERT INTO campagne(titre,edition_campagne,etat_campagne)
            VALUES(:titreC,:editionC,:etatC)');
    $req->execute([
        'titreC'=>htmlspecialchars($_POST['campagneTitre']),
        'editionC'=>htmlspecialchars($_POST['campagneEdit']),
        'etatC'=>0,
    ]);
    $req->closeCursor();
    header('Location:../dashboard/index.php');
}