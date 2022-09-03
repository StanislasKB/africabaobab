<?php
session_start();
if (!isset($_SESSION['id_assistant'])) {
    header('Location:../accueil/index.php');
}
require "../assets/database.php";
$bdd = seconnecterDb();
$requete=$bdd->prepare('SELECT profil FROM assistant WHERE id_assistant=?');
$requete->execute([$_SESSION['id_assistant']]);
$data=$requete->fetch();
$url=$data['profil'];

if (isset($_POST['change'])) {
    if (isset($_FILES['pdp']) and !empty($_FILES['pdp']['name'])) {
        $temps_actuel = date("U");
      
        $extentionsValides = array('jpg', 'jpeg','png');
        $extentionUpload = strtolower(substr(strrchr($_FILES['pdp']['name'], '.'), 1));
        if (in_array($extentionUpload, $extentionsValides)) {
            $chemin = '../assets/images/profil/' . $temps_actuel . "." . $extentionUpload;
            $resultat = move_uploaded_file($_FILES['pdp']['tmp_name'], $chemin);
            if ($resultat) {
                $req = $bdd->prepare('UPDATE assistant SET profil=? WHERE id_assistant=?');
                $req->execute(array($temps_actuel."." . $extentionUpload, $_SESSION['id_assistant']));
                $succes = "Votre photo a été joutée avec succès";
            } else {
                $error = 'Il y a eu une erreur lors l\'importation de votre photo';
            }
        } else {
            $error = 'Le format de votre photo  n\'est pas autorisé';
        }
    }
    header('Location:profilAssistant.php');
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
    <title>Profil</title>
</head>

<body>
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
                    <li>
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
                    </li>
                </ul>
            </nav>
        </div>
         
    </div>
    <!-- left navigation part -->

    <main class="mt-5 pt-3 px-5 ">
        <div class="container-fluid mt-5">
        <div class="mx-5 rounded-pill row">
                <div class="mb-4 col-md-3">
                    <?php
                 
                    if($url==NULL)
                   {echo ' <img src="../assets/images/profil/default.png"   class="d-block rounded" alt="" width="225px" height="225px">';}
                   else
                   {echo ' <img src="../assets/images/profil/'.$url.'"   class="d-block rounded" alt="" width="225px" height="225px">';}

                    ?>
                </div>
                <div class="col-md-3 mt-lg-5">
                    <button class="btn bg-dark text-white mt-lg-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Changer de photo</button><br>
                   <?php echo ' <button class="btn bg-dark text-white mt-2 mb-2" onclick="Delete('.$_SESSION['id_assistant'].')">Supprimer la photo</button>';?>
                </div>
            </div>
            <?php 
            $reqete=$bdd->prepare('SELECT * FROM assistant where id_assistant=?');
            $reqete->execute([$_SESSION['id_assistant']]);
            while($data=$reqete->fetch())
            {
            echo '<div class="card">
            
                <div class="card-header h3 fw-bold">Informations de Profil</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" placeholder="'.$data['nom'].'" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="inputsurnameWoman" class="form-label">Prénom</label>
                            <input type="text" class="form-control" placeholder="'.$data['prenom'].'" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="inputsurnameWoman" class="form-label">Adresse email</label>
                            <input type="text" class="form-control" placeholder="'.$data['email'].'" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="inputsurnameWoman" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" placeholder="'.$data['tel'].'" disabled>
                        </div>';}
                        
                  echo'  </div>
                </div>
            </div>
            <div class="card mt-4 mb-4">
                <div class="card-header h3 fw-bold">
                    Modifier mot de passe
                </div>';
               if(isset($_GET['code']))
               {
                if($_GET['code']==true)
                {
                    echo '<span class="text-success"> Modification effectuée avec succès </span>';
                    
                }
                else{echo'<span class="text-danger"> Une erreur s\'est produite. Veuillez vérifier les informations entrées</span>';}
               }
               echo' <div class="card-body">
                    <form action="profilAssistantBack.php" method="post">
                    <div class="col-md-10">
                        <label for="inputsurnameWoman" class="form-label" >Ancien mot de passe</label>
                        <input type="password" class="form-control" name="ancien">
                    </div>
                    <div class="col-md-10">
                        <label for="inputsurnameWoman" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" name="nouveau">
                    </div>
                    <div class="col-md-10 mb-4">
                        <label for="inputsurnameWoman" class="form-label">Confirmer</label>
                        <input type="password" class="form-control" name="confirmation">
                    </div>
                    <button type="submit" class="btn btn-dark">Sauvegarder</button>
                    </form>
                </div>
            </div>';?>
        </div>
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="profilAssistant.php" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="file" accept=".jpg,.png,.jpeg" size="5000000" name="pdp">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary" name="change">Changer</button>
      </div>
      </form>
    </div>
  </div>
</div>
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
          function Delete(userid )
        {
          
           
            $.get('delete.php',{
                userid:userid, 
            },function(data){
               location.reload();
            });
            
       

        }
    </script>
</body>

</html>