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

// Prepare base query
$query = "SELECT lb.id, lb.test_id, lb.booking_date, lb.booking_time, lb.patient_name, lb.patient_phone, t.testname, lb.status
          FROM lab_bookings lb
          JOIN labtests t ON lb.test_id = t.testid";

// Check if there's a search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchQuery) {
    $searchQuery = "%$searchQuery%";
    $query .= " WHERE lb.id LIKE ?";
}

// Add ordering to the query
$query .= " ORDER BY lb.booking_date DESC, lb.booking_time DESC";

// Prepare and execute the query
$stmt = $conn->prepare($query);
if ($searchQuery) {
    $stmt->bind_param("s", $searchQuery);
}
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("Query failed: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Appointments</title>
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

        .btn-cancel {
            background-color: #f44336;
        }

        .btn-cancel:hover {
            background-color: #c62828;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3fbbc0;
            color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-box {
            flex: 1;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .search-button {
            margin-left: 10px;
        }
    </style>
    <script>
        function searchLabBooking() {
            var searchValue = document.getElementById('search').value;
            window.location.href = "scheduled_labtest.php?search=" + encodeURIComponent(searchValue);
        }

        function confirmCancel(id) {
            if (confirm("Are you sure you want to cancel this appointment?")) {
                window.location.href = "cancel_appointment.php?id=" + id;
            }
        }
    </script>
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

    <div class="container" style="margin-top: 180px;">
        <!-- Search Box -->
        <div class="search-container">
            <input type="text" id="search" class="form-control search-box" placeholder="Enter Booking ID. E.g. 2165">
            <button class="btn-custom search-button" onclick="searchLabBooking()">Search</button>
        </div>

        <div class="section-title">
            <h2>Scheduled Lab Appointments</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Test Name</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>Patient Name</th>
                    <th>Patient Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $status = htmlspecialchars($row['status']);
                        $id = htmlspecialchars($row['id']);
                        $cancelButton = $status !== 'Cancelled' ? "<button class='btn-custom btn-cancel' onclick='confirmCancel($id)'>Cancel</button>" : '';
                        $modifyButton = $status !== 'Cancelled' ? "<a href='modify_testappointment.php?id=$id' class='btn-custom'>Modify</a>" : '';
                        echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['testname']) . "</td>
                            <td>" . htmlspecialchars($row['booking_date']) . "</td>
                            <td>" . htmlspecialchars($row['booking_time']) . "</td>
                            <td>" . htmlspecialchars($row['patient_name']) . "</td>
                            <td>" . htmlspecialchars($row['patient_phone']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>$modifyButton $cancelButton</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No appointments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
