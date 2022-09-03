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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Fiche Recensement</title>
    <style>
        body{
            font-family: "Times New Roman";
        }
        table {
            border-collapse: collapse;
            text-align: center;
        }
        td, th {
            border: 1px solid black;
        }
        .table_1 {
            margin-top: 30px;
            margin-left: 120px;
            margin-right: 40px;
            font-size: 15px;
        }
        .fiche
        {
            margin-left: -50px;
        }
        
    </style>
</head>
<body>
    <div class="fiche">
        <div class="container-fluid">
        <div class="row mx-5">
        <div class=" col-md-4  mt-4">
    <img class="mx-5" src="../assets/images/logo.png" width="150px">
</div>
       
            <div class="col-md-5 mt-4 text-center " >
    <div class="h6  fw-bold w-100  ">Fiche de collecte d'information pour le compte de la campagne national de collecte
des pulpes de baobab <span class="text-center">AFRICA BAOBAB </span></div>
</div>
<div class="col-md-3  mt-3">
                <?php
                
                 include('../phpqrcode/qrlib.php');
                 $requete=$bdd->prepare('SELECT nom,prenom FROM users WHERE id_user=?');
                 $requete->execute([$_SESSION['id']]);
                 while($donnee=$requete->fetch())
                 {
                    $numero=date("U");
                  $nom=$donnee['nom'];
                  $prenom=$donnee['prenom'];
                  $image = $numero. '.png';
                  $info='Exporter le '.date("d-n-Y").' par '.$nom.' '.$prenom;
                  $chemin = '../assets/images/ficheQr/' . $image;
                  if (!file_exists($chemin)) {
                    
                    QRcode::png($info.' '.$numero, $chemin);
                    $requete2=$bdd->prepare('INSERT INTO fiche(numero,id_user,date_exportation)
                    VALUES(?,?,CURDATE())');
                    $requete2->execute([$numero,$_SESSION['id']]);}
                    echo '<img src="../assets/images/ficheQr/'.$image.'" width="100px" style="position:relative; margin-left:130px;">';
                 }
                
                 $requete->closeCursor();
                
               
                 
                
                
                ?>
            </div>
</div>
</div>
<div class="mx-4 px-5 text-justify mt-2" style="position: relative; right: -50px;">
    <?php
    if(isset($_GET['back']))
    {
    $req=$bdd->prepare('SELECT commune, village, nom_regroupement, date_recensement FROM femmes WHERE nom_regroupement=? GROUP BY nom_regroupement LIMIT 1');
    $req->execute([htmlspecialchars($_GET['back'])]);
    while($data=$req->fetch())
    {echo'
   <div> <span class="text-decoration-underline fw-bold">Commune :</span> '.$data['commune'].'</div>
   <div> <span class="text-decoration-underline fw-bold">Village :</span> '.$data['village'].'</div>
   <div> <span class="text-decoration-underline fw-bold">Nom du groupement :</span> '.$data['nom_regroupement'].'</div>
   <div> <span class="text-decoration-underline fw-bold">Date :</span> '.date("d/m/Y").'</div>';}}
   ?>
</div>
    <div class="table_1 px-1">
        <table style="width: 96%;">
            <tr>
            <th></th>
                <th class="p-1">Matricule</th>
                <th class="p-1">Nom</th>
                <th class="p-1">Prénom</th>
                <th class="p-1" style="width: 50px;" >Capacité de collecte(sac)</th>
                <th class="p-1">Numéro de téléphone</th>
                <th class="p-1">Activités</th>
                <th class="p-1">Age</th>
                <th class="p-1">Situation Matrimoniale</th>
                <th class="p-1">Statut</th>
                <th class="p-1">Observation</th>
                <th></th>
               
            </tr>
            <?php 
            $req=$bdd->prepare('SELECT * FROM femmes WHERE nom_regroupement=?');
            $req->execute([htmlspecialchars($_GET['back'])]);
            while($data=$req->fetch())
            {
                echo'<tr>
                <td class="p-1"><img src="../assets/images/femme/'.$data['photo'].'" width="40px" style="border-radius:5px;"></td>
                <td class="p-1">'.$data['matricule'].'</td>
                <td class="p-1">'.$data['nom'].'</td>
                <td class="p-1">'.$data['prenom'].'</td>
                <td class="p-1">'.$data['capacite'].'</td>
                <td class="p-1">'.$data['telephone'].'</td>
                <td class="p-1">'.$data['activite'].'</td>
                <td class="p-1">'.$data['age'].' ans</td>
                <td class="p-1">'.$data['stmatrimoniale'].'</td>
                <td class="p-1">'.$data['statut'].'</td>
                <td class="p-1">'.$data['observations'].'</td>
                <td style="width: 75px;" ></td>
                
            </tr> ';}
            ?>           
        </table>
        <div class="mt-2  text-justify ">
            <div class="row">
            <div class="col-md-5">
        <div> <span class="text-decoration-underline fw-bold">Bureau du Regroupement:</span></div>
   <div> <span class="text-decoration-underline fw-bold">La Présidente :</span> 
   <?php 
   
  

   
  

            $req=$bdd->prepare('SELECT * FROM femmes WHERE nom_regroupement=? AND statut="Présidente"');
            $req->execute([htmlspecialchars($_GET['back'])]);
            while($data=$req->fetch())
            {
                echo $data['nom']." ".$data['prenom'];
            }
            ?></div>
   <div> <span class="text-decoration-underline fw-bold">La Sécrétaire :</span> 
   <?php 
            $req=$bdd->prepare('SELECT * FROM femmes WHERE nom_regroupement=? AND statut="Sécrétaire"');
            $req->execute([htmlspecialchars($_GET['back'])]);
            while($data=$req->fetch())
            {
                echo $data['nom']." ".$data['prenom'];
            }
            ?></div>
   <div> <span class="text-decoration-underline fw-bold">L'organisatrice :</span> 
   <?php 
            $req=$bdd->prepare('SELECT * FROM femmes WHERE nom_regroupement=? AND statut="Organisatrice"');
            $req->execute([htmlspecialchars($_GET['back'])]);
            while($data=$req->fetch())
            {
                echo $data['nom']." ".$data['prenom'];
            }
            ?></div>
            </div>
            
        </div>
        
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script>
            var element = document.querySelector(".fiche");
            var str = document.location.href;
            var url = new URL(str);
            var nom="fiche de " + url.searchParams.get("back")
            var opt = {
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'l'
                }
            }
            html2pdf().set(opt).from(element).save(nom);
 
    </script>           
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  
</body>
</html>
