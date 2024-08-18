<?php
session_start();
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch lab tests from the database
$testQuery = "SELECT testid, testname, price FROM labtests";
$testResult = $conn->query($testQuery);

// Check if the query was successful
if ($testResult === false) {
    die("Error fetching lab tests: " . $conn->error);
}

// Generate time slots in 30-minute intervals
function generateTimeSlots() {
    $slots = [];
    $startTime = strtotime('09:00');
    $endTime = strtotime('17:00');
    while ($startTime <= $endTime) {
        $time = date('H:i', $startTime);
        $slots[] = $time;
        $startTime = strtotime('+30 minutes', $startTime);
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
    <title>Book Lab Test</title>
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
            <h2>Book Lab Test</h2>
        </div>
        <form id="test-booking-form">
            <div class="form-group">
                <label for="test" class="required"><strong>Choose Lab Test:</strong></label>
                <select id="test" name="test" required>
                    <option value="" disabled selected>Select Test</option>
                    <?php
                    if ($testResult->num_rows > 0) {
                        while ($row = $testResult->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['testid']) . "' data-price='" . htmlspecialchars($row['price']) . "'>" . htmlspecialchars($row['testname']) . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No lab tests available</option>";
                    }
                    ?>
                </select>
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
            <div class="form-group">
                <label><strong>Price:</strong></label>
                <div id="price" style="font-weight: bold;"></div>
            </div>
            <div class="form-group">
                <label for="patient-name" class="required"><strong>Patient Name:</strong></label>
                <input type="text" id="patient-name" name="patient_name" required>
            </div>
            <div class="form-group">
                <label for="patient-phone" class="required"><strong>Patient Phone No:</strong></label>
                <input type="text" id="patient-phone" name="patient_phone" required maxlength="10" pattern="\d{10}">
            </div>
            <button type="button" class="btn-custom" onclick="bookTest()" id="book-button">Book Test</button>
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
        // Update the price display when a test is selected
        $('#test').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var price = selectedOption.data('price');
            $('#price').text(price ? 'Rs ' + price : 'N/A');
        });

        function bookTest() {
            var testId = $('#test').val();
            var date = $('#date').val();
            var time = $('#time').val();
            var patientName = $('#patient-name').val();
            var patientPhone = $('#patient-phone').val();

            if (!testId || !date || !time || !patientName || !patientPhone) {
                alert('Please fill all required fields.');
                return;
            }

            if (patientPhone.length !== 10) {
                alert('Phone number must be 10 digits.');
                return;
            }

            $.ajax({
                url: 'book_test.php',
                type: 'POST',
                data: { 
                    test_id: testId, 
                    date: date, 
                    time: time, 
                    patient_name: patientName, 
                    patient_phone: patientPhone 
                },
                success: function(response) {
                    $('#booking-id').text('Test Booked Successfully. Booking ID: ' + response+'. Get a cashback at hospital on this Booking ID.');
                    $('#test-booking-form')[0].reset();
                    $('#price').text('');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    $('#booking-id').text('An error occurred while booking the test.').css('color', 'red');
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
