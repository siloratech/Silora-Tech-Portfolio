<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_con.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$designation = $_POST['designation'];
$department = $_POST['department'];
$email = $_POST['email'];
$biography = $_POST['biography'];
$photo = $_FILES['photo'];

$monday = isset($_POST['monday']) ? "Monday" : "";
$tuesday = isset($_POST['tuesday']) ? "Tuesday" : "";
$wednesday = isset($_POST['wednesday']) ? "Wednesday" : "";
$thursday = isset($_POST['thursday']) ? "Thursday" : "";
$friday = isset($_POST['friday']) ? "Friday" : "";
$saturday = isset($_POST['saturday']) ? "Saturday" : "";
$sunday = isset($_POST['sunday']) ? "Sunday" : "";
$time_slot1 = $_POST['time_slot1'];
$time_slot2 = $_POST['time_slot2'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_message'] = "Invalid email format";
    header("Location: ../admin_home.php");
    exit();
}

$target_dir = "../uploads/";
$target_file = $target_dir . basename($photo["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$check = getimagesize($photo["tmp_name"]);
if ($check === false) {
    $_SESSION['error_message'] = "File is not an image.";
    header("Location: ../admin_home.php");
    exit();
}

if ($photo["size"] > 5000000) {
    $_SESSION['error_message'] = "Sorry, your file is too large.";
    header("Location: ../admin_home.php");
    exit();
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    header("Location: ../admin_home.php");
    exit();
}

if (!move_uploaded_file($photo["tmp_name"], $target_file)) {
    $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
    header("Location: ../admin_home.php");
    exit();
}

$availaibility = Null;

$stmt = $conn->prepare("INSERT INTO doctor (name, designation, department, availability, email, biography, photo, monday, tuesday, wednesday, thursday, friday, saturday, sunday, time_slot1, time_slot2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssssss", $name, $designation, $department,$availaibility, $email, $biography, $target_file, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $time_slot1, $time_slot2);

if ($stmt->execute()) {
    $_SESSION['doctor_add_success'] = "New doctor added successfully";
    header("Location: ../admin_home.php");
} else {
    $_SESSION['error_message'] = "Error: " . $stmt->error;
    header("Location: ../admin_home.php");
}

$stmt->close();
$conn->close();
?>
