<?php

include("../common/checkconnection.php");
include("../common/functions.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require '../vendor/autoload.php';

$emailSent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if email is provided
    if (!empty($_POST["email"])) {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);

        // Check if the email exists in the database
        $sql = "SELECT * FROM login WHERE EMAIL = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Generate a unique token for password reset
            $token = bin2hex(random_bytes(32));

            // Update the user's record with the token
            $updateTokenQuery = "UPDATE login SET RESET_TOKEN = '$token' WHERE EMAIL = '$email'";
            $updateResult = mysqli_query($conn, $updateTokenQuery);

            if ($updateResult) {
                // Create a new PHPMailer instance
                $mail = new PHPMailer(true);

                try {
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
                    $mail->Body = "Dear User,<br><br>Please click the following link to reset your password:<br><a href='http://172.22.2.83/login/reset-pass.php?token=$token'>
					Reset Password</a><br><br>Regards,<br>Your Website Team";

                    // Send email
                    $mail->send();

                    $emailSent = true;

                    
                } catch (Exception $e) {
                    $error = "Failed to send password reset email. Error: " . $mail->ErrorInfo;
                }
            } else {
                $error = "Failed to update reset token. Please try again later.";
            }
        } else {
            $error = "No account found with that email address.";
        }
    } else {
        $error = "Please provide your email address.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <script src="../javascript/responsive-nav.js"></script>
</head>
<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="login-container">
            <div class="login-form">
                <h2>Forgot Password</h2>
                
                <?php if ($emailSent): ?>
                    <p>Password reset instructions have been sent to your email address.</p></br>
					<a href="../login/login.php" class="btn">Back to Login</a>

                <?php else: ?>
                    <form method="POST" action="reset-request.php" >
                        <?php if (!empty($error)): ?>
                            <p style="color: red;"><?php echo $error; ?></p>
                        <?php endif; ?>
                        
                        <input type="email" name="email" placeholder="Email" required /></br>
                        <a href="../login/login.php" class="btn">Back to Login</a>
                        <input type="submit" value="resetPassword" class="btn" />

                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>
