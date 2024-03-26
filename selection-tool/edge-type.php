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
    if (isset($_POST['next'])) {
        // Store form values in session for later use
        foreach ($_POST as $key => $value) {
            $_SESSION['info'][$key] = $value;
        }
        
        // Remove 'next' value from session
        unset($_SESSION['info']['next']);
        
        // Redirect to epoxy option page
        header("location: epoxy-option.php");    
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
    <title>Edge Type</title>
    <style>
ul li {
	margin-top: 20px;}


	</style>
</head>
<body>
    <!-- Navigation -->
    <nav>
    <?php 
        print_nav(); 
        print_navTool($accountType); 
     ?>
</nav>

    <main>
        <div class="page-container">
            <!-- Header -->
            <div class="header-container">
                <div class="title">
                    <h1>Select the Edge type</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <!-- Radio buttons for selecting edge type -->
                        <li>
                            Live Edge
                            <input type="radio" name="edge-type" value="live-edge" id="cb1" 
                                <?php 
                                if(isset($_SESSION['info']['edge-type']) && ($_SESSION['info']['edge-type']) == 'live-edge') echo 'checked'; 
                                ?>
                            />
                            <label for="cb1"><img src="../images/furniture-samples/edge-type/live-edge.png" /></label>
                        </li>
                        <li>
                            Straight Edge
                            <input type="radio" name="edge-type" value="straight" id="cb2" 
                                <?php if(isset($_SESSION['info']['edge-type']) && ($_SESSION['info']['edge-type']) == 'straight') echo 'checked'; ?>
                            />
                            <label for="cb2"><img src="../images/furniture-samples/edge-type/straight-edge.png" /></label>
                        </li>
                    </ul>

                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <a href="wood-type.php">Previous</a>                 
                        <input class="btn" type="submit" value="Next" name="next">                    
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
