<?php
    // Start session
    session_start();

    // Include common functions
    include("../common/functions.php");
    
    // Handle form submission
    if (isset($_POST['next'])) {
        // Store form values in session for later use
        foreach ($_POST as $key => $value) {
            $_SESSION['info'][$key] = $value;
        }
        
        // Remove 'next' value from session
        unset($_SESSION['info']['next']);
        
        // Redirect based on furniture type
        if ($_SESSION['info']['furniture-type'] == 'table') {
            header("location: table-shape-option.php");
        } else {
            header("location: edge-type.php");
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
    <title>Wood Type</title>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="page-container">
            <!-- Header -->
            <div class="header-container">
                <div class="title">
                    <h1>Select the Wood type</h1>
                </div>
            </div>

            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <li>
                            Oak
                            <input type="radio" name="wood-type" value="oak" id="cb1" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'oak') echo 'checked'; 
                                ?>
                            />
                            <label for="cb1"><img src="../images/furniture-samples/wood-type/oak.png" /></label>
                        </li>
                        <li>
                            Cedar
                            <input type="radio" name="wood-type" value="cedar" id="cb2" 
                                <?php if(isset($_SESSION['info']['wood-type']) && ($_SESSION['info']['wood-type']) == 'cedar') echo 'checked'; ?>
                            />
                            <label for="cb2"><img src="../images/furniture-samples/wood-type/cedar.png" /></label>
                        </li>
                    </ul>

                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <a href="furniture-type.php">Previous</a>
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
