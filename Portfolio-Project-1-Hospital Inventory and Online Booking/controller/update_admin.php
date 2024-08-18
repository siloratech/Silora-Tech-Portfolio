<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if session variable is set
if (!isset($_SESSION['admin_userid'])) {
    echo "<script>
            alert('Session variable \'admin_userid\' is not set.');
            window.location.href = '../update_admin_details.php';
          </script>";
    exit();
}

// Get form data
$admin_id = $_SESSION['admin_userid'];
$name = $_POST['name'];
$userid = $_POST['userid'];
$email = $_POST['email'];
$current_password = $_POST['current-password'];
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];

// Fetch current admin details
$query = "SELECT pass FROM udb_admin_log WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

if (!$admin) {
    echo "<script>
            alert('Admin not found.');
            window.location.href = '../update_admin_details.php';
          </script>";
    exit();
}

// Verify current password (plaintext comparison)
if ($current_password !== $admin['pass']) {
    echo "<script>
            alert('Current password is incorrect.');
            window.location.href = '../update_admin_details.php';
          </script>";
    exit();
}

// Prepare update statement
if ($new_password && $new_password === $confirm_password) {
    $query = "UPDATE udb_admin_log SET name = ?, email = ?, pass = ?, userid = ?, lastupdated = NOW() WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $name, $email, $new_password, $userid, $admin_id);
    if (!empty($name)) {
      $_SESSION['admin_name'] = $name;
  }
} else {
    $query = "UPDATE udb_admin_log SET name = ?, email = ?, userid = ?, lastupdated = NOW() WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $userid, $admin_id);
    if (!empty($name)) {
      $_SESSION['admin_name'] = $name;
  }
}

// Execute update statement
if ($stmt->execute()) {
    echo "<script>
            alert('Details updated successfully.');
            window.location.href = '../admin_home.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating admin details: " . $stmt->error . "');
            window.location.href = '../update_admin_details.php';
          </script>";
}

if ( $userid != $admin_id)
  {
    $_SESSION['admin_userid'] = $userid;
  }
  
$stmt->close();
$conn->close();
?>
