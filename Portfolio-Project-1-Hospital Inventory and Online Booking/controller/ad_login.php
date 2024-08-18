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

// Get username and password from POST request
$admin_username = $_POST['username'];
$admin_password = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT userid, pass, name FROM udb_admin_log WHERE userid = ?");
$stmt->bind_param("s", $admin_username);

// Execute statement
$stmt->execute();
$stmt->store_result();

// Bind the result
$stmt->bind_result($userid, $hashed_password, $name);

// Fetch the result
$stmt->fetch();

echo var_dump($admin_password);
echo var_dump($hashed_password);

// Check if the username and password match
if (strcmp($admin_password, $hashed_password) == 0) {
    echo "IF condition is true";
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_userid'] = $userid;
    $_SESSION['admin_name'] = $name; // Store the admin's name in session
    header("Location: ../admin_home.php");
    exit();
} else {
    header("Location: ../admin_login.php?error=invalid_credentials");
    exit();
}

$stmt->close();
$conn->close();
?>
