<?php
    // Start session
    session_start();

    // Include common functions for nav
    include("../common/functions.php");
    
    // Handle form submission
    if (isset($_POST['next'])) {
        // Store form values in session for later use
        foreach ($_POST as $key => $value) {
            $_SESSION['info'][$key] = $value;
        }
        
        // Remove 'next' value from session
        $keys = array_keys($_SESSION['info']);
        if (in_array('next', $keys)) {
            unset($_SESSION['info']['next']);
        }
        
        // Redirect to next page
        header("location: epoxy-option-3.php");
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
    <title>Epoxy Fogginess</title>
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
                    <h1>Select the epoxy style</h1>
                </div>
            </div>

            <!-- Form Section -->
            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <!-- Radio buttons for selecting epoxy fogginess -->
                        <li>
                            Clear
                            <input type="radio" name="epoxy-foggy" value="clear" id="cb1" 
                                <?php 
                                if(isset($_SESSION['info']['epoxy-foggy']) && ($_SESSION['info']['epoxy-foggy']) == 'clear') echo 'checked'; 
                                ?>
                            />
                            <label for="cb1"><img src="../images/furniture-samples/epoxy-option/epoxy-foggy/no-fog.png" /></label>
                        </li>
                        <li>
                            Very Foggy
                            <input type="radio" name="epoxy-foggy" value="foggy" id="cb2" 
                                <?php if(isset($_SESSION['info']['epoxy-foggy']) && ($_SESSION['info']['epoxy-foggy']) == 'foggy') echo 'checked'; ?>
                            />
                            <label for="cb2"><img src="../images/furniture-samples/epoxy-option/epoxy-foggy/very-foggy.png" /></label>
                        </li>
                    </ul>

                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <a href="epoxy-option-1.php">Previous</a>
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
