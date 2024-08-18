<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_userid'])) {
    header("Location: admin_login.php?message=login_first");
    exit();
}

include 'controller/db_con.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT appointments.*, doctor.name 
          FROM appointments 
          LEFT JOIN doctor ON appointments.doctor_id = doctor.id 
          WHERE appointments.appointment_id LIKE '%$search%' 
          ORDER BY appointments.appointment_date DESC, appointments.appointment_time DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
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

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-box {
            flex: 1;
            width: 300px;
        }

        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .appointment-table th, .appointment-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .appointment-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .btn-delete {
      background-color: #e74c3c;
     
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
            display: inline-block;
    }

    .btn-delete:hover {
      background-color: #c0392b;
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
          <h2>Manage Appointments</h2>
        </div>
    <div class="search-container">
        <input type="text" id="search" class="search-box" placeholder="Search by Appointment ID">
        <button class="btn-custom" onclick="searchAppointment()">Search</button>
    </div>

    <table class="appointment-table">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor ID</th>
                <th>Doctor Name</th>
                <th>Patient Name</th>
                <th>Patient Phone No.</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['appointment_id'] . "</td>";
                echo "<td>" . $row['doctor_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['patient_name'] . "</td>";
                echo "<td>" . $row['patient_phone'] . "</td>";
                echo "<td>" . $row['appointment_date'] . "</td>";
                echo "<td>" . $row['appointment_time'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>";
                if ($row['status'] != 'Cancelled') {
                    echo "<button class='btn-custom' onclick='modifyAppointment(" . $row['appointment_id'] . ")'>Modify</button>
                          <button class='btn-delete' onclick='deleteAppointment(" . $row['appointment_id'] . ")'>Cancel</button>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- ======= Footer ======= -->
<div class="row">
    <?php include 'include/admin_footer.php'; ?>
  </div><!-- End Footer -->

<script>
    function searchAppointment() {
        var search = document.getElementById('search').value;
        window.location.href = "manage_appointments.php?search=" + search;
    }

    function modifyAppointment(appointmentId) {
        window.location.href = "modify_appointment.php?appointment_id=" + appointmentId;
    }

    function deleteAppointment(appointmentId) {
        if (confirm("Are you sure you want to cancel this appointment?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_appointment.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Appointment cancelled successfully.');
                    location.reload();
                }
            };
            xhr.send("appointment_id=" + appointmentId);
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
