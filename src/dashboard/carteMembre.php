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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=(device-width), initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Carte</title>
</head>

<body style="font-family: 'Times New Roman';" class="mescarte" >
    <?php
    include('../phpqrcode/qrlib.php');


    ?>
    <div style="margin-left: 150px;">
        <?php
        if (isset($_GET['back'])) {

            $req = $bdd->prepare('SELECT * FROM femmes WHERE nom_regroupement=?');
            $req->execute([htmlspecialchars($_GET['back'])]);
            $nbr = $req->rowCount();
            while ($data = $req->fetch()) {

                $id = $data['matricule'];
                $image = $id . '.png';
                $chemin = '../assets/images/qr/' . $image;
                if (!file_exists($chemin)) {
                    QRcode::png($id, $chemin);
                }
                echo '
        <div class="container p-3 " >
            <div class="row h-50 p-1 px-2 rounded-3" style="background-color: #382c2c; width:80%;">

                <div class="col-md-3 mt-4">
                    <div>
                        <img src="../assets/images/flag.png" alt="" width="100px">
                    </div>
                    <div class="mt-3" style="font-size: 14px;">
                        <div class="h6 text-white">Matricule(ID)</div>
                        <div class="text-danger">' . $data['matricule'] . '</div>
                    </div>
                </div>
                <div class="col-md-5 text-white ">
                    <div class=" mx-4 text-center text-nowrap fw-bold" style="font-size: 15px;">REPUBLIQUE DU BENIN</div>
                    <div class=" text-white mt-3 mx-5 text-center text-nowrap fw-bold" style="font-size: 15px;">Carte de membre</div>
                    <div class="mt-4 mx-2 pt-3 text-justify" style="font-size: 15px;">
                        <div class=""><span class="text-warning pt-1 pb-1">Nom :</span> <span class="text-white">' . $data['nom'] . '</span></div>
                        <div class=""><span class="text-warning">Prénom :</span> <span class="text-white">' . $data['prenom'] . '</span></div>
                        <div class=""><span class="text-warning text-nowrap">Groupement:</span> <span class="text-white">' . $data['nom_regroupement'] . '</span></div>
                    </div>
                </div>
                <div class="col-md-4 mx-0 px-0">
                    <div class="mt-3 mx-4"><img src="../assets/images/logobg.png " width="110px" alt=""></div>
              
                    
                         <div class="pt-5 mx-5  mt-4 pb-3 "><img src="' . $chemin . '"> </div>
                    
                </div>

            </div>
            </div>';
            }
        }
        ?>



    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var element = document.querySelector(".mescarte");
        var str = document.location.href;
        var url = new URL(str);
        var nom ="Carte pour "+ url.searchParams.get("back")
        var opt = {
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'p'
            }
        }
        html2pdf().set(opt).from(element).save(nom);
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>

</html>