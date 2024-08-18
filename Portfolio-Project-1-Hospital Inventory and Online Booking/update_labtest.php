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

$appointment_id = isset($_POST['appointment_id']) ? intval($_POST['appointment_id']) : 0;
$patient_name = isset($_POST['patient_name']) ? trim($_POST['patient_name']) : '';
$patient_phone = isset($_POST['patient_phone']) ? trim($_POST['patient_phone']) : '';
$test_id = isset($_POST['test_id']) ? intval($_POST['test_id']) : 0;
$booking_date = isset($_POST['booking_date']) ? trim($_POST['booking_date']) : '';
$booking_time = isset($_POST['booking_time']) ? trim($_POST['booking_time']) : '';

// Validate input
if (empty($patient_name) || empty($patient_phone) || empty($booking_date) || empty($booking_time) || $test_id <= 0) {
    die("All fields are required.");
}

// Update appointment
$query = "UPDATE lab_bookings SET test_id = ?, booking_date = ?, booking_time = ?, patient_name = ?, patient_phone = ? WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("issssi", $test_id, $booking_date, $booking_time, $patient_name, $patient_phone, $appointment_id);
$success = $stmt->execute();
if (!$success) {
    die("Update failed: " . $stmt->error);
}

$stmt->close();
$conn->close();

header("Location: scheduled_labtest.php");
exit();
?>
