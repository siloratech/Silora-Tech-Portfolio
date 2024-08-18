<!DOCTYPE html>
<html lang="en">
<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redirect to login if session is not set
if (!isset($_SESSION['admin_userid'])) {
    header("Location: admin_login.php?message=login_first");
    exit();
}

// Database configuration
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get medicine ID from the URL
if (isset($_GET['id'])) {
    $medicine_id = $_GET['id'];

    // Fetch medicine details including category
    $stmt = $conn->prepare("SELECT name, description, brand, manufacturer, price, quantity_available, expiry_date, batch_number, dosage_form, strength, prescription_required, category FROM medicines WHERE medicine_id = ?");
    $stmt->bind_param("i", $medicine_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $medicine = $result->fetch_assoc();

    if (!$medicine) {
        echo "Medicine not found.";
        exit();
    }
} else {
    echo "No medicine ID provided.";
    exit();
}

$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .btn-custom {
            background-color: #3fbbc0;
            color: #fff;
            border: none;
            padding: 8px 16px; /* Reduced padding for smaller button */
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px; /* Smaller font size for the button */
            margin: 5px;
        }

        .btn-custom:hover {
            background-color: #33a7a3;
        }

        .container {
            width: 50%;
            margin: 20px auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 6px; /* Reduced padding for smaller input fields */
            box-sizing: border-box;
            font-size: 14px; /* Smaller font size for the input fields */
        }

        .form-group textarea {
            resize: vertical; /* Allow vertical resizing only */
            height: 100px; /* Set a fixed height for textareas */
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

    <main id="main" style="margin-top: 200px;">
        <div class="container">
            <div class="section-title">
                <h2>Update Medicine Details</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="controller/update_medicine.php" method="POST">
                        <input type="hidden" name="medicine_id" value="<?php echo htmlspecialchars($medicine_id, ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="form-group">
                            <label for="name">Medicine Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($medicine['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description"><?php echo htmlspecialchars($medicine['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($medicine['brand'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="manufacturer">Manufacturer</label>
                            <input type="text" id="manufacturer" name="manufacturer" value="<?php echo htmlspecialchars($medicine['manufacturer'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="price">Price (Rs)</label>
                            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($medicine['price'], ENT_QUOTES, 'UTF-8'); ?>" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="batch_number">Discount (%)</label>
                            <input type="text" id="batch_number" name="batch_number" value="<?php echo htmlspecialchars($medicine['batch_number'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="dosage_form">Price after Discount (Rs)</label>
                            <input type="text" id="dosage_form" name="dosage_form" value="<?php echo htmlspecialchars($medicine['dosage_form'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="quantity_available">Quantity Available</label>
                            <input type="number" id="quantity_available" name="quantity_available" value="<?php echo htmlspecialchars($medicine['quantity_available'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        

                        <div class="form-group">
                            <label for="strength">Strength</label>
                            <input type="text" id="strength" name="strength" value="<?php echo htmlspecialchars($medicine['strength'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="prescription_required">Prescription Required</label>
                            <select id="prescription_required" name="prescription_required" required>
                                <option value="yes" <?php echo ($medicine['prescription_required'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo ($medicine['prescription_required'] === 'no') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="Wholesale" <?php echo ($medicine['category'] === 'wholesale') ? 'selected' : ''; ?>>Wholesale</option>
                                <option value="Retail" <?php echo ($medicine['category'] === 'retail') ? 'selected' : ''; ?>>Retail</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-custom">Update Medicine</button>
                            <a href="view_retail_medicine.php" class="btn-custom">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

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

    <!-- JavaScript for dynamic calculation -->
    <script>
        function calculateDiscountedPrice() {
            const priceInput = document.getElementById('price');
            const discountInput = document.getElementById('batch_number');
            const discountedPriceInput = document.getElementById('dosage_form');

            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            const discountedPrice = price * (1 - discount / 100);
            discountedPriceInput.value = discountedPrice.toFixed(2); // Set the discounted price with 2 decimal places
        }

        document.getElementById('price').addEventListener('input', calculateDiscountedPrice);
        document.getElementById('batch_number').addEventListener('input', calculateDiscountedPrice);

        // Initial calculation on page load
        calculateDiscountedPrice();
    </script>

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
