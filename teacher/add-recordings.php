<!-- Replace the form field for uploading recordings with a text input field -->
<div class="form-group">
    <label for="drive_link">Google Drive Link</label>
    <input type="text" name="drive_link" class="form-control" required="true">
</div>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $student_id = $_POST['student_id'];
        $title = $_POST['title'];
        $drive_link = $_POST['drive_link'];

        try {
            $sql = "INSERT INTO recordings (student_id, title, drive_link) VALUES (:student_id, :title, :drive_link)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':drive_link', $drive_link, PDO::PARAM_STR);
            $query->execute();
            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>alert("Recording has been added.")</script>';
                echo "<script>window.location.href ='add-recordings.php'</script>";
            } else {
                echo '<script>alert("Something Went Wrong. Please try again.")</script>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Management System || Add Recordings</title>
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once('includes/sidebar.php'); ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title"> Add Recordings </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Add Recordings</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="text-align: center;">Add Recordings</h4>
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="student_id">Student ID</label>
                      <input type="text" name="student_id" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                      <label for="title">Recording Title</label>
                      <input type="text" name="title" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                      <label for="drive_link">Google Drive Link</label>
                      <input type="text" name="drive_link" class="form-control" required="true">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Add Recording</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
      </div>
    </div>
  </div>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
</body>
</html>
