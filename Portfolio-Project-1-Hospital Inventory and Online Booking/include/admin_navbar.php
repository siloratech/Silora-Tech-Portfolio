<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>XVY Health Care Centre</title>
  <!-- Include CSS and JS files here -->
</head>
<body>

<header id="header" class="fixed-top">
  <div class="container d-flex align-items-center">
    <!-- Logo -->
    <a href="index.php" class="logo me-auto">
      <img src="assets/img/logo.png" alt="Admin Logo">
    </a>

    <!-- Navbar -->
    <nav id="navbar" class="navbar order-last order-lg-0">
      <ul>
        <!-- Welcome Message -->
        <?php
        $admin_name = isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin';
        ?>
        <li class="nav-item">
          <span class="navbar-text"><strong>Logged in as <?php echo $admin_name; ?></strong></span>
        </li>

        <!-- Admin Home -->
        <li><a class="nav-link scrollto" href="admin_home.php">Admin Home</a></li>

        <!-- Dropdown for Doctors -->
        <li class="dropdown">
          <a href="#" class="nav-link scrollto dropdown-toggle" data-bs-toggle="dropdown">Doctor</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="view_doctors.php">View All Doctors</a></li>
            <li><a class="dropdown-item" href="add_doctor.php">Add New Doctor</a></li>
          </ul>
        </li>

        <!-- Dropdown for Medicine -->
        <li class="dropdown">
          <a href="#" class="nav-link scrollto dropdown-toggle" data-bs-toggle="dropdown">Medicine</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="view_retail_medicine.php">View Retail Medicines</a></li>
            <li><a class="dropdown-item" href="view_wholesale_medicine.php">View Wholesale Medicines</a></li>
            <li><a class="dropdown-item" href="add_medicine.php">Add New Medicine</a></li>
          </ul>
        </li>

         <!-- Manage Appointment -->
         <li><a class="nav-link scrollto" href="manage_appointments.php">Manage Appointments</a></li>
         
         <!-- Dropdown for Lab test -->
        <li class="dropdown">
          <a href="#" class="nav-link scrollto dropdown-toggle" data-bs-toggle="dropdown">Lab Test</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="scheduled_labtest.php">Scheduled Tests</a></li>
            <li><a class="dropdown-item" href="view_labtest.php">View Available Tests</a></li>
            <li><a class="dropdown-item" href="add_labtest.php">Add New Test</a></li>
          </ul>
        </li>

        <!-- Dropdown for Settings -->
        <li class="dropdown">
          <a href="#" class="nav-link scrollto dropdown-toggle" data-bs-toggle="dropdown">Settings</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="add_admin.php">Add New Admin</a></li>
            <li><a class="dropdown-item" href="update_admin.php">Update Details</a></li>
            <li><a class="dropdown-item" href="delete_admin.php">Delete an Admin</a></li>
          </ul>
        </li>

        <!-- Logout -->
        <li><a class="nav-link scrollto" href="controller/logout.php">Logout</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
  </div>
</header><!-- End Header -->

</body>
</html>
