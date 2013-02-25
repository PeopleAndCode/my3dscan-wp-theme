<?php

$mail_to = "hola@peopleandcode.com, info@draftprint3d.com";
$mail_subject = "3D Scanned Image by My3DScan.ca ";

$mail_message	= "<p>Hi, you've received a message via the My3DScan.ca Web Form. Here are the details:</p>";
$mail_message	.= "<p><b>Name: </b>" . $_POST["fname"] . "</p>";
$mail_message	.= "<p><b>Email: </b>" . $_POST["femail"] . "</p>";
$mail_message	.= "<p><b>Twitter: </b>" . $_POST["fphone"] . "</p>";
$mail_message	.= "<p><b>Scan Number: </b>" . $_POST["findustry"] . "</p>";

$mail_headers	= "MIME-Version: 1.0" . "\r\n";
$mail_headers	.= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$mail_headers	.= "From: noreply@my3dscan.ca" . "\r\n";
$mail_headers	.= "Reply-To: noreply@my3dscan.ca" . "\r\n";
$mail_headers	.= "X-Mailer: PHP/" . phpversion();

@wp_mail($mail_to, $mail_subject, $mail_message, $mail_headers);
unset($mail_to, $mail_subject, $mail_message, $mail_headers);

?>