<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Admin</title>
  <!-- Include CSS and JS files here -->
  <style>
    .btn-primary {
      background: #3fbbc0;
      color: #fff;
    }
  </style>
</head>
<body>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to login if session is not set
if (!isset($_SESSION['admin_userid'])) {
    header("Location: admin_login.php?message=login_first");
    exit();
}

// Display success message if admin details were updated
if (isset($_GET['message']) && $_GET['message'] === 'updated') {
    echo "<script>alert('Admin details updated successfully.');</script>";
}

// Database configuration
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if session variable is set
if (!isset($_SESSION['admin_userid'])) {
    echo "Session variable 'admin_userid' is not set.";
    exit();
}

// Fetch current admin details
$admin_id = $_SESSION['admin_userid']; // Assuming admin id is stored in session
$query = "SELECT * FROM udb_admin_log WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "Error fetching admin details.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!-- ======= Head ======= -->
<div class="row">
  <?php include 'include/head.php'; ?>
</div>

<!-- ======= Header ======= -->
<div class="row">
  <?php include 'include/admin_navbar.php'; ?>
</div>

<main id="main" style="margin-top: 100px;">
  <!-- ======= Update Admin Details Section ======= -->
  <section id="update-admin" class="update-admin">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Update Admin Details</h2>
      </div>

      <form action="controller/update_admin.php" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="userid">User ID</label>
              <input type="text" class="form-control" id="userid" name="userid" value="<?php echo htmlspecialchars($admin['userid']); ?>" required>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="current-password">Current Password</label>
              <input type="password" class="form-control" id="current-password" name="current-password" required>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="new-password">New Password (Optional)</label>
              <input type="password" class="form-control" id="new-password" name="new-password">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="confirm-password">Confirm New Password (Optional)</label>
              <input type="password" class="form-control" id="confirm-password" name="confirm-password">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-primary">Update Details</button>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- End Update Admin Details Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
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

</body>
</html>
