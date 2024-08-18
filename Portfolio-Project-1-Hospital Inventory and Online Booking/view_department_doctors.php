<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctors by Department</title>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

  <div class="row">
    <?php include 'include/head.php'; ?>
  </div>

  <div class="row">
    <?php include 'include/topbar.php'; ?>
  </div>

  <div class="row">
    <?php include 'include/header.php'; ?>
  </div>

  <main id="main" style="margin-top: 150px;">
    <div class="container">
      <div class="section-title">
        <h2>Doctors List - <?php echo htmlspecialchars($_GET['department']); ?></h2>
      </div>

      <div class="search-container">
        <input type="text" id="search" class="form-control search-box" placeholder="Enter doctor name or ID">
        <button class="btn-custom" onclick="searchDoctor()">Search</button>
      </div>

      <div id="doctor-list">
        <?php include 'controller/search_doctor_department.php'; ?>
      </div>

    </div>
  </main>

  <div class="row" style="margin-top: 50px;">
    <?php include 'include/footer.php'; ?>
  </div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
    function searchDoctor() {
      var search = $('#search').val();
      if (search === '') {
        alert("Please enter a search term");
      } else {
        $.ajax({
          url: 'controller/search_doctor_department.php',
          type: 'GET',
          data: { search: search, department: '<?php echo urlencode($_GET['department']); ?>' },
          success: function(data) {
            $('#doctor-list').html(data);
          }
        });
      }
    }
  </script>
</body>
</html>
