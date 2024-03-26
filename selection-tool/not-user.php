<?php
	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");
        // get login for acc_type to display user or admin
        if (isset($_SESSION['id'])) {
            $user_data = check_Login($conn);
            $id = $user_data['CUST_ID']; 
            $accountType = $user_data['ACC_TYPE']; 
        } else {
            $accountType = "selection";
        }


            header( "refresh:4;url=../dashboard/../login/signup.php" );
	
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
    <?php 
        print_nav(); 
        print_navTool($accountType); 
     ?>
</nav>

    <main>
        <div class="login-container">
            <div class="login-form">
			
			<h1> In order to continue you must have an account </h1>
			<h2> Sending you to the sign up page </h2>

			</div>
        </div>
    </main>

    <footer>
        <?php print_footer1(); ?>
    </footer>
</body>

</html>