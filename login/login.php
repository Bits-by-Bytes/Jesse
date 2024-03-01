<?php
	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");
	
	$isAGuest = false;

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// Something was posted
		// I thought I was gonna need to do something else w/ POST
		// but it works for some reason
		if (!(empty($_POST["email"])) && !(empty($_POST["email"]))) 
		{
			$email = $_POST["email"];
			$password = $_POST["password"];

			// Check if email is found and verified
			$sql = "SELECT * FROM login WHERE email = '" . $email . "'";
			$result = mysqli_query($conn, $sql);

			// check if email even exists
			if (!$result || mysqli_num_rows($result) == 0) 
			{
				echo("No Account with that Email.");
			} 
			else 
			{
				
				$user_data = mysqli_fetch_assoc($result);
				
				if(password_verify($password, $user_data['PWORD']))
				{
					$_SESSION['id'] = $user_data['CUST_ID'];			
				} 
				else 
				{
					echo 'Passwords do not match';
				}
			}
		}
			else 
			{
				$isAGuest = true;
			}
			
			// Redirect to dashboard if login successful
			// if new user redirect to account managment?
			// if else admin to admin.php
			// else account managment to setup user details
				
			if ($user_data['ACC_TYPE'] === 'just-created-user') 
			{
				// replace when done user managment
				header("Location: ../dashboard/stub-user-managment.php");
			} 
			elseif ($user_data['ACC_TYPE'] === 'admin') 
			{
				header("Location: ../dashboard/stub-admin-dash.php");
			} 
			elseif ($isAGuest) 
			{
				header("Location: ../selection-tool/furniture-type.php");
			} 
			else 
			{
				header("Location: ../dashboard/index.php");
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
                <!-- Title -->
                <h2>Login</h2>
                <form method="POST">
                    <input type="text" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required />
                    <a href="signup.php">Sign up here</a> &nbsp;&nbsp;&nbsp;<a href='#'>Forgot Password?</a><br><br>
                    <input type="submit" value="Submit" class="btn">
                </form>
            </div>
            <div class="guest-checkout">
				<form method="POST">
				
                <h1>Check Out As Guest</h1>
				<input type="text" name="guest" value="guest" hidden/>
				
                <input type="submit" value="Start Request" class="btn">
				
				</form>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
