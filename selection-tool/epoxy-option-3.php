<?php
    // Start session
    session_start();

    // Include common functions for  nav
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
        header("location: additional-details.php");   
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
    <title>Epoxy Color</title>
</head>

<style>
    /* CSS styles for the color picker */
    label.color-picker {
      width: 150px;
      border: 1px solid #ccc;
      border-radius: 3px;
      padding: 5px;
      background: #fff;
      display: block;
    }

    label.color-picker > span {
      border: 1px solid #ccc;
      display: block;
    }

    label.color-picker > span > input[type=color] {
      height: 10px;
      display: block;
      width: 100%;
      border: none;
      padding: 0px;
    }

    /* Chrome styles */
    label.color-picker > span > input[type=color]::-webkit-color-swatch-wrapper {
      padding: 0;
    }
    label.color-picker > span > input[type=color]::-webkit-color-swatch {
      border: none;
    }

    /* Firefox styles */
    label.color-picker > span > input[type=color]::-moz-color-swatch {
      border: none;
    }
    label.color-picker > span > input[type=color]::-moz-focus-inner {
      border: none;
      padding: 0;
    }
</style>

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
                    <h1>Select the epoxy color</h1>
                </div>
            </div>

            <!-- Form Section -->
            <div class="selection-tool-container">
                <form method="POST">
                    <!-- Color picker input -->
                    <label class="color-picker">
                        <span>
                            <input type="color" name="epoxy-color" value="<?php echo isset($_SESSION['info']['epoxy-color']) ? $_SESSION['info']['epoxy-color'] : ''; ?>">
                        </span>
                    </label>
                    
                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <a href="epoxy-option-2.php">Previous</a>
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
