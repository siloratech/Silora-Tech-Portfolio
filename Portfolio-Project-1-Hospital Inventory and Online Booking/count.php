<?php
// Database configuration
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize counts
$doctor_count = $wholesale_medicine_count = $retail_medicine_count = 0;

// Query to get counts
$doctor_count_query = "SELECT COUNT(*) as total FROM appointments where status = 'Booked'";
$wholesale_medicine_count_query = "SELECT COUNT(*) as total FROM lab_bookings where  status = 'Booked'";
$retail_medicine_count_query = "SELECT COUNT(*) as total FROM medicines";

$doctor_count_result = $conn->query($doctor_count_query);
$wholesale_medicine_count_result = $conn->query($wholesale_medicine_count_query);
$retail_medicine_count_result = $conn->query($retail_medicine_count_query);

if ($doctor_count_result) {
    $doctor_count = $doctor_count_result->fetch_assoc()['total'];
}


if ($wholesale_medicine_count_result) {
    $wholesale_medicine_count = $wholesale_medicine_count_result->fetch_assoc()['total'];
}

if ($retail_medicine_count_result) {
    $retail_medicine_count = $retail_medicine_count_result->fetch_assoc()['total'];
}

$conn->close();

// Return counts as an associative array
echo json_encode([
    'doctor_count' => $doctor_count,
    'wholesale_medicine_count' => $wholesale_medicine_count,
    'retail_medicine_count' => $retail_medicine_count
]);
?>
