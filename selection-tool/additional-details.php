<?php
    session_start();

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


    unset($_SESSION['info']['request-start']);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Handle additional details
        if (isset($_POST['additional-details'])) {
            $_SESSION['info']['additional-details'] = $_POST['additional-details'];
        }
       

        // Handle file uploads
        if (!empty($_FILES['files']['name'][0])) {
            $_SESSION['info']['uploaded_files'] = [];

            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['files']['name'][$key];
                $file_tmp = $_FILES['files']['tmp_name'][$key];

                // Define the destination path
                $destination = "../images/customer-images/" . $file_name;

                // Move the uploaded file to the permanent location
                if (move_uploaded_file($file_tmp, $destination)) {
                    // Store the file details in the session
                    $_SESSION['info']['uploaded_files'][] = $destination;
                } else {
                    echo "Failed to move file: $file_name";
                }
            }
        }

        // Redirect to the confirmation page
        header("Location: confirmation.php");
        exit();
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
    <title>Additional Details</title>
    <style>
        #fileList img {
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }
        #fileList li {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .remove-btn {
            cursor: pointer;
        }
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
            <div class="header-container">
            </div>
            <!-- Your exit selection -->
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

                    <!-- File upload fields for images -->
                    <div id="imageUploadContainer">
                        <input type="file" name="files[]" multiple>
                    </div>

                    <!-- Navigation controls -->
                    <div class="nav-controls">
                        <a href="dimensions.php">Back</a>
                        <input class="btn" type="submit" value="Next" name="next">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer1(); ?>
    </footer>

    <script>

    </script>
</body>
</html>
