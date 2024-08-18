<?php
// Database configuration
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$id = intval($_POST['id']);
$name = $_POST['name'];
$designation = $_POST['designation'];
$department = $_POST['department'];
$email = $_POST['email'];
$biography = $_POST['biography'];

// Days
$monday = isset($_POST['monday']) ? $conn->real_escape_string($_POST['monday']) : '';
$tuesday = isset($_POST['tuesday']) ? $conn->real_escape_string($_POST['tuesday']) : '';
$wednesday = isset($_POST['wednesday']) ? $conn->real_escape_string($_POST['wednesday']) : '';
$thursday = isset($_POST['thursday']) ? $conn->real_escape_string($_POST['thursday']) : '';
$friday = isset($_POST['friday']) ? $conn->real_escape_string($_POST['friday']) : '';
$saturday = isset($_POST['saturday']) ? $conn->real_escape_string($_POST['saturday']) : '';
$sunday = isset($_POST['sunday']) ? $conn->real_escape_string($_POST['sunday']) : '';

$time_slots = isset($_POST['time_slots']) ? $_POST['time_slots'] : [];

// Handle file upload
$photo = $_FILES['photo']['name'];
if ($photo) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($photo);

    // Ensure the upload directory exists and is writable
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $photo_update = ", photo = ?";
    } else {
        echo "Error uploading file.";
        exit;
    }
} else {
    $photo_update = "";
}

// Convert time slots array to string
$time_slot1 = isset($time_slots[0]) ? $time_slots[0] : '';
$time_slot2 = isset($time_slots[1]) ? $time_slots[1] : '';

// Update query
$sql = "UPDATE doctor SET 
    name = ?, 
    designation = ?, 
    department = ?, 
    email = ?, 
    biography = ?, 
    monday = ?, 
    tuesday = ?, 
    wednesday = ?, 
    thursday = ?, 
    friday = ?, 
    saturday = ?, 
    sunday = ?, 
    time_slot1 = ?, 
    time_slot2 = ? 
    $photo_update
    WHERE id = ?";

$stmt = $conn->prepare($sql);

// Bind parameters
if ($photo) {
    $stmt->bind_param(
        'sssssssssssssssi',
        $name,
        $designation,
        $department,
        $email,
        $biography,
        $monday,
        $tuesday,
        $wednesday,
        $thursday,
        $friday,
        $saturday,
        $sunday,
        $time_slot1,
        $time_slot2,
        $photo,
        $id
    );
} else {
    $stmt->bind_param(
        'ssssssssssssssi',
        $name,
        $designation,
        $department,
        $email,
        $biography,
        $monday,
        $tuesday,
        $wednesday,
        $thursday,
        $friday,
        $saturday,
        $sunday,
        $time_slot1,
        $time_slot2,
        $id
    );
}

$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: ../view_doctors.php?message=updated');
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
