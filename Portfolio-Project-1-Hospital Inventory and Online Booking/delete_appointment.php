<?php
session_start();

if (!isset($_SESSION['admin_userid'])) {
    header("Location: admin_login.php?message=login_first");
    exit();
}

include 'controller/db_con.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appointment_id = $_POST['appointment_id'];
$status = "Cancelled";

$query = "UPDATE appointments SET status = ? WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("si", $status, $appointment_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Appointment status updated to Cancelled successfully.";
} else {
    echo "Failed to update appointment status.";
}

$conn->close();
?>
