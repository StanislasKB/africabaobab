<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location:../accueil/index.php');
}
require "../assets/database.php";
$bdd = seconnecterDb();
$admin = false;
$req = $bdd->prepare('SELECT type_user FROM users WHERE id_user=?');
$req->execute([$_SESSION['id']]);
$donnee = $req->fetch();
if ($donnee['type_user'] == 1) {
    $admin = true;
}
if (!$admin) {
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
    <link rel="stylesheet" href="../assets/css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <!-- CSS includes -->
    <title>Gestion AT</title>
    <style type="text/css">
        .multiselect-container {
            width: 300px;
        }

        .multiselect-item>a,
        .multiselect-container>li>a {
            color: black;
        }
    </style>
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
            <!-- AT filter table -->
            <div class="table-responsive mt-4">
                <table id="example" class="table table-striped data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Commune</th>
                            <th>Droit d'Edition</th>
                            <th></th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['ID'])) {
                            $requete = $bdd->prepare('SELECT * FROM association_cuc INNER JOIN users 
                                                                    ON association_cuc.id_user=users.id_user WHERE id_campagne=?');
                            $requete->execute([$_GET['ID']]);

                            while ($data = $requete->fetch()) {
                                $requete2=$bdd->prepare('SELECT id_comcam FROM association_cuc 
                                                            WHERE  id_user=? AND id_campagne=?');
                                $requete2->execute([$data['id_user'],$data['id_campagne']]);
                                $commune="";
                                $idcommune=0;
                                $statecolor=" btn-success";
                                $stateMes="Accordé";
                                while($data0=$requete2->fetch()){
                                    $req2=$bdd->prepare('SELECT commune FROM commune_campagne WHERE id_comcam=?');
                                    $req2->execute([$data0['id_comcam']]);
                                    $data1=$req2->fetch();
                                    $commune=$data1['commune'];
                                }
                                if($data['etat_asso']==0){$statecolor=" bg-danger"; $stateMes="Refusé";}else{$statecolor=" bg-success";$stateMes="Accordé";}
                                echo '
                                        <tr>
                                            <td>' . $data['nom'] . '</td>
                                            <td>' . $data['prenom'] . '</td>
                                            <td>' . $data['email'] . '</td>
                                            <td>' . $data['tel'] . '</td>
                                            <td>'.$commune.'</td>
                                            <td><button  class="btn btn-sm state-btn'.$statecolor.'"  onclick="toChangeState('.$data['id_user'].','.$data['id_campagne'].','.$data['id_comcam'].')"><span class="monspan">'.$stateMes.'</span></button></td>
                                            <td>
                                                <a id="'.$data['id_user'].'" class="btn btn-dark btn-sm mybuton"><span data-bs-toggle="modal" data-bs-target="#CommuneModal"></i>Attribuer</span>
                                                </a>
                                            </td>
                                            
                                            <td>
                                                <a href="" class="btn btn-success btn-sm onclick="sendMail('.$data['id_user'].')"><span class="">Notifier</span>
                                                </a>
                                            </td>
                                        </tr>';
                                        
                            }
                        }
                        ?>
                    </tbody>

                </table>

                <!-- ATfilter table -->
            </div>
            <!-- Add commune Modal -->
            <!-- Button trigger modal -->


            <!-- Modal -->
            <div class="modal fade" id="CommuneModal" tabindex="-1" aria-labelledby="CommuneModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="CommuneModalLabel">Commune de la campagne</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="addAT.php" method="POST">
                            <div class="modal-body">
                            <select class="form-select multiselect-container" id="selectoption" name="choix">
                                <?php
                                if (isset($_GET['ID'])) {
                                    $requete2 = $bdd->prepare('SELECT * FROM commune_campagne WHERE id_campagne=?');
                                    $requete2->execute([htmlspecialchars($_GET['ID'])]);
                                   
                                    while ($data = $requete2->fetch()) {
                                        echo '
                                              
                                                <option id="'.$data['id_campagne'].'" value="' . $data['id_comcam'] .'" >' . $data['commune'].'</option>
                                             ';
                                    }
                                }
                                ?>
                                 </select>
                            </div>
                            <div class="modal-footer">
                            <input type="text" class="d-none secretInput" name="secretUser">
                            <?php echo  '<input type="text" class="d-none secretInCampagne" name="secretCampagne" value="'.htmlspecialchars($_GET['ID']).'">'; ?>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add commune Modal -->
    </main>
    <!-- JS includes -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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
            includeSelectAllOption: true,
            nonSelectedText: 'Sélectionner la campagne',
            enableFiltering: true,
            buttonWidth: '100%'
        });
        $('.mybuton').click(function(){
    var ident=$(this).attr("id");
  
   $('.secretInput').val(ident);
  });
  
     function toChangeState(userid,campagneid,comcamid )
        {
          
           
            $.get('addAT.php',{
                userID:userid, campagneID:campagneid, comcamID:comcamid
            },function(data){
                location.reload();
              
            });
            
       

        }
        function sendMail(userid)
        {
            
            $.get('sendMail.php',{
               userID:userid,
            },function(data){
                console.log(data);
              
            });
           
        }
        </script>
       
</body>

</html>