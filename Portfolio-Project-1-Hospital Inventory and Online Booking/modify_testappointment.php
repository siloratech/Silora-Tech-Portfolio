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

$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch appointment details
$query = "SELECT lb.id, lb.test_id, lb.booking_date, lb.booking_time, lb.patient_name, lb.patient_phone, t.testname
          FROM lab_bookings lb
          JOIN labtests t ON lb.test_id = t.testid
          WHERE lb.id = ?";
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

// Fetch test names for the dropdown
$queryTests = "SELECT testid, testname FROM labtests";
$resultTests = $conn->query($queryTests);
if (!$resultTests) {
    die("Query failed: " . $conn->error);
}
$tests = [];
while ($row = $resultTests->fetch_assoc()) {
    $tests[] = $row;
}

// Generate time slots dynamically
function generateTimeSlots($interval = 30, $start = '09:00', $end = '17:00') {
    $time_slots = [];
    $start_time = new DateTime($start);
    $end_time = new DateTime($end);
    $interval = new DateInterval('PT' . $interval . 'M');
    
    while ($start_time <= $end_time) {
        $time_slots[$start_time->format('H:i')] = $start_time->format('h:i A');
        $start_time->add($interval);
    }
    
    return $time_slots;
}

$time_slots = generateTimeSlots();
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
            <h2>Modify Lab test</h2>
        </div>

        <div class="form-container">
            <form action="update_labtest.php" method="post">
                <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">

                <div class="form-group">
                    <label for="patient_name">Patient Name:</label>
                    <input type="text" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($appointment['patient_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="patient_phone">Patient Phone:</label>
                    <input type="text" id="patient_phone" name="patient_phone" value="<?php echo htmlspecialchars($appointment['patient_phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="test_id">Test Name:</label>
                    <select id="test_id" name="test_id" required>
                        <option value="">Select Test</option>
                        <?php foreach ($tests as $test): ?>
                            <option value="<?php echo htmlspecialchars($test['testid']); ?>" <?php echo ($test['testid'] == $appointment['test_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($test['testname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="booking_date">Date:</label>
                    <input type="date" id="booking_date" name="booking_date" value="<?php echo htmlspecialchars($appointment['booking_date']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="booking_time">Time:</label>
                    <select id="booking_time" name="booking_time" required>
                        <?php foreach ($time_slots as $value => $label): ?>
                            <option value="<?php echo htmlspecialchars($value); ?>" <?php echo ($value == $appointment['booking_time']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-custom">Update Lab Test</button>
                <a href="scheduled_appointments.php" class="btn-custom">Cancel</a>
            </form>
        </div>
    </div>

    <!-- ======= Footer ======= -->
    <div class="row">
        <?php include 'include/admin_footer.php'; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
