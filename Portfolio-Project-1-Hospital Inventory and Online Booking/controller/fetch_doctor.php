<?php
// Database configuration
include 'db_con.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Fetch doctor details
$sql = "SELECT id, name, designation, department, availability, email, biography, photo FROM doctor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($id, $name, $designation, $department, $availability, $email, $biography, $photo);
$stmt->fetch();
$stmt->close();

echo '
<div class="card">
  <div class="card-body">
    <form id="update-doctor-form" enctype="multipart/form-data">
      <input type="hidden" name="id" value="' . $id . '">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="' . $name . '">
      </div>
      <div class="mb-3">
        <label for="designation" class="form-label">Designation</label>
        <input type="text" class="form-control" id="designation" name="designation" value="' . $designation . '">
      </div>
      <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <input type="text" class="form-control" id="department" name="department" value="' . $department . '">
      </div>
      <div class="mb-3">
        <label for="availability" class="form-label">Availability</label>
        <input type="text" class="form-control" id="availability" name="availability" value="' . $availability . '">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="' . $email . '">
      </div>
      <div class="mb-3">
        <label for="biography" class="form-label">Biography</label>
        <textarea class="form-control" id="biography" name="biography">' . $biography . '</textarea>
      </div>
      <div class="mb-3">
        <label for="photo" class="form-label">Upload New Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
      </div>
      <button type="button" class="btn" style="background-color: #3fbbc0; color: #fff;" onclick="updateDoctor()">Update</button>
      <button type="button" class="btn" style="background-color: #3fbbc0; color: #fff;" onclick="cancelUpdate()">Cancel</button>
    </form>
  </div>
</div>
';

$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateDoctor() {
  var formData = new FormData(document.getElementById('update-doctor-form'));
  $.ajax({
    url: 'controller/update_doctor.php',
    type: 'POST',
    data: formData,
    processData: false, // Important for file uploads
    contentType: false, // Important for file uploads
    success: function(response) {
      alert('Doctor updated successfully');
      location.reload();
    }
  });
}

function cancelUpdate() {
  $('#doctor-details').html('');
}
</script>
