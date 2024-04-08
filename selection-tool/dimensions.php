<?php
    session_start();

    // include for nav
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
        header("location: additional-details.php");

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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">
    <link rel="stylesheet" href="../styles/selection-tool.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="icon" type="image/x-icon" href="../images/favi.png">

    <script src="../javascript/responsive-nav.js"></script>
    <title>Table Dimensions</title>
    <style>ul li {margin-top: 20px;}

input[type="number"] {
    width: calc(33.33% - 10px);
    padding: 8px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
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
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    
                    <div class="title">
                        <h1>Enter Product Dimensions (In Meters)</h1>
                    </div>
                    <input type="number" id="length" name="length" required value="<?php echo isset($_SESSION['info']['length']) ? $_SESSION['info']['length'] : ''; ?>">Length<br><br>
                    <input type="number" id="width" name="width" required value="<?php echo isset($_SESSION['info']['width']) ? $_SESSION['info']['width'] : ''; ?>">Width<br><br>
                    <input type="number" id="height" name="height" required value="<?php echo isset($_SESSION['info']['height']) ? $_SESSION['info']['height'] : ''; ?>">Height<br><br>


                    
                    
                
                    <div class="nav-controls">
                    <?php
                    if (isset($_SESSION['info']['epoxy-option']) && $_SESSION['info']['epoxy-option'] == 'epoxy') {
                        echo '<a href="epoxy-options.php">Previous</a>';
                    } else {
                        echo '<a href="epoxy-option.php">Previous</a>';
                    }
                    ?>



                        
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
