<?php
#########################################################
#  FICHIER DE GESTION D'AGENT DE TERRAIN                #
#########################################################
require "../assets/database.php";

$bdd = seconnecterDb();
//Association d'un AT à une campagne
if (isset($_POST['category'], $_POST['secret'])) {
  // echo $_POST['category'];
  // echo $_POST['secret'];

  $req = $bdd->prepare('INSERT INTO association_cuc(id_user,id_campagne)
        VALUES(:idu,:idc)');
  $req->execute([
    'idu' => htmlspecialchars($_POST['secret']),
    'idc' => htmlspecialchars($_POST['category']),
  ]);

  header('Location:../dashboard/index.php');
}
//Association d'une commune à un AT dans une campagne
if (isset($_POST['secretUser'], $_POST['choix'], $_POST['secretCampagne'])) {


  $requete = $bdd->prepare('UPDATE association_cuc SET id_comcam=? WHERE id_user=? AND id_campagne=?');
  $requete->execute([htmlspecialchars($_POST['choix']), $_POST['secretUser'], $_POST['secretCampagne']]);
  header('Location:../dashboard/gestionAT.php?ID=' . $_POST['secretCampagne']);
}
//Contrôle de droits d'édition d'un AT dans une campagne pour une commune
if (isset($_GET['userID'], $_GET['campagneID'], $_GET['comcamID'])) {
  $req = $bdd->prepare('SELECT etat_asso FROM association_cuc WHERE id_campagne=? AND id_user=? AND id_comcam=?');
  $req->execute([htmlspecialchars($_GET['campagneID']), htmlspecialchars($_GET['userID']), htmlspecialchars($_GET['comcamID'])]);
  $etat = 0;
  while ($donne = $req->fetch()) {
    $etat = $donne['etat_asso'];
  }
  $state = 0;
  if ($etat == 0) {
    $state = 1;
  } else {
    $state = 0;
  }

  $requete = $bdd->prepare('UPDATE association_cuc SET etat_asso=? WHERE id_campagne=? AND id_user=? AND id_comcam=?');
  $requete->execute([$state, $_GET['campagneID'], $_GET['userID'], $_GET['comcamID']]);
  $req = $bdd->prepare('SELECT etat_asso FROM association_cuc WHERE id_campagne=? AND id_user=? AND id_comcam=?');
  $req->execute([htmlspecialchars($_GET['campagneID']), htmlspecialchars($_GET['userID']), htmlspecialchars($_GET['comcamID'])]);
  while ($donne = $req->fetch()) {
    $etat = $donne['etat_asso'];
  }
  echo $etat;
}
//Blocage d'un AT
if (isset($_GET['userID'])) {
  $req = $bdd->prepare('SELECT edit   FROM users WHERE id_user=?');
  $req->execute([htmlspecialchars($_GET['userID'])]);
  $etat = 0;
  while ($data = $req->fetch()) {
    $etat = $data['edit'];
  }
  $req->closeCursor();
  $state = 0;
  if ($etat == 0) {
    $state = 1;
  } else {
    $state = 0;
  }

  $requete = $bdd->prepare('UPDATE users SET edit=? WHERE id_user=?');
  $requete->execute([$state, htmlspecialchars($_GET['userID'])]);
  $req = $bdd->prepare('SELECT edit   FROM users WHERE id_user=?');
  $req->execute([htmlspecialchars($_GET['userID'])]);
  $etat = 0;
  while ($data = $req->fetch()) {
    $etat = $data['edit'];
  }
  echo $etat;
}
