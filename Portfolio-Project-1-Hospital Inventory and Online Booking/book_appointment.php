<?php
session_start();
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$doctorId = $_POST['doctor_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$patientName = $_POST['patient_name'];
$patientEmail = $_POST['patient_phone'];

// Validate required fields
if (empty($doctorId) || empty($date) || empty($time) || empty($patientName)) {
    echo "Error: All required fields must be filled.";
    exit();
}

// Insert appointment into the database
$sql = "INSERT INTO appointments (doctor_id, appointment_date, appointment_time, patient_name, patient_phone) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param('sssss', $doctorId, $date, $time, $patientName, $patientEmail);

// Execute statement
if ($stmt->execute()) {
    $bookingId = $conn->insert_id; // Get the last inserted ID
    echo "Appointment booked successfully. Booking ID: " . $bookingId;
} else {
    echo "Error booking appointment: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
