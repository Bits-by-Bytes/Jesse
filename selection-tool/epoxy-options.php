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

    // Redirect to the next page
    header("location: dimensions.php");
    exit(); // Ensure script execution stops after redirection
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
    <title>Epoxy Options</title>
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
            
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    <div class="title">
                        <h1>Select Epoxy Color</h1>
                    </div>
                    <label class="color-picker">
                        <span class="color-preview" style="background-color: <?php echo isset($_SESSION['info']['epoxy-color']) ? $_SESSION['info']['epoxy-color'] : '#ffffff'; ?>"></span>
                        <input type="text" id="colorPicker" name="epoxy-color" value="<?php echo isset($_SESSION['info']['epoxy-color']) ? $_SESSION['info']['epoxy-color'] : '#ffffff'; ?>">
                    </label>

                    <div class="title">
                        <h1>Select the epoxy style</h1>
                    </div>
                    <ul>
                        <li>
                            Center Table
                            <input type="radio" name="epoxy-style" value="slim" id="cb1" <?php if (isset($_SESSION['info']['epoxy-style']) && $_SESSION['info']['epoxy-style'] == 'slim') echo 'checked'; ?> />
                            <label for="cb1"><img src="../images/furniture-samples/epoxy-option/styles/slim.png" /></label>
                        </li>
                        <li>
                            Outer Table
                            <input type="radio" name="epoxy-style" value="whole-table" id="cb2" <?php if (isset($_SESSION['info']['epoxy-style']) && $_SESSION['info']['epoxy-style'] == 'whole-table') echo 'checked'; ?> />
                            <label for="cb2"><img src="../images/furniture-samples/epoxy-option/styles/whole-table.png" /></label>
                        </li>
                        <li>
                            Scattered
                            <input type="radio" name="epoxy-style" value="poxy-scatterd" id="cb3" <?php if (isset($_SESSION['info']['epoxy-style']) && $_SESSION['info']['epoxy-style'] == 'poxy-scatterd') echo 'checked'; ?> />
                            <label for="cb2"><img src="../images/furniture-samples/epoxy-option/styles/epoxy-scattered.png" /></label>
                        </li>
                    </ul>

                    <div class="title">
                        <h1>Select Epoxy Type</h1>
                    </div>
                    <ul>
                        <!-- Radio buttons for selecting epoxy fogginess -->
                        <li>
                            Transparent
                            <input type="radio" name="epoxy-type" value="clear" id="cb4" <?php if (isset($_SESSION['info']['epoxy-type']) && $_SESSION['info']['epoxy-type'] == 'clear') echo 'checked'; ?> />
                            <label for="cb4"><img src="../images/furniture-samples/epoxy-option/epoxy-foggy/no-fog.png" /></label>
                        </li>
                        <li>
                            Foggy
                            <input type="radio" name="epoxy-type" value="foggy" id="cb5" <?php if (isset($_SESSION['info']['epoxy-type']) && $_SESSION['info']['epoxy-type'] == 'foggy') echo 'checked'; ?> />
                            <label for="cb5"><img src="../images/furniture-samples/epoxy-option/epoxy-foggy/very-foggy.png" /></label>
                        </li>

                    </ul>

                    <!-- Include jQuery -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <!-- Include Spectrum JS -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            // Initialize the color picker
                            $('#colorPicker').spectrum({
                                preferredFormat: "hex", // You can change this to "rgb", "rgba", etc.
                                showInput: true // Show input box where the user can type the color value
                            });
                        });
                    </script>

                    <div class="nav-controls">
                        <a href="epoxy-option.php">Previous</a>
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
