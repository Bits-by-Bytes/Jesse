<?php
	session_start();

	// include for nav
	include("../common/functions.php");

	// Handle form submission
	if (isset($_POST['next'])) {
		// Store form values in the session for later use
		foreach ($_POST as $key => $value) {
			$_SESSION['info'][$key] = $value;
		}

		// Remove the 'next' value from the session
		$keys = array_keys($_SESSION['info']);
		if (in_array('next', $keys)) {
			unset($_SESSION['info']['next']);
		}

		// Redirect to the next page
		header("location: epoxy-option-2.php");

		// For testing purposes
		/*
		echo '<pre>';
		print_r($_SESSION['info']);
		echo '</pre>';
		*/
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/selection-tool.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <script src="../javascript/responsive-nav.js"></script>
    <title>Epoxy Style</title>
    <style>ul li {margin-top: 20px;}</style>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="page-container">
            <div class="header-container">
                <div class="title">
                    <h1>Select the epoxy style</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <li>
                            Slim
                            <input type="radio" name="epoxy-style" value="slim" id="cb1" 
                                <?php 
                                if(isset($_SESSION['info']['epoxy-style']) && $_SESSION['info']['epoxy-style'] == 'slim') echo 'checked'; 
                                ?>
                            />
                            <label for="cb1"><img src="../images/furniture-samples/epoxy-option/styles/slim.png" /></label>
                        </li>
                        <li>
                            Whole Table
                            <input type="radio" name="epoxy-style" value="whole-table" id="cb2" 
                                <?php 
                                if(isset($_SESSION['info']['epoxy-style']) && $_SESSION['info']['epoxy-style'] == 'whole-table') echo 'checked'; 
                                ?>
                            />
                            <label for="cb2"><img src="../images/furniture-samples/epoxy-option/styles/whole-table.png" /></label>
                        </li>
                    </ul>

                    <div class="nav-controls">
                        <a href="epoxy-option.php">Previous</a>
                        <input class="btn" type="submit" value="Next" name="next">                    
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
