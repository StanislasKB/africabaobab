<?php session_start();
if(isset($_SESSION['id']) OR isset($_SESSION['id_assistant']))
{
   
}
else{ header('Location:../accueil/index.php');}
require "../assets/database.php";
$bdd = seconnecterDb();
$admin = false;
$req = $bdd->prepare('SELECT type_user FROM users WHERE id_user=?');
$req->execute([$_SESSION['id']]);
$query=$bdd->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
$donnee = $req->fetch();
if ($donnee['type_user'] == 1) {
    $admin = true;
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
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <!-- CSS includes -->
    <title>Exportation</title>
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
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <?php if($admin){echo '<th>Commune</th>';}?>
                                            <th>Nom du groupement</th>
                                            <th>Village</th>
                                            <th>Exporter</th>
                                            <th>Exporter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if(!$admin)
                                        {$requete=$bdd->prepare('SELECT nom_regroupement, village FROM femmes WHERE id_user=? GROUP BY nom_regroupement');
                                        $requete->execute([$_SESSION['id']]);
                                        while($data=$requete->fetch())
                                       { echo'
                                        <tr>
                                            <td>'.$data['nom_regroupement'].'</td>
                                            <td>'.$data['village'].'</td>
                                            <td>
                                                <a href="carteMembre.php?back='.$data['nom_regroupement'].'" class="btn btn-dark btn-sm assist" target="blank">Cartes membres</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a  href="ficherecensement.php?back='.$data['nom_regroupement'].'" class="btn  btn-sm bg-dark text-white" target="blank"><span>Fiche de recensement</span>
                                                </a>
                                            </td>
                                        </tr>';}}elseif($admin)
                                        {

                                            $requete=$bdd->query('SELECT nom_regroupement, village,commune FROM femmes GROUP BY nom_regroupement');
                                       // $requete->execute([$_SESSION['id']]);
                                        while($data=$requete->fetch())
                                       { echo'
                                        <tr>
                                            <td>'.$data['commune'].'</td>
                                            <td>'.$data['nom_regroupement'].'</td>
                                            <td>'.$data['village'].'</td>
                                            <td>
                                                <a href="carteMembre.php?back='.$data['nom_regroupement'].'" class="btn btn-dark btn-sm assist" target="blank">Cartes membres</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="ficherecensement.php?back='.$data['nom_regroupement'].'" class="btn  btn-sm bg-dark text-white" target="blank"><span>Fiche de recensement</span>
                                                </a>
                                            </td>
                                        </tr>';
                                        }
                                    }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>