<?php  
########################################################
#          FICHIER D'ENVOI DU MESSAGE DE NOTIFICATION  #
########################################################
session_start();
 require('../assets/database.php');
 //Connexion à la base de donnée
 $bdd=seconnecterDb();
use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';
$_GET['userID']=2;
if(isset($_GET['userID']))
{
$requete=$bdd->prepare('SELECT * FROM users WHERE id_user=?');
$requete->execute([htmlspecialchars($_GET['userID'])]);
while($data=$requete->fetch())
{
    $email=$data['email'];
    $pass="AB@".$data['tel'].$data['prenom'];
    $nom=$data['nom'];
}
$body='<div><img src="../assets/images/logo.png" width="100px"></div><br>
<div style="font-size:17px; font-family:"Times New Roman";">Monsieur <span style="font-weight:bold;">'.$nom.'</span>'.'<div> Vous avez été inscrit à la plateforme du projet <span style="font-weight:bold;">AFRICABAOBAB </span></div>
     <div>Voici vos identifiants de connexion :</div>
     <div><span style="font-weight:bold;">Email :</span> '.$email.
     '</div><div><span style="font-weight:bold;">Mot de passe:</span> '.$pass.'</div></div>';


$mail = new PHPMailer;
 $mail->isSMTP();
 $mail->SMTPDebug = 2;
 $mail->Host = 'smtp.hostinger.fr';
 $mail->Port = 587;
 $mail->SMTPAuth = true;
 $mail->Username = 'info@cryptalinvest.com';
 $mail->Password = 'bienvenU1@';
 $mail->setFrom('info@cryptalinvest.com', 'e-attestation');
 //$mail->addReplyTo('info@cryptalinvest.com', 'Votre nom');
 $mail->addAddress('stanislasbayord200@gmail.com', 'Heros');
 $mail->Subject = 'Verification attestation';
 $mail->isHTML(true);
 $mail->Body = $body;
 //$mail->addAttachment('test.txt');
 if($mail->send())
 {
     echo 'ok';
 }
 }


?>
