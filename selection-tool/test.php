<?php
	session_start();

	include("checkConnection.php");
	include("functions.php");

	$data = check_Login($conn);

	$somevar = $_SESSION['varname'];

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// set variable in session?
		
		
		header("Location: test.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Centered Dropdowns</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center; /* Center items vertically */
        height: 100vh;
        background-color: #f5e0ca; /* Pastel light brown */
    }

    .dropdown-container {
        border: 1px solid #ccc; /* Add border */
        border-radius: 5px;
        padding: 20px; /* Add padding */
        width: 500px; /* Set width */
        display: flex;
        flex-direction: column; /* Stack items vertically */
        align-items: stretch; /* Stretch items to fill container width */
        height: 300px; /* Fixed height */
        overflow-y: auto; /* Enable vertical scroll */
    }

    .dropdown {
        position: relative;
        margin-bottom: 20px; /* Adjust spacing between dropdowns */
    }

    .dropdown-toggle {
        background-color: #ffffff; /* White background */
        color: #000000; /* Black text */
        font-weight: bold; /* Bold text */
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        width: 100%; /* Make the button width 100% */
        text-align: left; /* Align text to the left */
        display: flex;
        justify-content: space-between; /* Space between elements */
        align-items: center; /* Center vertically */
    }

    .dropdown-toggle span {
        white-space: nowrap; /* Prevent line break */
        overflow: hidden; /* Hide overflow */
        text-overflow: ellipsis; /* Display ellipsis for overflow text */
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 5px); /* Adjust the distance from the top */
        left: 0;
        background-color: #ffffff; /* White background */
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: none;
        width: 100%; /* Make the dropdown menu width 100% */
        z-index: 1; /* Ensure dropdown is on top of other content */
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .dropdown-item:hover {
        background-color: #f0f0f0;
    }

    .highlighted {
        background-color: #3498db;
        color: #fff;
    }
</style>
</head>
<body>

<?php
print $somevar;
?>


<div class="dropdown-container">
    <!-- First dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown1-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option 1</div>
            <div class="dropdown-item">Option 2</div>
            <div class="dropdown-item">Option 3</div>
            <div class="dropdown-item">Option 4</div>
            <div class="dropdown-item">Option 5</div>
        </div>
    </div>

    <!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
	<!-- Second dropdown -->
    <div class="dropdown">
        <button class="dropdown-toggle" id="dropdown2-toggle">
            <span>Select an Option</span>
            <span class="selected-option" style="display: none;"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">Option A</div>
            <div class="dropdown-item">Option B</div>
            <div class="dropdown-item">Option C</div>
            <div class="dropdown-item">Option D</div>
            <div class="dropdown-item">Option E</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        // Event listener for dropdown toggle buttons
        dropdownToggles.forEach(function(dropdownToggle) {
            dropdownToggle.addEventListener('click', function() {
                var dropdownMenu = this.nextElementSibling;
                dropdownMenu.classList.toggle('show');

                // Adjust position of next dropdown button
                var nextDropdown = this.parentElement.nextElementSibling;
                if (nextDropdown) {
                    nextDropdown.style.marginTop = dropdownMenu.clientHeight + 'px';
                }
            });
        });

        // Event listener for dropdown items
        document.querySelectorAll('.dropdown-item').forEach(function(item) {
            item.addEventListener('click', function() {
                // Deselect previously selected option in the same dropdown
                var dropdown = this.closest('.dropdown');
                dropdown.querySelectorAll('.highlighted').forEach(function(selectedItem) {
                    selectedItem.classList.remove('highlighted');
                });

                // Select the clicked item
                this.classList.add('highlighted');

                // Update dropdown title
                var dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                dropdownToggle.querySelector('span').textContent = "Select an Option"; // Reset to default text
                dropdownToggle.querySelector('.selected-option').textContent = item.textContent; // Set selected option text
                dropdownToggle.querySelector('.selected-option').style.display = 'inline'; // Display selected option
            });
        });

        // Event listener to close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            dropdownToggles.forEach(function(dropdownToggle) {
                var dropdownMenu = dropdownToggle.nextElementSibling;
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                    
                    // Reset margin of next dropdown button
                    var nextDropdown = dropdownMenu.parentElement.nextElementSibling;
                    if (nextDropdown) {
                        nextDropdown.style.marginTop = '0';
                    }
                }
            });
        });
    });
</script>

</body>
</html>
