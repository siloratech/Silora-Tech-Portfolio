<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // Redirect to login page with an alert message
    header("Location: ./admin_login.php?message=login_first");
    exit();
}

// Display success message if set
if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
    echo "<script>alert('Admin details updated successfully.');</script>";
    unset($_SESSION['update_success']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Test</title>
  <!-- Include CSS and JS files here -->
  <style>
    .stats {
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 5px;
      background-color: #f8f9fa;
      text-align: center; /* Center text horizontally */
    }
    .stats h3 {
      margin-bottom: 10px;
      font-size: 1.5rem;
      color: #3fbbc0;
    }
    .stats p {
      font-size: 1.5rem; /* Increase font size for visibility */
      margin: 0;
      font-weight: bold; /* Make the count bold */
    }
    .card {
      margin-bottom: 20px;
    }
    .form-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
    }
    .form-container h2 {
      text-align: center;
      color: #3fbbc0;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-group input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .form-group button {
      width: 100%;
      padding: 10px;
      background-color: #3fbbc0;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .form-group button:hover {
      background-color: #36a2a4;
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
  
  <main id="main" style="margin-top: 180px;">
  <div class="section-title">
  <h2>Add New Test</h2>
        </div>
    <div class="form-container">

      <form action="add_test.php" method="post">
        <div class="form-group">
          <label for="testname">Test Name</label>
          <input type="text" id="testname" name="testname" required>
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" required>
        </div>
        <div class="form-group">
          <button type="submit">Add Test</button>
        </div>
      </form>
    </div>
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

    // Fetch counts and update the page
    fetch('count.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById('doctor-count').textContent = data.doctor_count;
        document.getElementById('wholesale-medicine-count').textContent = data.wholesale_medicine_count;
        document.getElementById('retail-medicine-count').textContent = data.retail_medicine_count;
      })
      .catch(error => console.error('Error fetching counts:', error));
  </script>

</body>

</html>
