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

// Initialize variables
$testid = $testname = $price = "";

// Check if testid is provided
if (isset($_GET['testid'])) {
    $testid = intval($_GET['testid']);
    
    // Fetch the current details of the test
    $stmt = $conn->prepare("SELECT testname, price FROM labtests WHERE testid = ?");
    $stmt->bind_param("i", $testid);
    $stmt->execute();
    $stmt->bind_result($testname, $price);
    $stmt->fetch();
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $testid = intval($_POST['testid']);
    $testname = $_POST['testname'];
    $price = intval($_POST['price']);
    
    // Update the test details
    $stmt = $conn->prepare("UPDATE labtests SET testname = ?, price = ? WHERE testid = ?");
    $stmt->bind_param("sii", $testname, $price, $testid);
    
    if ($stmt->execute()) {
        $_SESSION['update_success'] = true;
    } else {
        $_SESSION['update_error'] = true;
    }
    
    $stmt->close();
    
    // Redirect back to the view_labtest.php page
    header("Location: view_labtest.php");
    exit();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Lab Test</title>
  <!-- Include CSS and JS files here -->
  <style>
    .form-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
    }
    .form-container h2 {
      margin-bottom: 20px;
      color: #3fbbc0;
    }
    .form-container label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-container input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 3px;
    }
    .form-container button {
      background-color: #3fbbc0;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 3px;
      cursor: pointer;
    }
    .form-container button:hover {
      background-color: #35a2a3;
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
      <h2>Edit Lab Test</h2>
    </div>
    <div class="form-container">
      <?php
      // Display success or error messages
      // if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
      //     echo "<script>alert('Test updated successfully.');</script>";
      //     unset($_SESSION['update_success']);
      // }
      // if (isset($_SESSION['update_error']) && $_SESSION['update_error']) {
      //     echo "<script>alert('Failed to update test.');</script>";
      //     unset($_SESSION['update_error']);
      // }
      ?>
      <form action="edit_test.php" method="post">
        <input type="hidden" name="testid" value="<?php echo htmlspecialchars($testid); ?>">
        <label for="testname">Test Name:</label>
        <input type="text" id="testname" name="testname" value="<?php echo htmlspecialchars($testname); ?>" required>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
        <button type="submit">Update Test</button>
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

</body>

</html>
