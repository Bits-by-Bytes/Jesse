<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require "../common/database.php";

$sql = "SELECT * FROM login
        WHERE RESET_TOKEN = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo "token not found";
    header( "refresh:3;url=login.php" );
}

if (strtotime($user["RESET_TOKEN_EXP"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE login
        SET PWORD = ?,
            RESET_TOKEN = NULL,
            RESET_TOKEN_EXP = NULL
        WHERE CUST_ID = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["CUST_ID"]);

$stmt->execute();

header( "refresh:3;url=login.php" );