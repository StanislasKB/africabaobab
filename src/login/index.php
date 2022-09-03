<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/signin.css">
    <title>AFRICABAOBAB | Connexion</title>

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

  <body class="text-center mt-5 p-4">
    
<main class="form-login bg-dark border-2 rounded shadow p-4 ">
  <form action="login.php" method="POST" class="mt-5">
    <a href="../accueil/index.php"><img class="" src="../assets/images/logobg.png" alt="" width="115" height="100"></a>
    <h1 class="h3 fw-normal" style="color: #D50011;">Connexion</h1>
      <?php if(isset($_GET['code']) AND $_GET['code']==false)
              {
                echo '<span class="text-danger"> Informations incorrectes </span>';
              }
              if(isset($_GET['etat']) AND $_GET['etat']==true)
              {
                echo '<span class="text-danger">Vous avez été bloqué</span>';
              }
      ?>
    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="loginmail">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control mt-3" id="floatingPassword" placeholder="mot de passe" name="loginpass">
      <label for="floatingPassword">Mot de Passe</label>
    </div>
    <input type="checkbox" name="choixConnexion" value="A" id="check">
    <label for="check" class="text-white mb-2"> Se connecter en tant que assistant</label>
    <button class="w-100 btn btn-lg" type="submit" style="background-color:yellow;">Se connecter</button>
     
  </form>
</main>


    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>