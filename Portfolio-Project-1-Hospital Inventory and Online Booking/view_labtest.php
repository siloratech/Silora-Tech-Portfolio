<?php
session_start();

// Include database connection
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all lab tests
$sql = "SELECT testid, testname, price FROM labtests";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Lab Tests</title>
  <!-- Include CSS and JS files here -->
  <style>
    .table-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #3fbbc0;
      color: white;
    }
    .action-btns {
      display: flex;
      gap: 10px;
    }
    .btn-edit, .btn-delete, .btn-force-delete {
      padding: 5px 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      text-decoration: none;
      color: #fff;
    }
    .btn-edit {
      background-color: #4CAF50; /* Green */
    }
    .btn-delete {
      background-color: #f44336; /* Red */
    }
    .btn-force-delete {
      background-color: #ff9800; /* Orange */
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
      <h2>View Lab Tests</h2>
    </div>
    <div class="table-container">
      <?php
      // Display success or error messages
      if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']) {
          echo "<script>alert('Test deleted successfully.');</script>";
          unset($_SESSION['delete_success']);
      }
      if (isset($_SESSION['delete_error']) && $_SESSION['delete_error']) {
        echo "<script>alert('Bookings Associated with it. Use Force Delete to delete them too.');</script>";
          unset($_SESSION['delete_error']);
      }
      ?>
      <table>
        <thead>
          <tr>
            <th>Test ID</th>
            <th>Test Name</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              // Output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row["testid"]) . "</td>";
                  echo "<td>" . htmlspecialchars($row["testname"]) . "</td>";
                  echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                  echo "<td class='action-btns'>
                          <a href='edit_test.php?testid=" . htmlspecialchars($row["testid"]) . "' class='btn-edit'>Edit</a>
                          <a href='delete_test.php?testid=" . htmlspecialchars($row["testid"]) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this test?\");'>Delete</a>
                          
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='4'>No lab tests found</td></tr>";
          }
          ?>
        </tbody>
      </table>
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

</body>

</html>

<?php
// Close connection
$conn->close();
?>
