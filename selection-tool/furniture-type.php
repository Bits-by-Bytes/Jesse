<?php
	// Start session
	session_start();

	// Include common functions
	include("../common/functions.php");
    include("../common/checkconnection.php");

        // get login for acc_type to display user or admin
        if (isset($_SESSION['id'])) {
            $user_data = check_Login($conn);
            $id = $user_data['CUST_ID']; 
            $accountType = $user_data['ACC_TYPE']; 
        } else {
            $accountType = "selection";
        }
        
    
	// Handle form submission
	if (isset($_POST['request-start'])) {
		$_SESSION['started-request'] = $_POST['request-start'];
		// Store form values in session for later use
		foreach ($_POST as $key => $value) {
			$_SESSION['info'][$key] = $value;
		}

		// Remove 'next' value from session as it will appear later
		unset($_SESSION['info']['next']);

		// Redirect based on furniture type if its table or not will send different path
		if ($_SESSION['info']['furniture-type'] == 'table') {
			header("location: table-options.php");
		} else {
			// Unset specific table options if not a table so it doesnt keep it despite going back
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
    <link rel="icon" type="image/x-icon" href="../images/favi.png">

    
    <script src="../javascript/responsive-nav.js"></script>
    <title>Furniture Type</title>

    <style>
        ul li {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<nav>
    <?php 
        print_nav(); 
        print_navTool($accountType); 
     ?>
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
                <form action='' method="POST">
                    
                    <!-- TODO: Add to all selection screen in case they want to leave -->
                    
                    <ul >
                        <!-- Radio buttons for furniture type selection -->
                        <li >
                            Table
                            <input type="radio" name="furniture-type" value="table" id="cb1" 
                                <?php if((isset($_SESSION['info']['furniture-type']) && $_SESSION['info']['furniture-type'] == 'table') || !isset($_SESSION['info']['furniture-type'])) echo 'checked'; ?>
                                required
                            />
                            <label for="cb1"><img src="../images/furniture-samples/furniture-type/table.png" /></label>
                        </li>
                        <li>
                            Other
                            <input type="radio" name="furniture-type" value="other" id="cb3" 
                                <?php if(isset($_SESSION['info']['furniture-type']) && $_SESSION['info']['furniture-type'] == 'other') echo 'checked'; ?>
                                required
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
        <?php print_footer1(); ?>
    </footer>
</body>

</html>

