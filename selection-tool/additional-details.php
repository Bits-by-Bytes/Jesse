<?php
    // Start session
    session_start();

    // Include common functions for navigation
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
		
		// so it doesnt show in confirmation
		// temp fix might cause other problems
		unset($_SESSION['info']['request-start']);
		
		//TODO: make sure they want to input absolutely nothing?
		
        // Redirect to the next page
        header("location: confirmation.php");   
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
    <title>Additional Details</title>
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
                    <h1>Add any more details</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Textarea for additional details -->
                    <h2>Additional Details to add:</h2>
                    <textarea id="additional-details" name="additional-details" rows="10" cols="80"><?php
                        if (isset($_SESSION['info']['additional-details'])) {
                            echo htmlspecialchars($_SESSION['info']['additional-details']);
                        }
                    ?></textarea><br><br><br>
					<!-- Image upload container -->
                    <div id="image-upload-container" style="overflow-y: auto; max-height: 200px;">
                        <!-- Existing image upload input field -->
                        <div class="image-upload-container">
						Not working!<br>
                            <input type="file" class="image-upload" name="image-upload" accept="image/png, image/jpeg">
                        </div>
                    </div>

                    <!-- Button to add more image upload fields dynamically -->
					
                    <button type="button" id="add-image-btn">Add Image</button>

                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <?php
                        if (!isset($_SESSION['info']['epoxy-option']) || $_SESSION['info']['epoxy-option'] == "no-epoxy") {
                            echo '<a href="epoxy-option.php">Back</a>';
                        } else {
                            echo '<a href="epoxy-option-3.php">Back</a>';
                        }
                        ?>
                        <input class="btn" type="submit" value="Next" name="next">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>

    <!-- JavaScript to add more image upload fields dynamically -->
    <script>
        document.getElementById('add-image-btn').addEventListener('click', function() {
            var container = document.getElementById('image-upload-container');
            var div = document.createElement('div');
            div.classList.add('image-upload-container');
            div.innerHTML = `
                <input type="file" class="image-upload" name="image_uploads[]" accept="image/*">
            `;
            container.appendChild(div);
        });
    </script>
</body>

</html>
