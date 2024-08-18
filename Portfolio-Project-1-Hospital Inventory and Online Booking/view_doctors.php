<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctors</title>
  <style>
    .btn-custom {
      background-color: #3fbbc0;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin: 5px;
    }

    .btn-custom:hover {
      background-color: #33a7a3;
    }

    .btn-delete {
      background-color: #e74c3c;
    }

    .btn-delete:hover {
      background-color: #c0392b;
    }

    .card {
      width: 100%;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      overflow: hidden;
      padding: 10px;
    }

    .card img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 0;
    }

    .card-body {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .card-content {
      flex: 1;
    }

    .form-buttons {
      text-align: center;
    }

    .search-container {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .search-box {
      flex: 1;
      width: 300px;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination a {
      padding: 10px 20px;
      margin: 0 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      color: #333;
      text-decoration: none;
    }

    .pagination a.active {
      background-color: #3fbbc0;
      color: #fff;
      border: 1px solid #3fbbc0;
    }

    .pagination a:hover {
      background-color: #33a7a3;
      color: #fff;
    }
  </style>
  <!-- Include jQuery for AJAX functionality -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

  <main id="main" style="margin-top: 150px;">
    <div class="container">
      
      <!-- Search Box, Search Button, and Add New Doctor Button -->
      <div class="search-container">
        <input type="text" id="search" class="form-control search-box" placeholder="Enter doctor name or ID">
        <button class="btn-custom" onclick="searchDoctor()">Search</button>
        <a href="add_doctor.php" class="btn-custom">Add New Doctor</a>
      </div>

      <div class="section-title">
        <h2>Available Doctors</h2>
      </div>

      <!-- Doctors List -->
      <div id="doctor-list">
        <?php
        // Database configuration
        include 'controller/db_con.php';

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Set the number of results per page
        $results_per_page = 10;

        // Find out the number of pages
        $sql = "SELECT COUNT(id) AS total FROM doctor";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_results = $row['total'];
        $total_pages = ceil($total_results / $results_per_page);

        // Get the current page number from URL, default to 1 if not set
        if (!isset($_GET['page']) || $_GET['page'] < 1) {
            $current_page = 1;
        } else {
            $current_page = intval($_GET['page']);
        }

        // Calculate the starting row for the current page
        $start_row = ($current_page - 1) * $results_per_page;

        // Fetch doctors from the database for the current page
        $sql = "SELECT id, name, designation, department, availability, email, biography, monday, tuesday, wednesday, thursday, friday, saturday, sunday, time_slot1, time_slot2, photo FROM doctor LIMIT $start_row, $results_per_page";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Build working hours string
                $working_hours = '';

                if ($row["monday"] && $row["monday"] !== 'Not Available') {
                    $working_hours .= $row["monday"] . ', ';
                }
                if ($row["tuesday"] && $row["tuesday"] !== 'Not Available') {
                    $working_hours .= $row["tuesday"] . ', ';
                }
                if ($row["wednesday"] && $row["wednesday"] !== 'Not Available') {
                    $working_hours .= $row["wednesday"] . ', ';
                }
                if ($row["thursday"] && $row["thursday"] !== 'Not Available') {
                    $working_hours .= $row["thursday"] . ', ';
                }
                if ($row["friday"] && $row["friday"] !== 'Not Available') {
                    $working_hours .= $row["friday"] . ', ';
                }
                if ($row["saturday"] && $row["saturday"] !== 'Not Available') {
                    $working_hours .= $row["saturday"] . ', ';
                }
                if ($row["sunday"] && $row["sunday"] !== 'Not Available') {
                    $working_hours .= $row["sunday"] . ', ';
                }
                if ($row["time_slot1"] && $row["time_slot1"] !== 'Not Available') {
                    $working_hours .= $row["time_slot1"] . ' ,';
                }
                if ($row["time_slot2"] && $row["time_slot2"] !== 'Not Available') {
                    $working_hours .= $row["time_slot2"] . '<br>';
                }

                // Build card with delete button
                echo '
                  <div class="card">
                    <div class="card-body">
                      <table>
                      <tr>
                      <td style="padding-right: 20px;">
                          <img style="width: 300px; height: 300px; object-fit: cover; display: block; border: none; margin: 2; padding: 2; border-radius: 0;" src="uploads/' . $row["photo"] . '" alt="' . $row["name"] . '">
                      </td>
                      <td>
                      <div class="card-content">
                        <h5 class="card-title">' . $row["name"] . '</h5><br>
                        <p class="card-text"><strong>Designation:</strong> ' . $row["designation"] . '</p>
                        <p class="card-text"><strong>Department:</strong> ' . $row["department"] . '</p>
                        <p class="card-text"><strong>Email:</strong> ' . $row["email"] . '</p>
                        <p class="card-text"><strong>Biography:</strong> ' . $row["biography"] . '</p>
                        <p class="card-text"><strong>Working Hours:</strong><br>' . $working_hours . '</p>
                        <button class="btn-custom" onclick="window.location.href=\'update_doctor.php?id=' . $row["id"] . '\'">Update</button>
                        <button class="btn-custom btn-delete" onclick="confirmDelete(' . $row["id"] . ')">Delete</button>
                      </div>
                      </td>
                      </tr>
                      </table>
                    </div>
                  </div>';
            }
        } else {
            echo "No doctors found.";
        }

        // Pagination controls
        echo '<div class="pagination">';
        if ($current_page > 1) {
            echo '<a href="?page=' . ($current_page - 1) . '">Previous</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="?page=' . $i . '"' . ($i == $current_page ? ' class="active"' : '') . '>' . $i . '</a>';
        }
        if ($current_page < $total_pages) {
            echo '<a href="?page=' . ($current_page + 1) . '">Next</a>';
        }
        echo '</div>';

        $conn->close();
        ?>

      </div>
    </div>
  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <div class="row">
    <?php include 'include/admin_footer.php'; ?>
  </div><!-- End Footer -->


  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    function searchDoctor() {
    var query = $('#search').val();
    
    if (query.length > 0) {
        $.ajax({
            url: 'controller/search_doctor.php',
            type: 'GET',
            data: { search: query },
            success: function(data) {
                $('#doctor-list').html(data);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    } else {
        window.location.href = 'view_doctors.php';
    }
}

    function confirmDelete(doctorId) {
      var confirmation = confirm("Are you sure you want to delete this doctor?");
      if (confirmation) {
        // Redirect to delete script with the doctor's ID
        window.location.href = 'controller/delete_doctor.php?id=' + doctorId;
      }
    }
  </script>

</body>
</html>
