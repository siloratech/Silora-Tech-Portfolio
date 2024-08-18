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

// Get test ID from query parameter
$testid = isset($_GET['testid']) ? intval($_GET['testid']) : 0;

if ($testid) {
    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete from lab_bookings where test_id matches
        $sql = "DELETE FROM lab_bookings WHERE test_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $testid);
        $stmt->execute();
        $stmt->close();

        // Delete from labtests
        $sql = "DELETE FROM labtests WHERE testid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $testid);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();
        $_SESSION['delete_success'] = true;
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['delete_error'] = true;
    }
} else {
    $_SESSION['delete_error'] = true;
}

header("Location: view_labtest.php");
exit();
?>
