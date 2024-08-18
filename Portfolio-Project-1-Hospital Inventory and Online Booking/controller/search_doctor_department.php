<?php
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$department = urldecode($_GET['department']);
$search = $_GET['search'] ?? '';

$query = "SELECT * FROM doctor WHERE department = ? AND (name LIKE ? OR id LIKE ?)";
$stmt = $conn->prepare($query);
$searchParam = '%' . $search . '%';
$stmt->bind_param("sss", $department, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Build working hours string
        $working_hours = '';
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'time_slot1', 'time_slot2'] as $day) {
            if ($row[$day] && $row[$day] !== 'Not Available') {
                $working_hours .= $row[$day] . ', ';
            }
        }

        // Remove the last comma and space
        $working_hours = rtrim($working_hours, ', ');

        // Build card with delete button
        echo '
          <div class="card">
            <div class="card-body">
              <table>
              <tr>
              <td style="padding-right: 20px;">
                  <img style="width: 300px; height: 300px; object-fit: cover; display: block; border: none; margin: 2; padding: 2; border-radius: 0;" src="uploads/' . $row["photo"] . '" alt="' . $row["name"] . '">
              </td>
              <td>
              <div class="card-content">
                <h5 class="card-title">' . $row["name"] . '</h5><br>
                <p class="card-text"><strong>Designation:</strong> ' . $row["designation"] . '</p>
                <p class="card-text"><strong>Department:</strong> ' . $row["department"] . '</p>
                <p class="card-text"><strong>Email:</strong> ' . $row["email"] . '</p>
                <p class="card-text"><strong>Biography:</strong> ' . $row["biography"] . '</p>
                <p class="card-text"><strong>Working Hours:</strong><br>' . $working_hours . '</p>
              </div>
              </td>
              </tr>
              </table>
            </div>
          </div>';
    }
} else {
    echo "No doctors found.";
}
?>
