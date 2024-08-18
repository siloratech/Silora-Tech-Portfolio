<?php
session_start();

// Include database connection
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if testid is provided
if (isset($_GET['testid'])) {
    $testid = intval($_GET['testid']);
    
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM labtests WHERE testid = ?");
    $stmt->bind_param("i", $testid);
    
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = true;
    } else {
        $_SESSION['delete_error'] = "This Test has bookings. Can't be deleted. Use Force Delete,";
    }

    $stmt->close();
}

// Redirect back to the view_labtest.php page
header("Location: admin_home.php");
exit();

// Close the connection
$conn->close();
?>
