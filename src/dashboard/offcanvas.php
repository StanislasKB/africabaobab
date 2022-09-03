<?php

//Connexion à la bd
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

<div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <a href="../dashboard/index.php" class="nav-link px-3 active">
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
                <?php
                if(!$admin)
                {
                echo'
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-person-plus"></i></span>
                            <span data-toggle="modal" data-target="#assistModal">Inscrire un assistant</span>
                        </a>
                    </li>
                    <li>
                        <a href="../dashboard/ATcampagnepannel.php" class="nav-link px-3">
                            <span class="me-2"><i class="fa-solid fa-calendar-days"></i></span>
                            <span >Mes campagnes</span>
                        </a>
                    </li>
                    <li>
                        <a href="../dashboard/assistants.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-person"></i></span>
                            <span >Mes assistants</span>
                        </a>
                    </li>';
                } 
                  ?> 
                  <?php
                  if($admin)
                  {
                  echo '
                    <li>
                        <a href="../signin/index.php" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-person-plus"></i></span>
                            <span>Inscrire un agent </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="fa-solid fa-calendar-plus"></i></span>
                            <span data-bs-toggle="modal" data-bs-target="#initierModal">Initier une campagne </span>
                        </a>
                    </li>
                    <li>
                        <a href="../dashboard/campagne.php" class="nav-link px-3">
                            <span class="me-2"><i class="fa-solid fa-calendar-days"></i></span>
                            <span>Gestion de campagne </span>
                        </a>
                    </li>';
                }

                    ?>
                   <?php if($admin)
                   {echo '<li>
                        <a href="../dashboard/archive.php" class="nav-link px-3">
                            <span class="me-2"><i class="fa-solid fa-book-open"></i></span>
                            <span>Exportation</span>
                        </a>
                    </li>
                    <li>
                        <a href="../signin/index.php?type=1" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-person-plus"></i></span>
                            <span>Inscrire un Admin</span>
                        </a>
                    </li>
                    '; }?>
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
         
         <!-- initiating a campaign modal -->
         <div class="modal fade" id="initierModal" tabindex="-1" aria-labelledby="initierModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="initierEModalLabel">Formulaire de campagne</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form  method="post" action="gestioncampagneBack.php">
                    <div class="modal-body">
                        
                            <div class="row">
                            <div class="col-md-6">
                                <label for="inputnomWoman" class="form-label">Edition de la Campagne</label>
                                <input type="text" class="form-control" id="inputnomWoman" name="campagneEdit" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputsurnameWoman" class="form-label">Titre de la Campagne</label>
                                <input type="text" class="form-control" id="inputsurnameWoman" name="campagneTitre">
                            </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Initier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- initiating a campaign modal -->
<!-- Add Assistant Modal-->
 
<div class="modal fade" id="assistModal" tabindex="-1" role="dialog" aria-labelledby="assistModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assistModalLabel">Formulaire d'Inscription d'assistant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../signin/signin.php" method="post">
      <div class="modal-body">
        <div class="row">
      <div class="col-md-6">
            <label for="nomAssist">Nom</label>
            <input type="text" id="nomAssist" name="nomAssist" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="prenomAssist">Prénom</label>
            <input type="text" id="prenomAssist" name="prenomAssist" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="mailAssist">email</label>
            <input type="email" id="mailAssist" name="mailAssist" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="mailAssist">Contact</label>
            <input type="tel" id="telAssist" name="telAssist" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="passAssist">Mot de passe</label>
            <input type="password" id="passAssist" name="passAssist" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="confAssist">Confirmation</label>
            <input type="password" id="confAssist" name="passAgain" class="form-control" required>
        </div>
        </div>
      </div>
      <div class="modal-footer">
      <?php echo '<input type="text" class="d-none secretuserID" name="userID" value="'.$_SESSION['id'].'">'; ?>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>
   <!-- Add Assistant Modal-->