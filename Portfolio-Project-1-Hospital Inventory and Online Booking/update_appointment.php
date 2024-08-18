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
$doctor_id = $_POST['doctor_id'];
$patient_name = $_POST['patient_name'];
$patient_email = $_POST['patient_email'];
$appointment_date = $_POST['appointment_date'];
$appointment_time = $_POST['appointment_time'];
$status = 'Booked'; // Set status to 'Pending' or modify as needed

$query = "UPDATE appointments SET doctor_id = ?, patient_name = ?, patient_phone = ?, appointment_date = ?, appointment_time = ?, status = ? WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("issssss", $doctor_id, $patient_name, $patient_email, $appointment_date, $appointment_time, $status, $appointment_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>
            alert('Appointment updated successfully.');
            window.location.href = 'manage_appointments.php';
          </script>";

} else {
    echo "<script>
            alert('Failed to update appointment.');
            window.location.href = 'manage_appointments.php';
          </script>";

}

$conn->close();
?>
