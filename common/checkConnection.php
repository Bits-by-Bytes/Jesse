<?php
$conn = new mysqli("localhost", "root", "Password1", "project ox");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
