<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity_available = $_POST['quantity_available'];
    $expiry_date = "";

    $prescription_required = $_POST['prescription_required'];

    $name = !empty($_POST['name']) ? $_POST['name'] : null;
    $description = !empty($_POST['description']) ? $_POST['description'] : null;
    $brand = !empty($_POST['brand']) ? $_POST['brand'] : null;
    $manufacturer = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : null;
    $batch_number = !empty($_POST['batch_number']) ? $_POST['batch_number'] : null;
    $dosage_form = !empty($_POST['dosage_form']) ? $_POST['dosage_form'] : null;
    $strength = !empty($_POST['strength']) ? $_POST['strength'] : null;

    // Prepare SQL query
    $sql = "INSERT INTO medicines (category, name, description, brand, manufacturer, price, quantity_available, expiry_date, batch_number, dosage_form, strength, prescription_required, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

    // Prepare and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            'ssssddsissss', // Corrected types
            $category, 
            $name, 
            $description, 
            $brand, 
            $manufacturer, 
            $price, 
            $quantity_available, 
            $expiry_date, 
            $batch_number, 
            $dosage_form, 
            $strength, 
            $prescription_required
        );

        // Execute the query
        if ($stmt->execute()) {
            // Success, redirect to admin home page with success message
            $_SESSION['medicine_add_success'] = "Medicine added successfully!";
            header('Location: ../admin_home.php');
        } else {
            // Error, redirect back with error message
            $_SESSION['error_message'] = "Error adding medicine: " . htmlspecialchars($stmt->error);
            header('Location: ../add_medicine.php');
        }

        // Close the statement
        $stmt->close();
    } else {
        // SQL error, redirect back with error message
        $_SESSION['error_message'] = "Database error: " . htmlspecialchars($conn->error);
        header('Location: ../add_medicine.php');
    }

    // Close the connection
    $conn->close();
} else {
    // Invalid request method
    header('Location: ../admin_home.php');
    exit;
}
?>
