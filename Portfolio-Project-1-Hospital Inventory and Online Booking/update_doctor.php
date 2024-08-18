<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Check if session is set, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php?message=login_first');
    exit;
}

// Database configuration
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get doctor ID from URL
$doctor_id = intval($_GET['id']);

// Fetch current values for the doctor
$sql = "SELECT * FROM doctor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
?>

<head>
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

    .btn-delete {
      background-color: #e74c3c;
    }

    .btn-delete:hover {
      background-color: #c0392b;
    }

    .card {
      width: 100%;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      overflow: hidden;
      padding: 10px;
    }

    .card img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 0;
    }

    .card-body {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .card-content {
      flex: 1;
    }

    .form-buttons {
      text-align: center;
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

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination a {
      padding: 10px 20px;
      margin: 0 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      color: #333;
      text-decoration: none;
    }

    .pagination a.active {
      background-color: #3fbbc0;
      color: #fff;
      border: 1px solid #3fbbc0;
    }

    .pagination a:hover {
      background-color: #33a7a3;
      color: #fff;
    }

    .days-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px; /* Adjust the spacing between days as needed */
    }

    .days-container label {
      margin: 0;
    }
  </style>
  <!-- Include jQuery for AJAX functionality -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Update Doctor</title>
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

  <main id="main" style="margin-top: 100px;">
    <!-- ======= Update Doctor Section ======= -->
    <section id="update-doctor" class="update-doctor">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Update Doctor</h2>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <form action="controller/update_doctor.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo htmlspecialchars($doctor['id']); ?>">

              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
              </div>

              <div class="form-group">
                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" class="form-control" value="<?php echo htmlspecialchars($doctor['designation']); ?>" required>
              </div>

              <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" class="form-control" value="<?php echo htmlspecialchars($doctor['department']); ?>" required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
              </div>

              <div class="form-group">
                <label for="biography">Biography:</label>
                <textarea id="biography" name="biography" class="form-control" required><?php echo htmlspecialchars($doctor['biography']); ?></textarea>
              </div>

              <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" id="photo" name="photo" class="form-control-file">
                <?php if (!empty($doctor['photo'])): ?>
                  <img src="uploads/<?php echo htmlspecialchars($doctor['photo']); ?>" alt="Doctor's photo" style="width: 100px; margin-top: 10px;">
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label>Working Hours:</label><br>
                <div class="days-container">
  <label><input type="checkbox" name="monday" value="Monday" <?php echo $doctor['monday'] === 'Monday' ? 'checked' : ''; ?>> Monday</label>
  <label><input type="checkbox" name="tuesday" value="Tuesday" <?php echo $doctor['tuesday'] === 'Tuesday' ? 'checked' : ''; ?>> Tuesday</label>
  <label><input type="checkbox" name="wednesday" value="Wednesday" <?php echo $doctor['wednesday'] === 'Wednesday' ? 'checked' : ''; ?>> Wednesday</label>
  <label><input type="checkbox" name="thursday" value="Thursday" <?php echo $doctor['thursday'] === 'Thursday' ? 'checked' : ''; ?>> Thursday</label>
  <label><input type="checkbox" name="friday" value="Friday" <?php echo $doctor['friday'] === 'Friday' ? 'checked' : ''; ?>> Friday</label>
  <label><input type="checkbox" name="saturday" value="Saturday" <?php echo $doctor['saturday'] === 'Saturday' ? 'checked' : ''; ?>> Saturday</label>
  <label><input type="checkbox" name="sunday" value="Sunday" <?php echo $doctor['sunday'] === 'Sunday' ? 'checked' : ''; ?>> Sunday</label>
</div>
              </div>

              <div class="form-group">
                <br>
                <label for="time_slots">Time Slots:</label><br>
                <input type="text" id="time_slot1" name="time_slots[]" class="form-control" value="<?php echo htmlspecialchars($doctor['time_slot1']); ?>" placeholder="Time Slot 1"><br>
                <input type="text" id="time_slot2" name="time_slots[]" class="form-control" value="<?php echo htmlspecialchars($doctor['time_slot2']); ?>" placeholder="Time Slot 2">
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary" style="background: #3fbbc0; color: #fff; border: 2px solid #3fbbc0; margin-top: 10px;">Update</button>
                <a href="view_doctors.php" class="btn btn-secondary" style="margin-top: 10px;">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Update Doctor Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <div class="row">
    <?php include 'include/admin_footer.php'; ?>
  </div><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Redirect with popup message -->
  <script>
    // Check if there's a message in the URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message') && urlParams.get('message') === 'login_first') {
      alert('Login as admin first.');
    }
  </script>

</body>
</html>
