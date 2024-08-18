<!DOCTYPE html>
<html lang="en">
<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
include 'controller/db_con.php';

// Create connection
$conn_med = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn_med->connect_error) {
    die("Connection failed: " . $conn_med->connect_error);
}

// Fetch all Retail medicines
$query_med = "SELECT category, medicine_id, name, description, brand, manufacturer, price, quantity_available, expiry_date, batch_number, dosage_form, strength, prescription_required FROM medicines WHERE category = 'retail'";
$result_med = $conn_med->query($query_med);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Medicines</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            display: inline-block;
        }

        .btn-custom:hover {
            background-color: #33a7a3;
        }

        .container {
            width: 100%;
            margin: 20px auto;
        }

        .section-title h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-box {
            flex: 1;
            width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
        }
    </style>
</head>

<body>
    
  <!-- ======= Head ======= -->
  <div class="row">
    <?php include 'include/head.php'; ?>
  </div>

  <!-- ======= Top Bar ======= -->
  <div class="row">
    <?php include 'include/topbar.php'; ?>
  </div>

  <!-- ======= Header ======= -->
  <div class="row">
    <?php include 'include/header.php'; ?>
  </div>

    <main id="main" style="margin-top: 200px;">
        <div class="container">
        
        <!-- Search Box -->
        <div class="search-container">
            <input type="text" id="search" class="form-control search-box" placeholder="Enter Medicine ID. E.g. 1009">
            <button class="btn-custom" onclick="searchMedicine()">Search</button>
        </div>

        <div class="section-title">
            <h2>Available Retail Medicines</h2>
        </div>

        <!-- Medicines List -->
        <div id="medicine-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Brand</th>
                        <th>Manufacturer</th>
                        <th>Quantity Available</th>
                    
                        <th>Strength</th>
                        <th>Prescription Required</th>
                        <th>Price (Rs)</th>
                        <th>Discount (%)</th>
                        <th>Price after Discount (Rs)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_med->num_rows > 0) {
                        while ($row_med = $result_med->fetch_assoc()) {
                            echo '
                            <tr>
                                <td>' . htmlspecialchars($row_med["category"].'-'.$row_med["medicine_id"], ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["name"], ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["description"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["brand"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["manufacturer"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["quantity_available"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                              
                                <td>' . htmlspecialchars($row_med["strength"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["prescription_required"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["price"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["batch_number"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($row_med["dosage_form"] ?? 'Not Available', ENT_QUOTES, 'UTF-8') . '</td>
                              
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="13">No retail medicines found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        </div>
    </main>
    <!-- ======= Footer ======= -->
  <div class="row"style="margin-top: 50px;">
    <?php include 'include/footer.php'; ?>
  </div><!-- End Footer -->

    <!-- JavaScript -->
    <script>
        function searchMedicine() {
            const searchValue = document.getElementById('search').value;
            if (searchValue.trim() === '') {
                alert('Please enter a medicine ID to search.');
                return;
            }

            $.ajax({
                url: 'controller/search_medicine-fe.php',
                type: 'POST',
                data: { search_id: searchValue },
                success: function(response) {
                    $('#medicine-list').html(response);
                },
                error: function() {
                    alert('An error occurred while searching for the medicine.');
                }
            });
        }

        function confirmDelete(medicineId) {
            if (confirm('Are you sure you want to delete this medicine?')) {
                window.location.href = 'controller/delete_medicine.php?id=' + encodeURIComponent(medicineId);
            }
        }
    </script>
</body>
</html>
