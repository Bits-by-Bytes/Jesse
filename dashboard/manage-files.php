<?php
    session_start();

    include("../common/checkconnection.php");
    include("../common/functions.php");


    $user_data = check_Login($conn);
    $id = $user_data['CUST_ID']; 
	$accountType = $user_data['ACC_TYPE']; 

    // Check if a search query parameter is provided
    $search = '';
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
    }

    // Define the directories where the images are stored
    $imageDirectories = array(
        "../images/furniture-samples/",
        "../images/furniture-samples/edge-type/",
        "../images/furniture-samples/epoxy-option/",
        "../images/furniture-samples/furniture-type/",
        "../images/furniture-samples/table-shape-opt/",
        "../images/furniture-samples/wood-type/",
        
    );

    // Fetch all image files in the directories
    $imageFiles = array();
    foreach ($imageDirectories as $directory) {
        $files = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        if ($files) {
            $imageFiles = array_merge($imageFiles, $files);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Image Directory</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/crudstyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../images/favi.png">
    <style>
        /* Adjust the table to take up full width */
        #table_wrapper {
            width: 100%;
            margin: 10px;
        }
        #table {
            width: 100%;
        }
        .image-cell img {
            max-width: 200px;
            max-height: 150px;
        }
    </style>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
        <?php print_navDash($accountType);?>
    </nav>

    <div class="container">
        <div class="dashboard">
            <div class="header">
                <div class="welcomeContainer"><h1>Image Directory</h1></div>
                <a class="btn" style="float: right" href="../dashboard/dashboard.php">Back to dashboard</a>
                
            </div>
            
            <!-- Table setup -->
            <div id="table_wrapper">
                <table id="table">
                    <thead>
                        <tr>
                            <th>Image Name</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($imageFiles as $image): ?>
                            <?php if(empty($search) || stripos($image, $search) !== false): ?>
                                <tr>
                                    <td><?php echo basename($image); ?></td>
                                    <td class="image-cell"><img src="<?php echo $image; ?>" alt="<?php echo basename($image); ?>"></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <?php print_footer(); ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
</body>
</html>
