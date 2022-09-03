<?php
session_start();

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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

  <title>AFRICABAOBAB | Inscription</title>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>

<body class="">
  <!-- top navigation bar -->
  <?php include('../dashboard/nav.php'); ?>
  <!-- top navigation bar -->
  <!-- left navigation bar -->
  <?php include('../dashboard/offcanvas.php'); ?>
  </div>
  <!-- left navigation part -->

  <main class="form-signin  border-2 rounded shadow mt-5 pt-5 ">
    <div class="container mt-5 card">
      <form class="" action="signin.php" method="POST">
        
        <?php if (isset($_GET['code'])) {
          if ($_GET['code']) {
            echo '<span class="text-success"> Inscription réussie </span>';
          } else {
            echo '<span class="text-danger"> Informations invalides </span';
          }
        }
        ?>
        <div class="row mt-5 card-body ">
          <div class="col-md-6 mt-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingInputname" placeholder="name@example.com" name="nomAT" required>
              <label for="floatingInputname">Nom</label>
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="inputsurnameAT" name="surnameAT" placeholder="name@example.com" required>
              <label for="inputsurnameAT" class="form-label">Prénom </label>
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-floating">
              <input type="tel" class="form-control" id="inputTel" name="telAT" placeholder="name@example.com" required>
              <label for="inputTel" class="form-label">Contact</label>
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-floating">
              <input type="email" class="form-control" id="inputmailAT" name="mailAT" placeholder="name@example.com" required>
              <label for="inputmailAT" class="form-label">Email</label>
            </div>
          </div>


          <div class="col-md-6 mt-3">
            <div class="form-floating">
              <input type="password" class="form-control" id="inputATpassword" name="ATpassword" placeholder="name@example.com" required>
              <label for="inputATpassword" class="form-label">Mot de Passe</label>
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-floating">
              
              <input type="password" class="form-control" id="inputsecondpassword" name="secondpassword" placeholder="name@example.com" required>
              <label for="inputsecondpassword" class="form-label">Confirmation</label>
            </div>
          </div>

        <?php if(isset($_GET['type'])){echo'<input type="text" class="d-none" name="type_user" value="'.$_GET['type'].'">';}?>

          <button class="w-100 btn btn-lg mt-4 bg-dark text-white" type="submit">Inscrire</button>
        </div>
      </form>
    </div>
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
</body>

</html>