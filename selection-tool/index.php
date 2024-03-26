<?php
    // Start session
    session_start();

    // Include common functions
    include("../common/functions.php");
	
	// started request would be set here despite unsetting
	unset($_SESSION['started-request']);
	
    // Handle form submission
    if (isset($_POST['next'])) {
        // Store all form values in the session for later use
		foreach ($_POST as $key => $value) {
			$_SESSION['info'][$key] = $value;
		}

		// Remove 'next' value from session
		unset($_SESSION['info']['next']);
		// could use this as a way for other pages to display or not
		// like a validation thingy
		// also will use this for the login/signup stuff later


        // Redirect to the next page
        header("Location: furniture-type.php");
        exit; // Stop further execution after redirection
    }
	
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/selection-tool.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <link rel="icon" type="image/x-icon" href="../images/favi.png">


    <!-- Script for responsive navigation -->
    <script src="../javascript/responsive-nav.js"></script>
    <title>Start Building</title>
</head>

<body>
    <!-- Navigation Section -->
    <nav>
        <?php print_nav(); ?>
    </nav>
    <main>
        <div class="container">	
            <div class="dashboard">
                <div class="left-div">
                    <h1></h1>

                    <!-- TODO: FIX THIS LAYOUT OF PAGE ITS BAD -->
                            <form style="width: 75%; margin: 0 auto;" method="post" action="furniture-type.php">
                                <!-- Submit Button -->
                                <input class="btn" style="width: 45%; margin: 0 auto; height: 80px; font-size: 50px;" type="submit" value="Start Here" name="started-request">
                          
                            <!-- TODO: Make it so user can go back from log in to the start -->
                            <!-- TODO: Might want to make these buttons and just in case unset some stuff -->
                            <!-- TODO: Breadcrumbs????? -->
                            <h2 style="font-size: 25px;">Have an Account?</h2>
                            <a href='../login/login.php' style="width: 45%; height: 40px; font-size: 35px; margin: 0 auto;">Login</a>
                            <h2 style="font-size: 25px;"> Or </h2>
                            <a href='../login/signup.php' style="width: 45%; height: 40px; font-size: 35px; margin: 0 auto;">Sign up</a>
                            </form>
                </div>

                <div class="right-div">
                    <image src="../images/logos/bearded-ox.png"></image>
                </div>
            </div>
        </div>


    </main>

    <!-- Footer Section -->
    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
