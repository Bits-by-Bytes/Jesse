<?php
    // Start session
    session_start();

    // Include common functions
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
        
        header("location: edge-type.php");

        
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
    <title>Wood Type</title>

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
                    <h1>Select the Wood type</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST">
                    <ul>
                        <li>
                            Apple Lumberk
                            <input type="radio" name="wood-type" value="apple-lumberk" id="cb1" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'apple-lumber') echo 'checked'; 
                                ?>
                            />
                            <label for="cb1"><img src="../images/furniture-samples/wood-type/apple-lumber.jpg" /></label>
                        </li>
                        <li>
                            Ash
                            <input type="radio" name="wood-type" value="ash" id="cb2" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'ash') echo 'checked'; 
                                ?>
                            />
                            <label for="cb2"><img src="../images/furniture-samples/wood-type/ash.jpg" /></label>
                        </li>
                        <li>
                            Birch
                            <input type="radio" name="wood-type" value="birch" id="cb3" 
                                <?php if(isset($_SESSION['info']['wood-type']) && ($_SESSION['info']['wood-type']) == 'birch') echo 'checked'; ?>
                            />
                            <label for="cb3"><img src="../images/furniture-samples/wood-type/birch.jpg" /></label>
                        </li>



                        <li>
                            Cedar
                            <input type="radio" name="wood-type" value="cedar" id="cb4" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'cedar') echo 'checked'; 
                                ?>
                            />
                            <label for="cb4"><img src="../images/furniture-samples/wood-type/cedar.jpg" /></label>
                        </li>
                        <li>
                            Cherry
                            <input type="radio" name="wood-type" value="cherry" id="cb5" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'cherry') echo 'checked'; 
                                ?>
                            />
                            <label for="cb5"><img src="../images/furniture-samples/wood-type/cherry.jpg" /></label>
                        </li>
                        <li>
                            Cotton Wood
                            <input type="radio" name="wood-type" value="cottonwood" id="cb6" 
                                <?php if(isset($_SESSION['info']['wood-type']) && ($_SESSION['info']['wood-type']) == 'cottonwood') echo 'checked'; ?>
                            />
                            <label for="cb6"><img src="../images/furniture-samples/wood-type/cottonwood.jpg" /></label>
                        </li>

                        <li>
                            Eln
                            <input type="radio" name="wood-type" value="elm" id="cb7" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'elm') echo 'checked'; 
                                ?>
                            />
                            <label for="cb7"><img src="../images/furniture-samples/wood-type/elm.jpg" /></label>
                        </li>
                        <li>
                            Fir
                            <input type="radio" name="wood-type" value="fir" id="cb8" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'fir') echo 'checked'; 
                                ?>
                            />
                            <label for="cb8"><img src="../images/furniture-samples/wood-type/fir.jpg" /></label>
                        </li>
                        <li>
                            Manitoba Maple
                            <input type="radio" name="wood-type" value="manitoba-maple" id="cb9" 
                                <?php if(isset($_SESSION['info']['wood-type']) && ($_SESSION['info']['wood-type']) == 'manitoba-maple') echo 'checked'; ?>
                            />
                            <label for="cb9"><img src="../images/furniture-samples/wood-type/manitoba-maple.jpg" /></label>
                        </li>

                        <li>
                            Maple Burl
                            <input type="radio" name="wood-type" value="maple-burl" id="cb10" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'maple-burl') echo 'checked'; 
                                ?>
                            />
                            <label for="cb10"><img src="../images/furniture-samples/wood-type/maple-burl.jpg" /></label>
                        </li>
                        <li>
                            Russian Olive
                            <input type="radio" name="wood-type" value="russian-olive" id="cb11" 
                                <?php 
                                if(isset($_SESSION['info']['wood-type']) && 
								($_SESSION['info']['wood-type']) == 'russian-olive') echo 'checked'; 
                                ?>
                            />
                            <label for="cb11"><img src="../images/furniture-samples/wood-type/russian-olive.jpg" /></label>
                        </li>
                    </ul>

                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <a href="table-options.php">Previous</a>
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
