<?php 
    session_start();

    include("../common/checkconnection.php");
    include("../common/functions.php");
    
    // get login for acc_type to display user or admin
    $user_data = check_Login($conn);
	
	header( "refresh:5;url=account-information.php" );

?>


<!DOCTYPE html>
<html>
<head>    
    <title>Change Account Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <style>
        /*  drop down menu css   */
        #drop {
            position: flex;
            top: 70px; 
            right: 50px; 
            z-index: 999;
        }

        ul {
            list-style: none;
            background: #21201d;
            width: 150px;
            border-radius: 4px;
        }

        ul li {
            display: block;
            position: flex;
            border-radius: 15px;
        }

        ul li a {
            display: block;
            padding: 20px 25px;
            color: orange;
            text-decoration: none;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        ul li a:hover {
            background: #112C66;
        }

        ul li ul.dropdown {
            width: 100%;
            background: #21201d;
            position: absolute;
            left: -20px;
            top: 100%; 
            z-index: 999;
            display: none;
        }

        ul li:hover ul.dropdown {
            display: block;
        }

        /* Styling for dashboard elements */
        .dashboard {
            margin-top: 50px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard form {
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .dashboard .input-group {
            margin-bottom: 20px;
        }

        .dashboard .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .dashboard .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

    </style>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>
        
    <main>    
        
        <div class="dashboard">
            <h1>Your info has been changed</h1>
        </div>
    </main>


    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>

