<?php
###########################################################
#             FICHIER DE GESTION DES ASSISTANTS           #
###########################################################
require "../assets/database.php";
//CONNEXION A LA BASE DE DONNEE
$bdd = seconnecterDb();
//Blocage d'un utilisateur Assistant
if (isset($_GET['userID'])) {
    $req = $bdd->prepare('SELECT etat   FROM assistant WHERE id_assistant=?');
    $req->execute([$_GET['userID']]);
    $etat = 0;
    while ($data = $req->fetch()) {
      $etat = $data['etat'];
    }
    $req->closeCursor();
    $state = 0;
    if ($etat == 0) {
      $state = 1;
    } else {
      $state = 0;
    }
  
    $requete = $bdd->prepare('UPDATE assistant SET etat=? WHERE id_assistant=?');
    $requete->execute([$state, htmlspecialchars($_GET['userID'])]);
    $req = $bdd->prepare('SELECT etat FROM assistant WHERE id_assistant=?');
    $req->execute([htmlspecialchars($_GET['userID'])]);
    $etat = 0;
    while ($data = $req->fetch()) {
      $etat = $data['etat'];
    }
    echo $etat;
  }
  