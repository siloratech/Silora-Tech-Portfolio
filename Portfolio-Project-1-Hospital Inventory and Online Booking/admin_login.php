<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Login</title>
</head>
<body>
  <?php
  session_start();

  // Check if admin is already logged in
  if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
      header('Location: admin_home.php');
      exit;
  }
  ?>

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

  <main id="main" style="margin-top: 100px;">
    <!-- ======= Admin Login Section ======= -->
    <section id="login" class="login">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Admin Login</h2>
          <p>Test Credentials=> Username: <b>xvy64</b> Password: <b>xvy64</b></p>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <form id="loginForm" method="post" action="controller/ad_login.php">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary" style="background: #3fbbc0; color: #fff; border: 2px solid #3fbbc0; margin-top: 10px;">Log In</button>
              </div>
              <!-- Display error message if present -->
              <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
                <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                  Invalid username or password.
                </div>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Admin Login Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <div class="row">
    <?php include 'include/footer.php'; ?>
  </div>
  <!-- End Footer -->

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
