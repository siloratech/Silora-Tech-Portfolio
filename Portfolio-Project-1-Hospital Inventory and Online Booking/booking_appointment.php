<?php
session_start();
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctors from the database
$doctorQuery = "SELECT id, name FROM doctor";
$doctorResult = $conn->query($doctorQuery);

// Check if the query was successful
if ($doctorResult === false) {
    die("Error fetching doctors: " . $conn->error);
}

// Generate time slots in 15-minute intervals
function generateTimeSlots() {
    $slots = [];
    $startTime = strtotime('09:00');
    $endTime = strtotime('17:00');
    while ($startTime <= $endTime) {
        $time = date('H:i', $startTime);
        $slots[] = $time;
        $startTime = strtotime('+15 minutes', $startTime);
    }
    return $slots;
}

$timeSlots = generateTimeSlots();

// Get tomorrow's date
$defaultDate = date('Y-m-d', strtotime('+1 day'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Doctor Appointment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group label.required::after {
            content: '*';
            color: red;
            margin-left: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .availability-status {
            margin-top: 10px;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .required-note {
            font-style: italic;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- ======= Head ======= -->
    <div class="row">
        <?php include 'include/head.php'; ?>
    </div>

    <!-- ======= Top Bar ======= -->
    <div class="row">
        <?php include 'include/topbar.php'; ?>
    </div>

    <!-- ======= Header ======= -->
    <div class="row">
        <?php include 'include/header.php'; ?>
    </div>
    

    <div class="form-container" style="margin-top: 180px;">
    <div class="section-title">
    <h2>Book Doctor Appointment</h2>
    </div>       
        <form id="appointment-form">
            <div class="form-group">
                <label for="doctor" class="required"><strong>Choose Doctor:</strong></label>
                <select id="doctor" name="doctor" required>
                    <option value="" disabled selected>Select Doctor</option>
                    <?php
                    if ($doctorResult->num_rows > 0) {
                        while ($row = $doctorResult->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No doctors available</option>";
                    }
                    ?>
                </select>
                <input type="hidden" id="doctor-id" name="doctor_id">
            </div>
            <div id="working-hours" class="form-group">
                <label><strong>Working Hours:</strong></label>
                <div id="working-hours-details"></div>
            </div>
            <div class="form-group">
                <label for="date" class="required"><strong>Choose Date:</strong></label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($defaultDate); ?>" required>
            </div>
            <div class="form-group">
                <label for="time" class="required"><strong>Choose Time:</strong></label>
                <select id="time" name="time" required>
                    <?php
                    foreach ($timeSlots as $slot) {
                        echo "<option value='" . htmlspecialchars($slot) . "'>" . htmlspecialchars($slot) . "</option>";
                    }
                    ?>
                </select>
            </div>
            
            <button type="button" class="btn-custom" onclick="checkAvailability()"><strong>Check Availability</strong></button>
            <div class="availability-status" id="availability-status"></div>
            <div class="error-message" id="error-message"></div>
            <div class="form-group">
                <label for="patient-name" class="required"><strong>Patient Name:</strong></label>
                <input type="text" id="patient-name" name="patient_name" required>
            </div>
            <div class="form-group">
                <label for="patient-phone" class="required"><strong>Patient Phone No:</strong></label>
                <input type="text" id="patient-phone" name="patient_phone" required maxlength="10" pattern="\d{10}">
            </div>
            <button type="button" class="btn-custom" onclick="bookAppointment()" id="book-button" style="display: none;">Book Appointment</button>
            <div id="booking-id" style="font-weight: bold; margin-top: 10px;"></div>
        </form>
        <div class="required-note">
            <p><span style="color: red;">*</span> Marked fields are required.</p>
        </div>
    </div>
<!-- ======= Footer ======= -->
<div class="row" style="margin-top: 100px;">
    <?php include 'include/footer.php'; ?>
  </div><!-- End Footer -->
    <script>
        document.getElementById('doctor').addEventListener('change', function() {
            var doctorId = this.value;
            document.getElementById('doctor-id').value = doctorId;

            if (doctorId) {
                $.ajax({
                    url: 'controller/fetch_doctor_availability.php',
                    type: 'POST',
                    data: { doctor_id: doctorId },
                    success: function(response) {
                        $('#working-hours-details').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        $('#working-hours-details').text('An error occurred while fetching working hours.');
                    }
                });
            } else {
                $('#working-hours-details').empty();
            }
        });

        function checkAvailability() {
            var doctorId = $('#doctor').val();
            var date = $('#date').val();
            var time = $('#time').val();

            if (!doctorId || !date || !time) {
                alert('Please fill all required fields.');
                return;
            }

            $.ajax({
                url: 'check_availability.php',
                type: 'POST',
                data: { doctor_id: doctorId, date: date, time: time },
                success: function(response) {
                    if (response.trim() === 'Available') {
                        $('#availability-status').text('Available').css('color', 'green');
                        $('#book-button').show();
                    } else if (response.trim() === 'Unavailable') {
                        $('#availability-status').text('Unavailable').css('color', 'red');
                        $('#book-button').hide();
                    } else {
                        $('#availability-status').text('Unexpected response').css('color', 'red');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    $('#availability-status').text('An error occurred while checking availability.').css('color', 'red');
                }
            });
        }

        function bookAppointment() {
            var doctorId = $('#doctor').val();
            var date = $('#date').val();
            var time = $('#time').val();
            var patientName = $('#patient-name').val();
            var patientPhone = $('#patient-phone').val();

            if (!doctorId || !date || !time || !patientName || !patientPhone) {
                alert('Please fill all required fields.');
                return;
            }

            if (patientPhone.length !== 10) {
                alert('Phone number must be 10 digits.');
                return;
            }

            $.ajax({
                url: 'book_appointment.php',
                type: 'POST',
                data: { 
                    doctor_id: doctorId, 
                    date: date, 
                    time: time, 
                    patient_name: patientName, 
                    patient_phone: patientPhone 
                },
                success: function(response) {
                    $('#booking-id').text('' + response);
                    $('#availability-status').empty();
                    $('#error-message').empty();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    $('#error-message').text('An error occurred while booking the appointment.').css('color', 'red');
                }
            });
        }

        $(document).ready(function() {
            $('#patient-name, #patient-phone').on('input', function() {
                var patientName = $('#patient-name').val().trim();
                var patientPhone = $('#patient-phone').val().trim();
                var phoneValid = /^\d{10}$/.test(patientPhone);

                if (patientName && phoneValid) {
                    $('#book-button').show();
                } else {
                    $('#book-button').hide();
                }
            });
        });
    </script>
</body>
</html>
