<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_userid'])) {
    header("Location: ../admin_login.php?message=login_first");
    exit();
}

include 'db_con.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_id = $_POST['medicine_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];
    $manufacturer = $_POST['manufacturer'];
    $price = $_POST['price'];
    $batch_number = $_POST['batch_number'];
    $dosage_form = $_POST['dosage_form'];
    $quantity_available = $_POST['quantity_available'];
    $expiry_date = "";
    $strength = $_POST['strength'];
    $prescription_required = $_POST['prescription_required'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE medicines SET name = ?, description = ?, brand = ?, manufacturer = ?, price = ?, batch_number = ?, dosage_form = ?, quantity_available = ?, expiry_date = ?, strength = ?, prescription_required = ?, category = ? WHERE medicine_id = ?");
    $stmt->bind_param("ssssddsisissi", $name, $description, $brand, $manufacturer, $price, $batch_number, $dosage_form, $quantity_available, $expiry_date, $strength, $prescription_required, $category, $medicine_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin_home.php");
    } else {
        echo "No changes made or error occurred.";
    }

    $stmt->close();
}

$conn->close();
?>
