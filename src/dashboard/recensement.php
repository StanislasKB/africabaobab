<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location:../accueil/index.php');
}
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
$req2=$bdd->prepare('SELECT * FROM association_cuc INNER JOIN commune_campagne ON commune_campagne.id_comcam=association_cuc.id_comcam
                        WHERE id_user=? AND association_cuc.id_campagne=?');
$req2->execute([$_SESSION['id'], htmlspecialchars($_GET['campagneID'])]);
while($datac=$req2->fetch())
{
$macommune=$datac['commune'];
}
?>

<!DOCTYPE html>
<html lang="fr">

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

    <title>Recensement</title>
</head>

<body>
    <!-- top navigation bar -->
    <?php include('nav.php'); ?>
    <!-- top navigation bar -->
    <!-- left navigation bar -->
    <?php include('offcanvas.php'); ?>
    </div>
    <!-- left navigation part -->
    <main class="mt-5 pt-3 ">

        <div class="container mt-5">
            <div class="h1 mt-4 "> Recensement pour le compte de la commune de <?php echo $macommune;?></div>
            <div class="card mb-5">
        <?php echo'   <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="getWomanData('.htmlspecialchars($_GET['campagneID']).')">
                <span class="me-2"><i class="bi bi-person-plus"></i></span>
                <span >Récenser</span>
            </button>'?>
            </div>

            <!-- Filter table part-->
            <?php include('filtertablewoman.php'); ?>
            <!-- Filter table part-->
        </div>
        <!-- Add modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire de récensement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row" method="post" action="recensementBack.php" enctype="multipart/form-data">

                            <div class="col-md-6">
                                <label for="inputnomWoman" class="form-label">Nom de la femme</label>
                                <input type="text" class="form-control" id="inputnomWoman" name="nomWoman" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputsurnameWoman" class="form-label">Prénom de la femme</label>
                                <input type="text" class="form-control" id="inputsurnameWoman" name="surnameWoman" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAge" class="form-label">Age de la femme</label>
                                <input type="number" class="form-control" id="inputAge" min="10" name="age"required >
                            </div>
                            <div class="col-md-6">
                                <label for="inputmatricule" class="form-label" >Matricule</label>
                         <input type="text" class="form-control" id="inputmatricule" name="matricule" disabled> 
                            </div>
                            <div class="col-md-6">
                                <label for="inputActivity" class="form-label">Activités</label>
                                <input type="text" class="form-control" id="inputActivity" name="activite" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputStMatri" class="form-label">Situation matrimoniale</label>
                                <input type="text" class="form-control" id="inputStMatri" name="matrimonial" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputTel" class="form-label">Numéro de téléphone</label>
                                <input type="Tel" class="form-control" id="inputTel" name="contact" required>
                            </div>
                            <div class="col-md-6">
                                <label for="photo" class="form-label">Profil</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept=".jpg,.png,.jpeg" size="5000000">
                            </div>
                           
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">Commune</label>
                           <input type="text" class="form-control" id="inputCity" name="city" disabled >
                            </div>
                            <div class="col-md-6">
                                <label for="inputVillage" class="form-label">Village</label>
                                <input type="text" class="form-control" id="inputVillage" name="village" required>
                            </div>


                            <div class="col-md-6">
                                <label for="inputGroupement" class="form-label">Nom du Groupement</label>
                                <input type="text" class="form-control" id="inputGroupement" name="groupement" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputStatut" class="form-label">Statut</label>
                                <input type="text" class="form-control" id="inputStatut" name="statut" required>
                            </div>
                            <div class="col-6">
                                <label for="inputEdition" class="form-label">Edition</label>
                             <input type="text" class="form-control" id="inputEdition" name="edition" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="inputCollecte" class="form-label">Capacité de Collecte</label>
                                <input type="number" class="form-control" min="1" id="inputCollecte" name="collecte" required>
                            </div>
                            <div class="col-md-12">
                                <label for="floatingTextarea">Observations</label>
                                <textarea class="form-control" id="floatingTextarea" name="observation" required></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <?php  echo '<input type="text" class="d-none" value="'.htmlspecialchars($_GET['campagneID']).'" name="campagneid">';?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                       <?php echo' <button type="submit" class="btn btn-primary" >Enregistrer</button>';?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Add modal-->
    </main>
    <!-- JS includes -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <!-- JS includes -->
    <script>
        function getWomanData(idcampagne)
        {
          
           
            $.get('recensementBack.php',{
               campagneID:idcampagne,
            },function(data){
                var tab=data.split(" ",);
             $('#inputmatricule').attr("placeholder",tab[0]);
             $('#inputCity').attr("placeholder",tab[1]);
             $('#inputEdition').attr("placeholder",tab[2]+" "+tab[3]+" "+tab[4]);
            });      

        }
        // function sendID(idcampagne)
        // {
          
           
        //     $.get('recensementBack.php',{
        //        campagneid:idcampagne,
        //     },function(data){
               
        //     });      

        // }
    </script>
</body>

</html>