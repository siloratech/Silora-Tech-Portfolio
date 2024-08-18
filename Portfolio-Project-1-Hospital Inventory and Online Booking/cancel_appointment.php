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

if (isset($_GET['id'])) {
    $appointment_id = intval($_GET['id']);

    $query = "UPDATE lab_bookings SET status = 'Cancelled' WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $appointment_id);
    if ($stmt->execute()) {
        header("Location: scheduled_labtest.php?message=cancelled");
    } else {
        die("Query failed: " . $stmt->error);
    }
} else {
    header("Location: scheduled_labtest.php?message=error");
}

$stmt->close();
$conn->close();
?>
