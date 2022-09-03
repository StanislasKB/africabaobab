<?php
session_start();
require "../assets/database.php";
$bdd=seconnecterDb();
$connecte=false;
$connecteAs=false;
if(isset($_SESSION['id']))
{
$connecte=true;
}elseif(isset($_SESSION['id_assistant']))
{
	$connecteAs=true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	
	<link rel="stylesheet" href="../assets/fontawesome/css/all.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	<link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/css/style.css" />

	<title>AfricaBaobab | Accueil</title>
</head>

<body> 
	<nav class="cc-navbar navbar navbar-expand-lg navbar-dark position-fixed w-100">
		<div class="container-fluid">
			<a class="navbar-brand mx-4 py-3 fw-bolder logo" href="#"><img src="../assets/images/logobg.png" class="imag" alt=""></a>
			<button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item pe-4">
						<a class="nav-link active" aria-current="page" href="#">Accueil</a>
					</li>
					 <!-- <li class="nav-item pe-4">
						<a class="nav-link" href="#">Blog</a>
					</li>  -->
					<?php
					if($connecte)
					{
					echo'
					<li class="nav-item pe-4">
						<a class="nav-link" href="../dashboard/index.php">Tableau de bord</a>
					</li>';}elseif($connecteAs)
					{
						echo'
					<li class="nav-item pe-4">
						<a class="nav-link" href="../dashboard/recensementAssistant.php">Tableau de bord</a>
					</li>';
					}
					?>
					<li class="nav-item pe-4">
						<?php
						if(!$connecte AND !$connecteAs)
						{
							echo'
						<a class="btn btn-order rounded-0" href="../login/index.php">Se connecter</a>';
						}elseif($connecte){echo'
						<ul class="navbar-nav d-flex justify-content-end" >
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user fa-1x"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../profil/index.php">Profil</a></li>
                            <li><a class="dropdown-item" href="../logout/index.php">Se déconnecter</a></li>
                        </ul>';}elseif($connecteAs)
						{
							echo'
						<ul class="navbar-nav d-flex justify-content-end" >
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user fa-1x"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../profil/profilAssistant.php">Profil</a></li>
                            <li><a class="dropdown-item" href="../logout/index.php">Se déconnecter</a></li>
                        </ul>';
						}
						?>
                    </li>
                </ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<section class="banner d-flex justify-content-center align-items-center pt-5">
		<div class="container my-5 py-5">
			<div class="row">
				<div class="col-md-6"></div>
				<div class="col-md-6 banner-desc lh-lg">
					<h1 class="text-capitalize py-3 redressed">
						La femme rurale<br />
						au coeur du processus de développement et de création de richesse
					</h1>
					<p>
						<?php
						if(!$connecte and !$connecteAs)
						{
						echo '
						<a class="btn btn-order btn-lg me-5 rounded-0 merriweather" href="../login/index.php">Se connecter</a>';
			
						}	?>
						</p>
				</div>
			</div>
		</div>
	</section>
	<section class="cc-carousel merriweather text-light text-center py-5 mt-5">
		<div class="container">
			<div class="row bg-dark shadow rounded">
				<h1 class="text-uppercase ">AfricaBaobab</h1>
				<div class="col pb-4">
				Un projet socio-économique qui vise à autonomiser les femmes rurales à travers les activités liées à la cueillette, à la
				 collecte et à la valorisation des fruits de baobab. 
				</div>
			</div>

			<div class="row ">
			<div class="owl-carousel owl-theme">
    <div class="item">
				<div class=" mx-5 pb-5 pt-5 border-3 mt-5 shadow text-dark card  fw-bold " style="border-radius: 25px; background-color:yellow; height:350px;">
					<div class="mx-5 px-0" style="position:relative; left: 75px; "><img src="../assets/images/icons/statistique.png" alt="" class="p-2" style="width: 26%; border:2px solid black; border-radius:25px;"></div>
					<div class="card-body mt-5">
					<div class=" fw-bold fs-6">+<?php $req=$bdd->query('SELECT * FROM femmes');  $nbr=$req->rowCount(); echo $nbr;?> femmes touchées par le projet</div>
					</div>
					
				</div>
				</div>
    <div class="item">
				<div class=" mx-5 pb-5 pt-5 border-3 mt-5 shadow text-dark card   fw-bold " style="border-radius: 25px; background-color:yellow; height:350px;">
					<div class="mx-5 px-0" style="position:relative; left: 75px; "><img src="../assets/images/icons/megaphone.png" alt="" class="p-2" style="width: 26%; border:2px solid black; border-radius:25px;"></div>
					<div class="card-body mt-5">
					<div class="fw-bold fs-6">Mener une large sensibilisation sur le rôle des femmes dans tous les domaines et sphères allant dans le cadre de la protection et d’aménagement de l’environnement</div>
					</div>
					
				</div>
				</div>
    <div class="item">
				<div class=" mx-5 pb-5 pt-5 border-3 mt-5 shadow text-dark card   fw-bold " style="border-radius: 25px; background-color:yellow; height:350px;">
					<div class="mx-5 px-0" style="position:relative; left: 75px; "><img src="../assets/images/icons/globalisation.png" alt="" class="p-2" style="width: 26%; border:2px solid black; border-radius:25px;"></div>
					<div class="card-body mt-5">
					<div class="fw-bold fs-6">Mettre les femmes rurales aux cœurs du processus de créations de richesses à travers la valorisation des ressources naturels : le baobab   </div>
					</div>
					
				</div>
				</div>
    <div class="item">
				<div class=" mx-5 pb-5 pt-5 border-3 mt-5 shadow text-dark card   fw-bold " style="border-radius: 25px; background-color:yellow; height:350px;">
					<div class="mx-5 px-0" style="position:relative; left: 75px; "><img src="../assets/images/icons/femme.png" alt="" class="p-1" style="width: 26%; border:2px solid black; border-radius:25px;"></div>
					<div class="card-body mt-5">
					<div class="fw-bold fs-6">Renforcer le rôle, l’émancipation ainsi que l’épanouissement des femmes endroit lignes avec les objectifs de développement durable   </div>
					</div>
					
				</div>
				</div>
    <div class="item">
				<div class=" mx-5 pb-5 pt-5 border-3 mt-5 shadow text-dark card   fw-bold " style="border-radius: 25px; background-color:yellow; height:350px;">
					<div class="mx-5 px-0" style="position:relative; left: 75px; "><img src="../assets/images/icons/amelioration.png" alt="" class="p-2" style="width: 26%; border:2px solid black; border-radius:25px;"></div>
					<div class="card-body mt-5">
					<div class="fw-bold fs-6">Améliorer la situation culturel et socio-économique des femmes   </div>
					</div>
					
				</div>
				</div>
   
   
</div >     
			</div>
			
			
		</div>
	</section>
	<section class="available merriweather py-5">
		<div class="container">
			<div class="row">
				<div class="card mb-3 border-0 rounded-0">
					<div class="row">
						<div class="col-md-6">
							<img src="../assets/images/carte1.jpeg" class="img-fluid" alt="..." />
						</div>
						<div class="col-md-6">
							<div class="card-body px-0">
								<h3 class="card-title text-center fw-bold">Remise de carte de membre dans la commune de Dassa</h3>
								<p class="card-text text-center">
									Dans la cadre de la campagne AFRICA BAOBAB 2022 les femmes des différents groupements de la 
									commune de Dassa ont reçu main à main leur carte membre de l'organisation. L'évènement a été immortalisé avec des images comme celle-ci contr.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="card my-5 border-0 rounded-0">
					<div class="row">
						<div class="col-md-6">
							<div class="card-body px-0">
								<h3 class="card-title text-center fw-bold">Tournée de formation</h3>
								<p class="card-text text-center">
								Dans le cadre de l’exécution du projet AFRICA BAOBAB, des séances de sensibilisations
								 et de formations, ont été organisées  à l’endroits des femmes défavoriser des milieux ruraux sur l’importance et sur les technique d’aménagement de l’environnement
								   afin de contribuer à la pérennisation de la filières  baobab. <br>
								   Les formations ont été organisées dans les communes de Djougou,.. pour le compte de la première édition de la campagne.
								</p>
							</div>
						</div>
						<div class="col-md-6">
							<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<img src="../assets/images/Carousel/carousel.jpeg" class="d-block w-100" alt="..." />
									</div>
									<div class="carousel-item">
										<img src="../assets/images/Carousel/carousel1.jpeg" class="d-block w-100" alt="..." />
									</div>
									<div class="carousel-item">
										<img src="../assets/images/Carousel/carousel2.jpeg" class="d-block w-100" alt="..." />
									</div>
									<div class="carousel-item">
										<img src="../assets/images/Carousel/carousel3.jpeg" class="d-block w-100" alt="..." />
									</div>
								</div>
								<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</button>
								<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="card mb-3 border-0 rounded-0">
					<div class="row">
						<div class="col-md-6">
							<img src="../assets/images/other/sac.jpeg" class="img-fluid" alt="..." />
						</div>
						<div class="col-md-6">
							<div class="card-body px-0">
								<h3 class="card-title text-center fw-bold">Remise de sac</h3>
								<p class="card-text text-center">
									Pour l'éxécution du projet, les femmes sont accompagnées avec du matériel, outil et équipement pouvant faciliter les 
									travaux de cueillette et de collecte des fruits de baobab.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cc-menu  py-5">
		<div class="container">
			<div class="row">
				<h3 class="text-center text-light fw-bold">AFRICA BAOBAB</h3>
				<div class="card bg-transparent text-center mb-4">
					<div class="card-header redressed fs-4">

					</div>
					
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-2 g-4">
				<div class="col">
					<div class="card">
						<img src="../assets/images/carte2.jpeg" class="card-img-top" alt="..." />
						<div class="card-body">
							<h5 class="card-title">Remise des cartes de membre aux femmes de la commune de  </h5>
							<!-- <p class="card-text">
								This is a longer card with supporting text below as a natural lead-in to additional content. This
								content is a little bit longer.
							</p> -->
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<img src="../assets/images/carte3.jpeg" class="card-img-top" alt="..." />
						<div class="card-body">
							<h5 class="card-title">Remise des cartes de membre aux femmes de la commune de </h5>
							<!-- <p class="card-text">
								This is a longer card with supporting text below as a natural lead-in to additional content. This
								content is a little bit longer.
							</p> -->
						</div>
					</div>
				</div>

				
			</div>
		</div>
	</section>

	

	<section class="cc-footer py-5 bg-dark text-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 mb-4 col-sm">
					<div class="h1 mt-4">AfricaBaobab</div>
				</div>
				<div class="col-lg-3 col-md-6 mb-4 col-sm">
					<h6 class="redressed ps-3 fs-5">Nos Partenaire</h6>
					<nav class="nav flex-column">
						<a class="nav-link py-1 merriweather fs-6 text-secondary active" aria-current="page" href="#">Active</a>
						<a class="nav-link py-1 merriweather fs-6 text-secondary" href="#">Link</a>
						<a class="nav-link py-1 merriweather fs-6 text-secondary" href="#">Link</a>
						<a class="nav-link py-1 merriweather fs-6 text-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
					</nav>
				</div>
				<div class="col-lg-3 col-md-6 mb-4 col-sm">
					<h6 class="redressed ps-3 fs-5">Contact</h6>
					<nav class="nav flex-column">
						<a class="nav-link py-1 fs-6 text-white" ><i class="fa-solid fa-phone"></i> +229XXXXXXXX</a>
						<a class="nav-link py-1 merriweather fs-6 text-white"><i class="fa-brands fa-whatsapp"></i> +229XXXXXXXX</a>
						<a class="nav-link py-1 merriweather fs-6 text-white" href="mailto:stanislasbayord200@gmail.com"><i class="fa-solid fa-envelope"></i> example@gmail.com</a>
						
					</nav>
				</div>
				
				<div class="col-12 text-center py-4 text-muted">
					&copy; AfricaBaobab
					<script>
						document.write(new Date().getFullYear());
					</script>
					Copyright
				</div>
			</div>
		</div>
	</section>
	<script src="../assets/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/script.js"></script>
	<script defer src="../assets/fontawesome/js/all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$('.owl-carousel').owlCarousel({
    loop:true,
    margin:40,
	autoplay: true,
    nav:true,
	navText:["<",">"],
    responsive:{
        0:{
            items:1
        },
        540:{
            items:1
        },
		720:{
            items:1
        },
		960:{
            items:2
        },
        1200:{
            items:3
        }
    }
});
</script>
</body>

</html>