<?php
############################################
# Fichier de suppression de photo de profil#
############################################
session_start();
require "../assets/database.php";
$bdd = seconnecterDb();

if(isset($_GET['userID']))
{
    $query=$bdd->prepare('UPDATE users SET profil=null WHERE id_user=?');
    $query->execute([htmlspecialchars($_GET['userID'])]);
echo htmlspecialchars($_GET['userID']);
}
if(isset($_GET['userid']))
{
    $query=$bdd->prepare('UPDATE assistant SET profil=null WHERE id_assistant=?');
    $query->execute([htmlspecialchars($_GET['userid'])]);
    
}