<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo 'Connection failed: ' . $conn->connect_error;
    exit();
}

// Get POST data
$doctorId = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';

// Validate input
if (empty($doctorId) || empty($date) || empty($time)) {
    echo 'Invalid input';
    exit();
}

// Check if the doctor is available at the requested time
$sql = "SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND status='Booked'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $doctorId, $date, $time);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Time slot is already booked
    echo 'Unavailable';
} else {
    // Time slot is available
    echo 'Available';
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
