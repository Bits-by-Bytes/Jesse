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
        
        // Determine the next page based on epoxy option
        if ($_SESSION['info']['epoxy-option'] == 'epoxy') {
            header("location: epoxy-options.php");
        } else {
            // Unset unwanted variables since there is no epoxy
            unset($_SESSION['info']['epoxy-type']);
            unset($_SESSION['info']['epoxy-foggy']);
            unset($_SESSION['info']['epoxy-style']);
            unset($_SESSION['info']['epoxy-color']);
            header("location: dimensions.php");
        }
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
    <title>Epoxy?</title>
    <style> ul li {margin-top:20px;}</style>
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
                    <h1>Select Epoxy Options</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <li>
                            Without Epoxy
                            <input type="radio" name="epoxy-option" value="no-epoxy" id="cb1" 
                                <?php 
                                if(isset($_SESSION['info']['epoxy-option']) && ($_SESSION['info']['epoxy-option']) == 'no-epoxy') echo 'checked'; 
                                ?>
                            />
                            <label for="cb1"><img src="../images/furniture-samples/epoxy-option/yes-no/no-epoxy.png" /></label>
                        </li>
                        <li>
                            With Epoxy
                            <input type="radio" name="epoxy-option" value="epoxy" id="cb2" 
                                <?php if(isset($_SESSION['info']['epoxy-option']) && ($_SESSION['info']['epoxy-option']) == 'epoxy') echo 'checked'; ?>
                            />
                            <label for="cb2"><img src="../images/furniture-samples/epoxy-option/yes-no/epoxy.png" /></label>
                        </li>
                    </ul>

                    <div class="nav-controls">
                        <a href="edge-type.php">Previous</a>
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
