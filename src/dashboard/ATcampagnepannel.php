<?php
session_start();
if(isset($_SESSION['id']) OR isset($_SESSION['id_assistant']))
{
   
}
else{ header('Location:../accueil/index.php');}
require "../assets/database.php";
$bdd=seconnecterDb();
$admin=false;
$req=$bdd->prepare('SELECT type_user FROM users WHERE id_user=?');
$req->execute([$_SESSION['id']]);
$donnee=$req->fetch();
if($donnee['type_user']==1)
{
$admin=true;
}
if($admin)
{
    header('Location:../dashboard/index.php');
}
$req2=$bdd->prepare("SELECT * FROM association_cuc INNER JOIN campagne ON campagne.id_campagne=association_cuc.id_campagne
WHERE association_cuc.id_user=?");
$req2->execute([$_SESSION['id']]);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS includes -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <!-- CSS includes -->
  <title>Gestion AT</title>
</head>

<body>
  <!-- top navigation bar -->
  <?php include('nav.php'); ?>
  <!-- top navigation bar -->
  <!-- left navigation bar -->
  <?php include('offcanvas.php'); ?>
  </div>
  <!-- left navigation part -->
  <main class="mt-5 pt-3">
    <div class="container-fluid">
      <!-- Campagne filter table -->
      <table class="table table-striped mt-4">
        <tr>
          <td>Titre</td>
          <td>Edition</td>
          <td>Statut</td>
          <td>Commune associée</td>
          <td>Droit d'édition</td>
          <td></td>
        </tr>
        <?php
        $etat="";
        $droit="";
        $bouton="";
        while($data=$req2->fetch())
        {
          if($data['etat_campagne']==1){$etat="Ouverte";}else{$etat="Fermée"; $bouton="  disabled";}
          if($data['etat_asso']==1){$droit="Accordé";}else{$droit="Refusé"; $bouton="  disabled";}
          $requete2=$bdd->prepare('SELECT * FROM commune_campagne WHERE id_comcam=?');
          $requete2->execute([$data['id_comcam']]);
          $commune="";
          while($data0=$requete2->fetch()){$commune=$data0['commune'];}
          echo'
        <tr>
          <td>'.$data['titre'].'</td>
          <td>'.$data['edition_campagne'].'</td>
          <td>'.$etat .'</td>
          <td>'.$commune.'</td>
          <td>'.$droit.'</td>
          <td><button'.$bouton.' class="btn bg-success btn-sm"><a href="recensement.php?campagneID='.$data['id_campagne'].'" class="text-decoration-none text-white">Aller au récensement</a></button></td>

        </tr>';
        }
        ?>
      </table>
      <!-- Campagne filter table -->
    </div>
    <!-- JS includes -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <!-- JS includes -->
</body>

</html>