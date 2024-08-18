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
    header("Location: ../login.php?message=login_first");
    exit();
}

// Get the userid to delete
if (!isset($_GET['userid'])) {
    header("Location: ../delete_admin.php");
    exit();
}

$userid_to_delete = $_GET['userid'];

// Prepare and bind
$query = "DELETE FROM udb_admin_log WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userid_to_delete);

// Execute the statement
if ($stmt->execute()) {
    header("Location: ../delete_admin.php?message=deleted");
    exit();
} else {
    echo "Error deleting admin: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
