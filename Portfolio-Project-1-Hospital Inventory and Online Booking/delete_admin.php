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

// Display success message if an admin was deleted
if (isset($_GET['message']) && $_GET['message'] === 'deleted') {
    echo "<script>alert('Admin deleted successfully.');</script>";
}

// Database configuration
include 'controller/db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_admin_id = $_SESSION['admin_userid'];

// Fetch all admins except the currently logged-in admin
$query = "SELECT name, email, userid FROM udb_admin_log WHERE userid != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $current_admin_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .delete-btn {
            background: #ff4d4d;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background: #ff1a1a;
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

    <main id="main" style="margin-top: 100px;">
        <!-- ======= Delete Admin Section ======= -->
        <section id="delete-admin" class="delete-admin">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Delete Admin</h2>
                </div>

                <table border="1" width="100%" cellpadding="10">
                    <thead>
                        <tr>
                            <th>Admin Name</th>
                            <th>Admin Email</th>
                            <th>UserID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($admin = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin['name']); ?></td>
                            <td><?php echo htmlspecialchars($admin['email']); ?></td>
                            <td><?php echo htmlspecialchars($admin['userid']); ?></td>
                            <td>
                                <button class="delete-btn" onclick="confirmDelete('<?php echo htmlspecialchars($admin['userid']); ?>')">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- End Delete Admin Section -->
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

    <!-- Custom JS for delete confirmation -->
    <script>
        function confirmDelete(userid) {
            if (confirm("Are you sure you want to delete this admin?")) {
                window.location.href = "controller/delete_admin_action.php?userid=" + encodeURIComponent(userid);
            }
        }
    </script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
