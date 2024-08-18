<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if admin is logged in
if (!isset($_SESSION['admin_userid'])) {
    header("Location: ../admin_login.php?message=login_first");
    exit();
}

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$userid = $_POST['userid'];
$password = $_POST['password']; // Store password as plain text

// Prepare and bind
$query = "INSERT INTO udb_admin_log (name, email, userid, pass) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $name, $email, $userid, $password);

// Execute the statement
if ($stmt->execute()) {
    header("Location: ../add_admin.php?message=admin_added");
    exit();
} else {
    header("Location: ../add_admin.php?message=error");
    exit();
}

$stmt->close();
$conn->close();
?>
