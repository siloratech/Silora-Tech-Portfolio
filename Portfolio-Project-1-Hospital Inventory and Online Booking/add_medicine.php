<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Include necessary meta tags, CSS, and JavaScript files -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Medicine</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Include other necessary CSS and JS files here -->
  <script>
    function calculateDiscountedPrice() {
      var price = parseFloat(document.getElementById('price').value) || 0;
      var discount = parseFloat(document.getElementById('batch_number').value) || 0;
      var discountedPrice = price - (price * (discount / 100));
      document.getElementById('dosage_form').value = discountedPrice.toFixed(2);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('price').addEventListener('input', calculateDiscountedPrice);
      document.getElementById('batch_number').addEventListener('input', calculateDiscountedPrice);
    });
  </script>
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
    <!-- ======= Add Medicine Section ======= -->
    <section id="add-medicine" class="add-medicine">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Add New Medicine</h2>
        </div>

        <form action="controller/add_medicine.php" method="post" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                  <option value="">Select Category</option>
                  <option value="wholesale">Wholesale</option>
                  <option value="retail">Retail</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand">
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="manufacturer">Manufacturer</label>
                <input type="text" class="form-control" id="manufacturer" name="manufacturer">
              </div>
            </div>
            
          </div>

          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="quantity_available">Quantity Available</label>
                <input type="number" class="form-control" id="quantity_available" name="quantity_available" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
              </div>
            </div>
          </div>
           

          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="batch_number">Discount</label>
                <input type="text" class="form-control" id="batch_number" name="batch_number">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="dosage_form">Discounted Price</label>
                <input type="text" class="form-control" id="dosage_form" name="dosage_form" readonly>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="strength">Strength</label>
                <input type="text" class="form-control" id="strength" name="strength">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="prescription_required">Prescription Required</label>
                <select class="form-control" id="prescription_required" name="prescription_required" required>
                  <option value="">Select Option</option>
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 text-center">
              <button type="submit" class="btn btn-primary">Add Medicine</button>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- End Add Medicine Section -->

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
