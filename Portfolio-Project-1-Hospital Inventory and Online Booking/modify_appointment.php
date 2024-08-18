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

$appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;

$query = "SELECT * FROM appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("Query failed: " . $stmt->error);
}

if ($result->num_rows === 0) {
    echo "No appointment found with the provided ID.";
    exit();
}

$appointment = $result->fetch_assoc();

// Fetch doctor names for the dropdown
$queryDoctors = "SELECT id, name FROM doctor";
$resultDoctors = $conn->query($queryDoctors);
if (!$resultDoctors) {
    die("Query failed: " . $conn->error);
}
$doctors = [];
while ($row = $resultDoctors->fetch_assoc()) {
    $doctors[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Appointment</title>
    <style>
        .btn-custom {
            background-color: #3fbbc0;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .btn-custom:hover {
            background-color: #33a7a3;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-group select {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- ======= Head ======= -->
    <div class="row">
        <?php include 'include/head.php'; ?>
    </div>

    <!-- ======= Header ======= -->
    <div class="row">
        <?php include 'include/admin_navbar.php'; ?>
    </div>

    <div class="container" style="margin-top: 150px;">
        <div class="section-title">
            <h2>Modify Appointment</h2>
        </div>

        <div class="form-container">
            <form action="update_appointment.php" method="post">
                <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">

                <div class="form-group">
                    <label for="patient_name">Patient Name:</label>
                    <input type="text" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($appointment['patient_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="patient_email">Patient Phone No:</label>
                    <input type="text" id="patient_email" name="patient_email" value="<?php echo htmlspecialchars($appointment['patient_phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="doctor_id">Doctor:</label>
                    <select id="doctor_id" name="doctor_id" required>
                        <option value="">Select Doctor</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?php echo htmlspecialchars($doctor['id']); ?>" <?php echo ($doctor['id'] == $appointment['doctor_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($doctor['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Date:</label>
                    <input type="date" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="appointment_time">Time:</label>
                    <input type="time" id="appointment_time" name="appointment_time" value="<?php echo htmlspecialchars($appointment['appointment_time']); ?>" required>
                </div>

                <button type="submit" class="btn-custom">Update Appointment</button>
                <a href="manage_appointments.php" class="btn-custom">Cancel</a>
            </form>
        </div>
    </div>

   <!-- ======= Footer ======= -->
  <div class="row">
    <?php include 'include/admin_footer.php'; ?>
  </div><!-- End Footer -->
</body>
</html>

<?php
$conn->close();
?>
