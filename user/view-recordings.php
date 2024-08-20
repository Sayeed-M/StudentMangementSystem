<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Get the student_id from the session
    $student_id = $_SESSION['sturecmsaid'];

    // Prepare the SQL query to fetch recordings for the specific student_id
    $sql = "SELECT * FROM recordings WHERE student_id = :student_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System || View Recordings</title>
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
                        <h3 class="page-title"> View Recordings </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> <a href="view-rec1.php">View Recordings</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <?php
                        // Check if there are any recordings for the student
                        if ($query->rowCount() > 0) {
                            // Loop through and display each recording
                            foreach($results as $row) {
                        ?>
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo htmlentities($row->title); ?></h4>
                                    <a href="<?php echo htmlentities($row->drive_link); ?>" target="_blank">View Recording</a>
                                    <p>Uploaded on: <?php echo htmlentities($row->creation_date); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<p>No recordings found.</p>";
                        }
                        ?>
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
<?php } ?>
