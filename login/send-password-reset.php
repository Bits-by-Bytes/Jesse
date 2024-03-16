<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require '../vendor/autoload.php';

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require "../common/database.php";

$sql = "UPDATE login
        SET RESET_TOKEN = ?,
            RESET_TOKEN_EXP = ?
        WHERE EMAIL = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = new PHPMailer(true);

//Server settings
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

// 
// the stuff i used for other php mailer

//SMTP username
$mail->Username = 'jesse.vanschothorst@gmail.com';	 
//SMTP password
$mail->Password = 'tcfzcsiouqzsnnes';

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;


//Recipients
$mail->setFrom('jesse.van_schothorst@lethbridgecollege.ca', 'The Bearded Ox');

//Add a recipient
$mail->addAddress($email, 'Valued Customer');

//Content
$mail->isHTML(true);
$mail->Subject = 'Password Reset Request';
$mail->Body = "Dear User,<br><br>Please click the following link to reset your password:<br><a href='http://172.22.2.83/login/reset-password.php?token=$token'>
Reset Password</a><br><br>Regards,<br>Your Website Team";

// Send email
$mail->send();


}


echo "Message sent, please check your inbox.";