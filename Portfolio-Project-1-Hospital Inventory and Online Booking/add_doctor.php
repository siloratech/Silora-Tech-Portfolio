<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Doctor</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php?message=login_first');
    exit;
}
?>

<div class="row">
  <?php include 'include/head.php'; ?>
</div>
<div class="row">
  <?php include 'include/topbar.php'; ?>
</div>
<div class="row">
  <?php include 'include/admin_navbar.php'; ?>
</div>
<main id="main" style="margin-top: 100px;">
  <section id="add-doctor" class="add-doctor">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Add New Doctor</h2>
      </div>
      <form action="controller/add_doctor.php" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="designation">Designation</label>
              <input type="text" class="form-control" id="designation" name="designation" required>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="department">Department</label>
              <input type="text" class="form-control" id="department" name="department" required>
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
          <div class="col-lg-12">
            <label>Availability (Days)</label>
            <div class="form-group d-flex flex-wrap">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="monday" name="monday">
                <label class="form-check-label" for="monday">Monday</label>
              </div>&nbsp;&nbsp;
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="tuesday" name="tuesday">
                <label class="form-check-label" for="tuesday">Tuesday</label>
              </div>&nbsp;&nbsp;
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="wednesday" name="wednesday">
                <label class="form-check-label" for="wednesday">Wednesday</label>
              </div>&nbsp;&nbsp;
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="thursday" name="thursday">
                <label class="form-check-label" for="thursday">Thursday</label>
              </div>&nbsp;&nbsp;
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="friday" name="friday">
                <label class="form-check-label" for="friday">Friday</label>
              </div>&nbsp;&nbsp;
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="saturday" name="saturday">
                <label class="form-check-label" for="saturday">Saturday</label>
              </div>&nbsp;&nbsp;
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="sunday" name="sunday">
                <label class="form-check-label" for="sunday">Sunday</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="time_slot1">Time Slot 1</label>
              <input type="text" class="form-control" id="time_slot1" name="time_slot1" placeholder="e.g., 9:00 AM - 12:00 PM">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="time_slot2">Time Slot 2 (Optional)</label>
              <input type="text" class="form-control" id="time_slot2" name="time_slot2" placeholder="e.g., 1:00 PM - 4:00 PM">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-lg-12">
            <div class="form-group">
              <label for="biography">Biography</label>
              <textarea class="form-control" id="biography" name="biography" rows="4" required></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-lg-12">
            <div class="form-group">
              <label for="photo">Upload Photo</label>
              <input type="file" class="form-control" id="photo" name="photo" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-primary">Add Doctor</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</main>
<!-- ======= Footer ======= -->
<div class="row">
    <?php include 'include/admin_footer.php'; ?>
  </div><!-- End Footer -->
<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
