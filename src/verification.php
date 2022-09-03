<?php  

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';


$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.hostinger.fr';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'info@cryptalinvest.com';
$mail->Password = 'bienvenU1@';
$mail->setFrom('info@cryptalinvest.com', 'e-attestation');
$mail->addReplyTo('info@cryptalinvest.com', 'Votre nom');
$mail->addAddress('bienvenuacclombessi8@gmail.com', 'Heros');
$mail->Subject = 'Verification attestation';
$mail->isHTML(true);
$mail->Body = 'This tst';
//$mail->addAttachment('test.txt');
$mail->send();



?>
