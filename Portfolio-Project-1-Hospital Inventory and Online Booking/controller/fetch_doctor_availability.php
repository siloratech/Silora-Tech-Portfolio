<?php
include 'db_con.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$doctorId = $_POST['doctor_id'] ?? '';

if ($doctorId) {
    $query = "SELECT monday, tuesday, wednesday, thursday, friday, saturday, sunday, time_slot1, time_slot2 FROM doctor WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $availability = $result->fetch_assoc();
    $stmt->close();
    
    if ($availability) {
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            if ($availability[$day]) {
                echo ucfirst($day) . ": " . htmlspecialchars($availability['time_slot1']) . " - " . htmlspecialchars($availability['time_slot2']) . "<br>";
            }
        
        }
    } else {
        echo "No availability information found.";
    }
    echo "<div id='war-msg' style='color: red;'>Select Appointment Time as per Doctor's Availability.<br>Incorrect appointments are cancelled.</div>";

} else {
    echo "Invalid doctor ID.";
}

$conn->close();
?>
