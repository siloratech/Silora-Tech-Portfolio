<?php
session_start();

// Include database connection
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testname = $_POST['testname'];
    $price = $_POST['price'];

    // Insert the new test into the labtests table
    $sql = "INSERT INTO labtests (testname, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $testname, $price);

    if ($stmt->execute()) {
        $_SESSION['test_add_success'] = true;
        header("Location: admin_home.php"); // Redirect back to the add test page
    } else {
        // Handle errors
        echo "Error: " . $stmt->error;
        header("Location: add_labtest.php"); // Redirect back to the add test page
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
