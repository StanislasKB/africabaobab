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
    <title>Mes Assistants</title>
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
                                <th>Email</th>
                                <th>Contact</th>
                                <th></th>
                               <th></th>
                                 

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $requete=$bdd->prepare('SELECT * FROM assistant WHERE id_user=?');
                            $requete->execute([$_SESSION['id']]);
                            $statecolor="btn-success";
                            $stateMes="";
                   
              
                            while($data=$requete->fetch())
                            {              if($data['etat']==0){$statecolor=" bg-danger"; $stateMes="Bloqué";}else{$statecolor=" bg-success";$stateMes="Débloqué";}
                                echo'
                            <tr>
                                <td>'.$data['nom'].'</td>
                                <td>'.$data['prenom'].'</td>
                                <td>'.$data['email'].'</td>
                                <td>'.$data['tel'].'</td>
                                <td>
                                    <button id="" class="btn btn-sm '.$statecolor.'" onclick="bloquerAssist('.$data['id_assistant'].')"><span class="text-white">'.$stateMes.'</span></button>
                                              
                                </td>
                                <td>
                                    <a id="" class="btn bg-success btn-sm"><span class="text-white">Notifier</span></a>
                                              
                                </td>
                                </tr>';}
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th></th>
                               <th></th>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
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
        function bloquerAssist(userid )
        {
          
           
            $.get('assistantBack.php',{
                userID:userid, 
            },function(data){
               location.reload();
            });
            
       

        }
    </script>
</body>
</html>