<?php
session_start();
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$testId = $_POST['test_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$patientName = $_POST['patient_name'];
$patientPhone = $_POST['patient_phone'];

// Validate inputs
if (empty($testId) || empty($date) || empty($time) || empty($patientName) || empty($patientPhone)) {
    echo "All fields are required.";
    exit();
}

if (!preg_match('/^\d{10}$/', $patientPhone)) {
    echo "Invalid phone number.";
    exit();
}

// Insert booking details into database
$stmt = $conn->prepare("INSERT INTO lab_bookings (test_id, booking_date, booking_time, patient_name, patient_phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $testId, $date, $time, $patientName, $patientPhone);

if ($stmt->execute()) {
    $bookingId = $stmt->insert_id;
    echo $bookingId; // Return booking ID
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
