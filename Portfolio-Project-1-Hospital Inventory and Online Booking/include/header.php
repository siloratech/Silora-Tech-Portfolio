 <header id="header" class="fixed-top">
  <div class="container d-flex align-items-center">

    <a href="index.php" class="logo me-auto"><img src="assets/img/logo.png" alt=""></a>

    <nav id="navbar" class="navbar order-last order-lg-0">
      <ul>
        <li><a class="nav-link scrollto" href="index.php">Home</a></li>
        <li><a class="nav-link scrollto" href="index.php#about">About</a></li>
        <li><a class="nav-link scrollto" href="index.php#services">Services</a></li>
        <!-- View Medicines -->
        <li class="dropdown"><a href="#"><span>View Medicine</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                  <li><a href="retail-medicine.php">Retail</a></li>
                  <li><a href="wholesale-medicine.php">Wholesale</a></li>
                </ul>
        </li>
        
        <!-- View All Doctors -->
        <!-- <li><a href="doc_details.php"><span>Doctors</span></a></li> -->
        <!-- View Departmentwise Doctors -->
        <li class="dropdown">
          <a href="#"><span>Doctors</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <?php include 'include/fetch_departments.php'; ?>
            <?php foreach ($departments as $department): ?>
              <li><a href="view_department_doctors.php?department=<?= urlencode($department) ?>"><?= htmlspecialchars($department) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li><a class="nav-link scrollto" href="booking_appointment.php">Book Doctor Appointment</a></li>
        <li><a class="nav-link scrollto" href="book_labtest.php">Book Lab Test</a></li>
        <li><a class="nav-link scrollto" href="contact.php">Contact</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>

    <a href="admin_login.php" class="appointment-btn scrollto"><span class="d-none d-md-inline">Admin</span> Login</a>

  </div>
</header>
