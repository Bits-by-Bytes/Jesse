<?php
	// Start session
	session_start();

	// Include common functions
	include("../common/functions.php");

	// Handle form submission
	if (isset($_POST['request-start'])) {
		$_SESSION['started-request'] = $_POST['request-start'];
		// Store form values in session for later use
		foreach ($_POST as $key => $value) {
			$_SESSION['info'][$key] = $value;
		}

		// Remove 'next' value from session
		unset($_SESSION['info']['next']);

		// Redirect based on furniture type
		if ($_SESSION['info']['furniture-type'] == 'table') {
			header("location: wood-type.php");
		} else {
			// Unset specific table options if not a table
			unset($_SESSION['info']['table-shape-opt']);
			header("location: wood-type.php");
		}

		// For testing purposes
		// echo '<pre>';
		// print_r ($_SESSION['info']);
		// echo '</pre>';
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
	<title>Furniture Type</title>

	<style>
ul li {
	margin-top: 20px;}


	</style>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="page-container">

            <div class="header-container">
                <div class="title">
                    <h1>Please Select the type of furniture you want: </h1>
                </div>
				
            </div>

			<!-- whoever tried thanks but it should say if id go to dash if not then go to index which is done up in php <3 -->
			<?php exit_selection(); ?><br>

			<div class="selection-tool-container"  >		
				<form action='' method="POST" >
					
					<!-- TODO: Add to all selection screen in case they want to leave -->
					
					<ul >
						<!-- Radio buttons for furniture type selection -->
						<li >
							Table
							<input type="radio" name="furniture-type" value="table" id="cb1" 
								<?php 
								if(isset($_SESSION['info']['furniture-type']) && ($_SESSION['info']['furniture-type']) == 'table') echo 'checked'; 
								?>
							/>
							<label for="cb1"><img src="../images/furniture-samples/furniture-type/table.png" /></label>
						</li>
						<li>
							Chair
							<input type="radio" name="furniture-type" value="chair" id="cb2" 
								<?php if(isset($_SESSION['info']['furniture-type']) && ($_SESSION['info']['furniture-type']) == 'chair') echo 'checked'; ?>
							/>
							<label for="cb2"><img src="../images/furniture-samples/furniture-type/chair.png" /></label>
						</li>
						<li>
							Other
							<input type="radio" name="furniture-type" value="other" id="cb3" 
								<?php if(isset($_SESSION['info']['furniture-type']) && ($_SESSION['info']['furniture-type']) == 'other') echo 'checked'; ?>
							/>
							<label for="cb3"><img src="../images/furniture-samples/furniture-type/other.png" /></label>
						</li>				  
					</ul>

					<!-- Navigation controls -->
					<div class="nav-controls" >

						<input class="btn" type="submit" value="Next" name="request-start">
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
