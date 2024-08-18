<?php
// Include your database connection
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unique departments
$query = "SELECT DISTINCT department FROM doctor";
$result = mysqli_query($conn, $query);
$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['department'];
}
?>
