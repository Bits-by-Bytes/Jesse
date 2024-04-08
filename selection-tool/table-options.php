<?php
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
        header("location: wood-type.php");

        // For testing purposes of the system
        echo '<pre>';
        print_r($_SESSION['info']);
        echo '</pre>';
        exit; // Exit to prevent further execution
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
    <title>Table Shape</title>
    <style>ul li { margin-top: 20px;}</style>
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
        <div class="header-container">
                <div class="title">
                    <h1>Select the Shape and Base</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                <h1>Table Shape</h1>
                    <ul>
                        <li>
                            rectangle
                            <input type="radio" name="table-shape-opt" value="rectangle" id="cb1"
                                <?php if (isset($_SESSION['info']['table-shape-opt']) && $_SESSION['info']['table-shape-opt'] == 'rectangle') echo 'checked'; ?> />
                            <label for="cb1"><img src="../images/furniture-samples/table-shape-opt/rectangle.png" /></label>
                        </li>
                        <li>
                            Circle
                            <input type="radio" name="table-shape-opt" value="circle" id="cb2"
                                <?php if (isset($_SESSION['info']['table-shape-opt']) && $_SESSION['info']['table-shape-opt'] == 'circle') echo 'checked'; ?> />
                            <label for="cb3"><img src="../images/furniture-samples/table-shape-opt/circle.png" /></label>
                        </li>
                    </ul>

                    <div class="title">
                        <h1>Base of Table</h1>
                    </div>            
                    <ul>
                        <li>
                            straight legs
                            <input type="radio" name="table-base-opt" value="straight-legs" id="cb3"
                                <?php if (isset($_SESSION['info']['table-shape-opt']) && $_SESSION['info']['table-shape-opt'] == 'square') echo 'checked'; ?> />
                            <label for="cb4"><img src="../images/furniture-samples/images.png" /></label>
                        </li>
                        <li>
                            Tapered Legs
                            <input type="radio" name="table-base-opt" value="tapered-legs" id="cb4"
                                <?php if (isset($_SESSION['info']['table-shape-opt']) && $_SESSION['info']['table-shape-opt'] == 'circle') echo 'checked'; ?> />
                            <label for="cb5"><img src="../images/furniture-samples/thisone.png" /></label>
                        </li>
                    </ul>






                    <div class="nav-controls">
                        <a href="furniture-type.php">Previous</a>
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
