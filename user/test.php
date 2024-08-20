<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    $student_id = $_SESSION['sturecmsaid'];

    // Prepare the SQL query to fetch recordings for the specific student_id
    $sql = "SELECT * FROM recordings WHERE student_id = :student_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System || View Recordings</title>
    <!-- Add your CSS files here -->
</head>
<body>
    <!-- Include Header and Sidebar -->
    <div class="main-panel">
        <div class="content-wrapper">
            <h3 class="page-title"> View Recordings </h3>
            <div class="row">
                <?php
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
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
    </div>
</body>
</html>
