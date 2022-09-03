<?php
session_start();
if(!isset($_SESSION['id_assistant']))
{
    header('Location:../accueil/index.php');
}
require "../assets/database.php";
$bdd=seconnecterDb();
$requete1=$bdd->prepare('SELECT id_user FROM assistant WHERE id_assistant=?');
$requete1->execute([$_SESSION['id_assistant']]);
//$iduser=0;
$data=$requete1->fetch();
$iduser=$data['id_user'];
$requete1->closeCursor();
$requete2=$bdd->prepare('SELECT * FROM association_cuc INNER JOIN campagne ON association_cuc.id_campagne=campagne.id_campagne
                                WHERE id_user=?');
$requete2->execute([$data['id_user']]);
//$campagneid=0;
while($data=$requete2->fetch())
{$campagneid=$data['id_campagne'];
$idcomcam=$data['id_comcam'];}
$req2=$bdd->prepare('SELECT * FROM femmes WHERE id_assistant=?');
$req2->execute([$_SESSION['id_assistant']]);
$req3=$bdd->prepare('SELECT commune FROM commune_campagne WHERE id_comcam=?');
$req3->execute([$idcomcam]);
while($data=$req3->fetch())
{
    $macommune=$data['commune'];
}



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

    <title>Recensement</title>
</head>

<body>
<div>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand mx-4  fw-bold logo" href="../accueil/index.php"><img src="../assets/images/logobg.png" class="imag" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
                <form class="d-flex ms-auto my-3 my-lg-0">
                    
                </form>
                <ul class="navbar-nav d-flex justify-content-end" >
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../profil/profilAssistant.php">Profil</a></li>
                            <li><a class="dropdown-item" href="../logout/index.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- top navigation bar -->
    <!-- left navigation bar -->
   
<div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <a href="../dashboard/recensementAssistant.php" class="nav-link px-3 active">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Tableau de Bord</span>
                        </a>
                    </li>

                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>

                    <li>
                        <a href="../accueil/index.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi  bi-house-door"></i></span>
                            <span>Accueil </span>
                        </a>
                    </li>
               
                    <li class="my-4">
                        <hr class="dropdown-divider bg-light" />
                    </li>
                    <!-- <li>
                        <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                            Aide
                        </div>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-question-diamond"></i></span>
                            <span>FAQ</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-info-square"></i></span>
                            <span>Centre d'aide</span>
                        </a>
                    </li> -->
                </ul>
            </nav>
        </div>
         
    </div>
    <!-- left navigation part -->
    <main class="mt-5 pt-3 ">

        <div class="container mt-5">
            <div class="h1 mt-4 "> Recensement pour le compte de la commune de <?php echo $macommune;?></div>
            <div class="card mb-5">
        <?php echo'   <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="getWomanData('.$campagneid.','.$iduser.')">
                <span class="me-2"><i class="bi bi-person-plus"></i></span>
                <span >Récenser</span>
            </button>'?>
            </div>

            <!-- Filter table part-->
            
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
                        <form class="row" method="post" action="recensementAssistantBack.php" enctype="multipart/form-data">

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
                                <input type="number" class="form-control" id="inputAge" min="10" name="age" required>
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
                        <?php  echo '<input type="text" class="d-none" value="'.$campagneid.'" name="campagneid">';?>
                        <?php  echo '<input type="text" class="d-none" value="'.$iduser.'" name="userid">';?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                       <?php echo' <button type="submit" class="btn btn-primary" >Enregistrer</button>';?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
        <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i></span>Tableau Récapitulatif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Age</th>
                                            <th>Matricule</th>
                                            <th>Activités</th>
                                            <th>Situation</th>
                                            <th>Numéro</th>
                                            <th>Commune</th>
                                            <th>Village</th>
                                            <th>Groupement</th>
                                            <th>Statut</th>
                                            <th>Edition</th>
                                            <th>Collecte</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($donnee=$req2->fetch())
                                    {   echo '
                                        <tr>
                                            <td>'.$donnee['nom'].'</td>
                                            <td>'.$donnee['prenom'].'</td>
                                            <td>'.$donnee['age'].'</td>
                                            <td>'.$donnee['matricule'].'</td>
                                            <td>'.$donnee['activite'].'</td>
                                            <td>'.$donnee['stmatrimoniale'].'</td>
                                            <td>'.$donnee['telephone'].'</td>
                                            <td>'.$donnee['commune'].'</td>
                                            <td>'.$donnee['village'].'</td>
                                            <td>'.$donnee['nom_regroupement'].'</td>
                                            <td>'.$donnee['statut'].'</td>
                                            <td>'.$donnee['edition_campagne'].'</td>
                                            <td>'.$donnee['capacite'].'</td>
                                            
                                        </tr>';
                                    }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Age</th>
                                            <th>Matricule</th>
                                            <th>Activités</th>
                                            <th>Situation</th>
                                            <th>Numéro</th>
                                            <th>Commune</th>
                                            <th>Village</th>
                                            <th>Groupement</th>
                                            <th>Statut</th>
                                            <th>Edition</th>
                                            <th>Collecte</th>
                                         
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
        function getWomanData(idcampagne,iduser)
        {
          
           
            $.get('recensementAssistantBack.php',{
               campagneID:idcampagne, userID:iduser,
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