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
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

    <title>AfricaBaobab | AT Dashboard</title>
    <style type="text/css">
    	.multiselect-container{
    		width: 300px;
    	}
    	.multiselect-item > a,.multiselect-container >li>a{
    		color: black;
    	}
    </style>
</head>

<body>
    <!-- top navigation bar -->
    <?php include('nav.php');?>
    <!-- top navigation bar -->
    <!-- left navigation bar -->
    <?php include('offcanvas.php');?>
    </div>
    <!-- left navigation part -->
    <!-- views details part -->
    <main class="mt-5 pt-3">
        <div class="container-fluid">
        <?php 
        if(!$admin){
            $requete=$bdd->prepare('SELECT COUNT(id_femme) AS nbrfemme FROM femmes WHERE id_user=?');
            $requete->execute([$_SESSION['id']]);
            while($data=$requete->fetch())
            {
            echo'    
            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-header py-4 text-center">Nombre de femme</div>
                        <div class="card-body text-center">
                        '.$data['nbrfemme'].'
                        </div>
                    </div>
                </div>';
            }  
            $requete->closeCursor();
            $requete=$bdd->prepare('SELECT (COUNT(nom_regroupement)) AS nbreRegroup FROM femmes WHERE id_user=? GROUP BY nom_regroupement');
            $requete->execute([$_SESSION['id']]);
           $nombre=$requete->rowCount();
           
            echo'
                <div class="col-md-6 mb-3">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-header py-4 text-center">Nombre de regroupement</div>
                        <div class="card-body text-center">
                        '.$nombre.'
                        </div>

                    </div>
                </div>
            </div> 
     
            <!-- Graphic details part-->';}
         if($admin){echo'
            <div class="row mt-5 mx-2">
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span> Courbe du nombre de femmes recensées par campagne
                        </div>
                        <div class="card-body">
                        <canvas id="mystat" class="w-100 h-100" ></canvas>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span> Courbe de la capacité de collecte par campagne
                        </div>
                        <div class="card-body">
                        <canvas id="messtat" class="w-100 h-100" ></canvas>
                        </div>
                    </div>
                </div>
            </div>';}
            ?>

            <div class="row mx-2">
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span> Graphique du nombre de femmes recensées
                        </div>
                        <div class="card-body">
                        <canvas id="myChart" class="w-100 h-100" ></canvas>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span> Grapique de la capacité de collecte des femmes recensées
                        </div>
                        <div class="card-body">
                        <canvas id="monchart" class="w-100 h-100" ></canvas>
                        </div>
                    </div>
                </div>
            </div>
          
            <!--Grapihc details part-->
            <!-- Filter table part-->
            <?php if($admin){ include('filtertableuser.php');}else{include('filtertablewoman.php');} ?>
            <!-- Filter table part-->
        </div>
        <!-- Button trigger modal -->


       <?php if(isset($_GET['possible']) AND $_GET['possible']==false)
       {
        echo "<script> alert('Echec de l'inscription !! Veuillez recommencer');</script>";
       }
       ?>
       
    </main>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="../assets/js/bootstrap-multiselect.min.js"></script>
    <!-- JS includes -->
    <script type="text/javascript">
	$('#selectoption').multiselect({
		includeSelectAllOption:true,
		nonSelectedText:'Sélectionner la campagne',
		enableFiltering:true,
		buttonWidth:'100%'
	});

        $('.mybouton').click(function(){
    var identifiant=$(this).attr("id");
    $('.secretinput').val(identifiant);
  });
        $('.assist').click(function(){
    var identifiant=$(this).attr("id");
    $('.secretuserID').val(identifiant);
  });
  function bloquer(userid )
        {
          
           
            $.get('addAT.php',{
                userID:userid, 
            },function(data){
               location.reload();
            });
            
       

        }

    <?php 
   if($admin)
    {$req=$bdd->query('SELECT COUNT(id_femme) AS nbr, commune FROM femmes GROUP BY commune');
    while($data=$req->fetch())
    {
        $commun[]=$data['commune'];
        $femme[]=$data['nbr'];
    }}
    elseif(!$admin)
    {
        $req=$bdd->prepare('SELECT COUNT(id_femme) AS nbr, village FROM femmes WHERE id_user=? GROUP BY village');
        $req->execute([$_SESSION['id']]);
        while($data=$req->fetch())
        {
            $commun[]=$data['village'];
            $femme[]=$data['nbr'];
        }
    }

    ?>


const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($commun); ?>,
        datasets: [{
            label: 'nbr de femmes',
            data: <?php echo json_encode($femme) ;?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
<?php 
   if($admin)
   {
   $req=$bdd->query('SELECT SUM(capacite) AS nbr, commune FROM femmes GROUP BY commune');
   while($data=$req->fetch())
   {
       $commune[]=$data['commune'];
       $capacite[]=$data['nbr'];
   }
}elseif(!$admin)
{
    $req=$bdd->prepare('SELECT SUM(capacite) AS nbr, village FROM femmes WHERE id_user=?  GROUP BY village');
    $req->execute([$_SESSION['id']]);
   while($data=$req->fetch())
   {
       $commune[]=$data['village'];
       $capacite[]=$data['nbr'];
   }
}
   ?>
const ct = $('#monchart');
const monChart = new Chart(ct, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($commune); ?>,
        datasets: [{
            label: 'capacité de collecte',
            data: <?php echo json_encode($capacite) ;?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


<?php 
   
   $req=$bdd->query('SELECT COUNT(id_femme) AS nbr, edition_campagne FROM femmes GROUP BY edition_campagne');
   while($data=$req->fetch())
   {
       $edt[]=$data['edition_campagne'];
       $nbrfemme[]=$data['nbr'];
   }
   ?>
const stat= $('#mystat');
const mystat = new Chart(stat, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($edt); ?>,
        datasets: [{
            label: 'nombre de femme',
            data: <?php echo json_encode($nbrfemme) ;?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


<?php 
   
   $req=$bdd->query('SELECT SUM(capacite) AS nbr, edition_campagne FROM femmes GROUP BY edition_campagne');
   while($data=$req->fetch())
   {
       $edit[]=$data['edition_campagne'];
       $nbre[]=$data['nbr'];
   }
   ?>
const stats= $('#messtat');
const messtat = new Chart(stats, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($edt); ?>,
        datasets: [{
            label: 'capacité de collecte',
            data: <?php echo json_encode($nbre) ;?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
    
</body>
</html>
<?php


// if(isset($_POST['category'],$_POST['secret']))
// {
    
//         echo $_POST['category'].$_POST['secret'];
//         // $req=$bdd->prepare('INSERT INTO association_cuc(id_user,id_campagne)
//         // VALUES(:idu,:idc)');
//         // $req->execute([
//         //     'idu'=>$_POST['secret'],
//         //     'idc'=>$_POST['category'],
//         // ]);
  
//     // header('Location:../dashboard/index.php');
// }
?>