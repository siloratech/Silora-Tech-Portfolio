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
    echo '<div class="alert alert-success">' .'Admin details updated successfully.' . '</div>';
    unset($_SESSION['update_success']);
}

//Error message Doctor Deletion
if (isset($_SESSION['error_cannot_delete'])) {
  echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_cannot_delete']) . '</div>';
  unset($_SESSION['error_cannot_delete']); // Clear the message after displaying
}
//Error message Test Deletion
if (isset($_SESSION['delete_error'])) {
  echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['delete_error']) . '</div>';
  unset($_SESSION['delete_error']); // Clear the message after displaying
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home</title>
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
  
  <main id="main" style="margin-top: 130px;">

    <!-- ======= Admin Home Section ======= -->
    <section id="admin-home" class="admin-home">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Admin Home</h2>
        </div>
        <?php
            if (isset($_SESSION['medicine_add_success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['medicine_add_success']) . '</div>';
                unset($_SESSION['medicine_add_success']); // Clear the message after displaying
            }
            if (isset($_SESSION['doctor_add_success'])) {
              echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['doctor_add_success']) . '</div>';
              unset($_SESSION['doctor_add_success']); // Clear the message after displaying
           }
           if (isset($_SESSION['test_add_success'])) {
            echo '<div class="alert alert-success">' . "Lab Test Added" . '</div>';
            unset($_SESSION['test_add_success']); // Clear the message after displaying
         }

            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
                unset($_SESSION['error_message']); // Clear the message after displaying
            }
            

            ?>
        <!-- Stats Section -->
        <div class="row">
          <div class="col-lg-4 mb-4">
            <div class="stats">
              <h3>Doctor Appointments</h3>
              <p id="doctor-count">Loading...</p>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="stats">
              <h3>Lab Tests Booked</h3>
              <p id="wholesale-medicine-count">Loading...</p>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="stats">
              <h3>Available Medicines</h3>
              <p id="retail-medicine-count">Loading...</p>
            </div>
          </div>
        </div>

        <!-- Cards Section -->
        <div class="row">
          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">View Doctors</h5>
                <p class="card-text">Displays the list of all available doctors.</p>
                <a href="view_doctors.php" class="btn btn-primary">View Doctors</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Add Doctor</h5>
                <p class="card-text">Adds a new doctor to the system.</p>
                <a href="add_doctor.php" class="btn btn-primary">Add New Doctor</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Add Medicine</h5>
                <p class="card-text">Adds a new medicine to the inventory.</p>
                <a href="add_medicine.php" class="btn btn-primary">Add New Medicine</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">View Wholesale Medicine</h5>
                <p class="card-text">Displays the list of all available wholesale medicines.</p>
                <a href="view_wholesale_medicine.php" class="btn btn-primary">View Wholesale Medicine</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">View Retail Medicine</h5>
                <p class="card-text">Displays the list of all available retail medicines.</p>
                <a href="view_retail_medicine.php" class="btn btn-primary">View Retail Medicine</a>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Manage Appointments</h5>
                <p class="card-text">View and manage scheduled doctor appoinements.</p>
                <a href="manage_appointments.php" class="btn btn-primary">Manage Appointments</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">View Available Lab Tests</h5>
                <p class="card-text">Displays the list of all lab tests with options to modify.</p>
                <a href="view_labtest.php" class="btn btn-primary">View Lab Tests</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Add Lab Test</h5>
                <p class="card-text">Adds a new lab test.</p>
                <a href="add_labtest.php" class="btn btn-primary">Add Lab test</a>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Scheduled Lab Appointments</h5>
                <p class="card-text">View and manage lab tests bookings.</p>
                <a href="scheduled_labtest.php" class="btn btn-primary">View All Appointments</a>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    <!-- End Admin Home Section -->
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
