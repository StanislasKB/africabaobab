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
if(!$admin)
{
    header('Location:../dashboard/index.php');
}
$req3=$bdd->query('SELECT * FROM campagne');

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
    <title>Gestion de campagne</title>
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
                    <td>Communes</td>
                    <td>Agent du Terrain</td>
                </tr>
                <?php
                $statecolor="";
                $stateMes="";
                while($donnee=$req3->fetch())
                {
                 if($donnee['etat_campagne']==0){$statecolor=" bg-danger"; $stateMes="Fermée";}else{$statecolor=" bg-success";$stateMes="Ouverte";}
                  echo'
                <tr>
                    <td>'.$donnee['titre'].'</td>
                    <td>'.$donnee['edition_campagne'].'</td>
                    
                    <td><a id="'.$donnee['id_campagne'].'" class="btn btn-sm boutton'.$statecolor.'" data-bs-toggle="modal" data-toggle="modal" data-target="#confirmStateModal">'.$stateMes.'</a></td>
                  
                    <td><a id="'.$donnee['id_campagne'].'" class="btn bg-success btn-sm monbouton"  data-bs-toggle="modal" data-bs-target="#communeModal"><span>Ajouter</span></a></td>
                    <td><a href="gestionAT.php?ID='.$donnee['id_campagne'].'" class="btn bg-success btn-sm">Gérer</a></td>

                </tr>';
              }
                ?>
            </table>
                    <!-- Campagne filter table -->
        </div>
        
    
    <!-- Add commune Modal -->
<div class="modal fade" id="communeModal" tabindex="-1" aria-labelledby="communeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="communeModalLabel">Formulaire de communes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="addcommune.php" method="POST">
      <div class="modal-body">
     
        <select class="form-control multiselect-container" name="category[]" id="selectoption" multiple="multiple">
				<option value="Dassa-Zoumé">Dassa-Zoumé</option>
				<option value="Glazoué">Glazoué</option>
				<option value="Savalou">Savalou</option>
				<option value="Natitingou">Natitingou</option>
				<option value="Djougou">Djougou</option>
				<option value="Bantè">Bantè</option>
				<option value="Karimama">Karimama</option>
				<option value="Bassila">Bassila</option>
				<option value="Malanville">Malanville</option>
				<option value="Boukoumbé">Boukoumbé</option>
				<option value="Tanguiéta">Tanguiéta</option>
				<option value="Cobli">Cobli</option>
				<option value="Tchaourou">Tchaourou</option>
				<option value="Savè">Savè</option>
				<option value="Ouessè">Ouessè</option>
				<option value="N’Dali">N’Dali</option>
				<option value="Kandi">Kandi</option>
			</select>
      </div>
      <div class="modal-footer">
        <input type="text" class="d-none secretinput" name="secret">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Valide</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <!-- Add commune Modal -->
    <!-- Confirm for state change -->
    <div class="modal fade" id="confirmStateModal" tabindex="-1" role="dialog" aria-labelledby="confirmStateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmStateModalLabel">Veuillez confirmer votre identité</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="addcommune.php" method="post">
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
              <label for="StatePass">Mot de passe</label>
              <input type="password" name="confirmPass" class="form-control" id="statePass">
        </div>
        </div>
      </div>
      <div class="modal-footer">
      <input type="text" class="d-none secretPassInput" name="secretPass">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="validation">Valider</button>
      </div>
      </form>
    </div>
  </div>
</div>
      <!-- Confirm for state change -->
    
    </main>
    <!-- JS includes -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/bootstrap-multiselect.min.js"></script>
    <!-- JS includes -->
    <script type="text/javascript">
	$('#selectoption').multiselect({
		includeSelectAllOption:true,
		nonSelectedText:'Sélectionner les communes',
		enableFiltering:true,
		buttonWidth:'100%'
	});
  $('.monbouton').click(function(){
    var identifiant=$(this).attr("id");
    $('.secretinput').val(identifiant);
  });
  $('.boutton').click(function(){
    var ident=$(this).attr("id");
    
   $('.secretPassInput').val(ident);
  });
  
  
</script>
</body>

</html>
<?php

//Connexion à la bd


?>