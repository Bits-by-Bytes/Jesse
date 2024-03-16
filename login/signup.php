<?php
	// Debugging mysli was not working
	// the fix: disable the extension_dir
	// https://stackoverflow.com/questions/74253281/git-was-not-found-in-your-path-skipping-source-download
	// https://stackoverflow.com/questions/666811/how-to-solve-fatal-error-class-mysqli-not-found
	//if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
	 //   echo 'We don\'t have mysqli!!!';
	//} else {
	//	echo 'Phew we have it!';
	//}

	// TODO: Fix the two email send cause its annoying

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
 
	// https://stackoverflow.com/questions/74253281/git-was-not-found-in-your-path-skipping-source-download
	// https://www.geeksforgeeks.org/how-to-send-an-email-using-phpmailer/
    // Load Composer's autoloader
    require '../vendor/autoload.php';



	session_start();
	
	include("../common/checkconnection.php");
	include("../common/functions.php");

	$name = $email = $password = $passwordVerify = "";
	$signupError = "";

	$errCount = 0;

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// I dont know what these are doing i forgor
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$passwordVerify = mysqli_real_escape_string($conn, $_POST['passwordVerify']);
		
		$check = "SELECT * FROM login WHERE email = '$email' LIMIT 1";
		$result = mysqli_query($conn, $check);
		
		// All the password stuff
		// validates strong password https://www.codexworld.com/how-to/validate-password-strength-in-php/
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		
		
		// first error checks
		if(!$uppercase || !$lowercase || !$number  || strlen($password) < 8) {
			$signupError = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
			$errCount += 1;
		} elseif ($passwordVerify !== $password) { // if the password verify and password does not match
			$signupError = 'Passwords do not match!';
			$errCount += 1;
		} elseif ($result && mysqli_num_rows($result) > 0) { // Check if the email is already taken
			$signupError = "Email already exists";
			$errCount += 1;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // check for valid email
			$signupError = "Invalid email format";
			$errCount += 1;
		}
		
		
		// if no errors (valid inputs then hash password and send to database)
		if ($errCount == 0) { 
			
			// Php mailer stuffz
		//Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
	 
		
			try {
				//Enable verbose debug output
				$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
	 
				//Send using SMTP
				$mail->isSMTP();
	 
				//Set the SMTP server to send through
				$mail->Host = 'smtp.gmail.com'; // 'smtp.office365.com'; for outlook
	 
				//Enable SMTP authentication
				$mail->SMTPAuth = true;	
				
				//SMTP username
				$mail->Username = 'jesse.vanschothorst@gmail.com';	 
				//SMTP password
				$mail->Password = 'tcfzcsiouqzsnnes';
				
				/* Better for security and stuffz
				Important for later setup/documentation
				Generating an App Password for Gmail:

					Sign in to your Google Account: Go to https://myaccount.google.com/ and sign in with your Gmail email address and password.

					Navigate to Security Settings: Click on "Security" in the left sidebar.

					Enable Two-factor Authentication (if not already enabled): If two-factor authentication is not already enabled, you'll need to enable it. Follow the prompts to set up two-factor authentication for your Google account.

					Generate App Password: Scroll down to the "Signing in to Google" section and click on "App passwords".

					Select App and Device: Choose "Mail" from the dropdown list of apps and select the device you're using (e.g., "Other (Custom name)").

					Generate Password: Click on "Generate" to generate a new app password.

					Copy Password: Copy the generated app password. This is the password you'll use in your PHP script for SMTP authentication with Gmail.

				Generating an App Password for Outlook (Microsoft 365):

					Sign in to your Microsoft Account: Go to https://account.microsoft.com/ and sign in with your Outlook email address and password.

					Navigate to Security Settings: Click on "Security" in the left sidebar.

					Enable Two-factor Authentication (if not already enabled): If two-factor authentication is not already enabled, you'll need to enable it. Follow the prompts to set up two-factor authentication for your Microsoft account.

					Generate App Password: Scroll down to the "Advanced security options" section and click on "Additional security options".

					Create a New App Password: Under "App passwords", click on "Create a new app password".

					Provide Name: Enter a name for the app password (e.g., "PHPMailer") and click "Next".

					Copy Password: Copy the generated app password. This is the password you'll use in your PHP script for SMTP authentication with Outlook.
							
				*/
					 
				//Enable TLS encryption;
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	 
				//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
				$mail->Port = 587;
	 
				//Recipients
				$mail->setFrom('jesse.van_schothorst@lethbridgecollege.ca', 'The Bearded Ox');
	 
				//Add a recipient
				$mail->addAddress($email, 'Valued Customer');
	 
				//Set email format to HTML
				$mail->isHTML(true);
	 
				$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
	 
				$mail->Subject = 'Email verification';
				$mail->Body    = '<p>Your verification code is: \n <b style="font-size: 30px;">' . $verification_code . '</b></p>';
	 
				$mail->send();


				// Hashes Password for security
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				
				// Step 1: Insert into the customer table
				$insert_customer = "INSERT INTO customer (FNAME) VALUES ('$name')";
				mysqli_query($conn, $insert_customer);

				// Step 2: Retrieve the auto-generated CUST_ID
				$cust_id = mysqli_insert_id($conn);

				// Step 3: Insert into the login table with the obtained CUST_ID
				$insert_login = "INSERT INTO login (CUST_ID, EMAIL, PWORD, VERIFY_CODE, VERIFIED_AT, ACC_TYPE) 
								 VALUES ('$cust_id', '$email', '$hashedPassword', '$verification_code', NULL, 'CUST')";
				mysqli_query($conn, $insert_login);


				
				// Once email sends 
				header("Location: email-verification.php?email=" . $email);
				mysqli_close($conn);
				die;


				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
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
		<div class="login-form signup-form">
		  <!-- title -->
		  
		  <form method="post">	
		  <h2>Sign Up</h2><br><br>

		  <?php
		  // possible make it red
				echo $signupError;
			?>
			<input type="text" name="name" placeholder="Name" value="" required>	  
			<input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
			<input type="password" name="password" placeholder="Password" required>
			<input type="password" name="passwordVerify" placeholder="Confirm Password" required><br><br>

			<a href='login.php'>Log in here</a><br><br>
			<input type="submit" value="Sign Up" name='verify_email' class="btn">

			<?php
				// if start request has started		
						
				if (isset($_SESSION['started-request'])){
					echo '<a class="btn" href="../selection-tool/confirmation.php">Back</a>';
				}
			?>	
		  </form>
		</div>
	  </div>		
	</main>
  <footer>
	<?php print_footer();?>
  </footer>
</body>
</html>