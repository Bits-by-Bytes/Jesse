<?php
	session_start();

	include("../common/functions.php");

	if (isset($_POST['next'])) {
		unset($_SESSION['request-start']);
		// if there is an id they already have an acount and such so dont need to sign up
		if (isset($_SESSION['id'])) {
			header("location: confirm-send.php");
		} else {
			header("location: not-user.php");
		}
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
    <title>Confirmation</title>
</head>
<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .selection-tool-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


    </style>
<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="page-container">
            <div class="header-container">
                <div class="title">
                    <h1>View Details</h1>
                </div>
            </div>
            <?php exit_selection(); ?><br>
            <div class="selection-tool-container">
                <form method="POST" enctype="multipart/form-data">
                    <?php
					
					// todo add better layout
					// add way to allow for multiple options
					// cry
                    echo "<h2>Selected Details:</h2>";
                    echo "<table>";
                    foreach ($_SESSION['info'] as $key => $value) {
                        $attribute = ucwords(str_replace("-", " ", $key));
                        echo "<tr>";
                        echo "<td><strong>$attribute:</strong></td>";
                        echo "<td>$value</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>

                    <div class="nav-controls">
                        <a href="additional-details.php">Previous</a>
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
