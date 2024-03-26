<?php
	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");

	$loginError = '';

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// Something was posted
		// I thought I was gonna need to do something else w/ POST
		// but it works for some reason
			
			$email = $_POST["email"];
			$password = $_POST["password"];
			
			// Check if email is found and verified
			$sql = "SELECT * FROM login WHERE email = '" . $email . "'";
			$result = mysqli_query($conn, $sql);

			// check if email even exists
			if (!$result || mysqli_num_rows($result) == 0) 
			{
				$loginError = 'No Account with that Email.';
			}			
			else 
			{
				$user_data = mysqli_fetch_assoc($result);
				
				if(password_verify($password, $user_data['PWORD']))
				{
										
					if ($user_data['VERIFIED_AT'] == null) {
						echo 'You need to be verified';
						header("Location: email-verification.php?email=" . $user_data['EMAIL']);
					} else {
						$_SESSION['id'] = $user_data['CUST_ID'];
						
						if (isset($_SESSION['started-request'])){
							header("Location: ../selection-tool/confirm-send.php");
						}else {
							header("Location: ../dashboard/dashboard.php");
						}
					}

				} 
				else 
				{
					$loginError = 'Not Valid Password!';
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
	<link rel="icon" type="image/x-icon" href="../images/favi.png">

    <script src="../javascript/responsive-nav.js"></script>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="login-container">
		
            <div class="login-form">		
            <title>Login</title>
				<?php 
if (isset($_SESSION['started-request'])){
    echo '<a class="btn" style="float: left;" href="../selection-tool/confirmation.php"><</a>';
} else {
    echo '<a class="btn" style="float: left;" href="../selection-tool/index.php">&lt;</a><br>';
}
?>
<br>

                <h2>Login</h2><br>
                <form method="POST">
					<!-- Maybe make red for UI -->
					<?php echo $loginError ?>
					
                    <input type="text" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required /><br>
                    <a href="signup.php">Sign up here</a> &nbsp;&nbsp;&nbsp;<a href='forgot-password.php'>Forgot Password?</a>
					
					<br><br>
                    <input style="width: 85%" type="submit" name="user" value="Login" class="btn"><br><br>
                </form>
				
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
