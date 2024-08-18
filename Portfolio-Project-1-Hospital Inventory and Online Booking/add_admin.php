<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Include necessary meta tags, CSS, and JavaScript files -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Admin</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Include other necessary CSS and JS files here -->
</head>

<body>

<?php
session_start();

// Check if session is set, redirect to login page if not
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php?message=login_first');
    exit;
}
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
    <!-- ======= Add Admin Section ======= -->
    <section id="add-admin" class="add-admin">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Add New Admin</h2>
        </div>

        <?php
        if (isset($_GET['message'])) {
            if ($_GET['message'] === 'admin_added') {
                echo '<div class="alert alert-success" role="alert">Admin added successfully!</div>';
            } elseif ($_GET['message'] === 'error') {
                echo '<div class="alert alert-danger" role="alert">Error adding admin. Please try again.</div>';
            }
        }
        ?>

        <form action="controller/add_admin_action.php" method="post">
          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="userid">UserID</label>
                <input type="text" class="form-control" id="userid" name="userid" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 text-center">
              <button type="submit" class="btn btn-primary">Add Admin</button>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- End Add Admin Section -->

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

</body>

</html>
