<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if session is set, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php?message=login_first');
    exit;
}

// Database configuration
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $doctorId = intval($_GET['id']);

    // Check if there are any appointments with status other than "Cancelled"
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND status != 'Cancelled'");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // There are active appointments, set an error message and redirect
        $_SESSION['error_cannot_delete'] = "This doctor has appointments scheduled that are not cancelled. Please cancel all active appointments before deleting the doctor.";
        header('Location: ../admin_home.php');
        exit;
    } else {
        // No active appointments, proceed with cascading delete
        $conn->begin_transaction();

        try {
            // First delete all appointments for this doctor
            $stmt = $conn->prepare("DELETE FROM appointments WHERE doctor_id = ?");
            if ($stmt === false) {
                throw new Exception('Prepare failed: ' . $conn->error);
            }
            $stmt->bind_param("i", $doctorId);
            $stmt->execute();
            $stmt->close();

            // Then delete the doctor record
            $stmt = $conn->prepare("DELETE FROM doctor WHERE id = ?");
            if ($stmt === false) {
                throw new Exception('Prepare failed: ' . $conn->error);
            }
            $stmt->bind_param("i", $doctorId);
            $stmt->execute();
            $stmt->close();

            // Commit the transaction
            $conn->commit();

            // Redirect to the view doctors page with success message
            header('Location: ../view_doctors.php?message=deleted');
            exit;
        } catch (Exception $e) {
            // Rollback the transaction if something went wrong
            $conn->rollback();
            $_SESSION['error_cannot_delete'] = "Error occurred while deleting the doctor: " . $e->getMessage();
            header('Location: ../admin_home.php');
            exit;
        }
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
