<?php

    // Validate if token is provided via POST
    if (!isset($_POST["token"])) {
        die("Token not provided no token!");
    }

    $token = $_POST["token"];

    // Hash the token
    $token_hash = hash("sha256", $token);

    // Include database connection
    require_once "../common/checkConnection.php";

    // Prepare SQL statement to select user by token
    $sql = "SELECT * FROM login
            WHERE RESET_TOKEN = ?";
    $stmt = $mysqli->prepare($sql);

    // Bind token parameter and execute query
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();

    // Get query result
    $result = $stmt->get_result();

    // Fetch user data
    $user = $result->fetch_assoc();

    // Check if token exists
    if ($user === null) {
        die("Token not found proc-reset-pass");
    }

    // Check if token has expired
    if (strtotime($user["RESET_TOKEN_EXP"]) <= time()) {
        die("Token has expired");
    }

    // Validate password requirements
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if (strlen($password) < 8) {
        die("Password must be at least 8 characters");
    }

    if (!preg_match("/[a-z]/i", $password)) {
        die("Password must contain at least one letter");
    }

    if (!preg_match("/[0-9]/", $password)) {
        die("Password must contain at least one number");
    }

    if (!preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $password)) {
        die("Password must contain at least one special character");
    }

    // Check if passwords match
    if ($password !== $password_confirmation) {
        die("Passwords must match");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to update user password
    $sql = "UPDATE login
            SET PWORD = ?,
                RESET_TOKEN = NULL,
                RESET_TOKEN_EXP = NULL
            WHERE CUST_ID = ?";
    $stmt = $mysqli->prepare($sql);

    // Bind parameters and execute query
    $stmt->bind_param("ss", $hashed_password, $user["CUST_ID"]);
    $stmt->execute();

    // Output success message
    echo "Password updated. You can now login.";

?>
