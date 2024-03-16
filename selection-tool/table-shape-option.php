<?php
    session_start();

    include("../common/functions.php");

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
        header("location: edge-type.php");

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
    <script src="../javascript/responsive-nav.js"></script>
    <title>Table Shape</title>
    <style>ul li { margin-top: 20px;}</style>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="page-container">
            <div class="header-container">
                <div class="title">
                    <h1>Select the table's shape</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <li>
                            Square
                            <input type="radio" name="table-shape-opt" value="square" id="cb1"
                                <?php if (isset($_SESSION['info']['table-shape-opt']) && $_SESSION['info']['table-shape-opt'] == 'square') echo 'checked'; ?> />
                            <label for="cb1"><img src="../images/furniture-samples/table-shape-opt/square.png" /></label>
                        </li>
                        <li>
                            Circle
                            <input type="radio" name="table-shape-opt" value="circle" id="cb2"
                                <?php if (isset($_SESSION['info']['table-shape-opt']) && $_SESSION['info']['table-shape-opt'] == 'circle') echo 'checked'; ?> />
                            <label for="cb2"><img src="../images/furniture-samples/table-shape-opt/circle.png" /></label>
                        </li>
                    </ul>

                    <div class="nav-controls">
                        <a href="wood-type.php">Previous</a>
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
