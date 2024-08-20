<?php
session_start();
include('includes/dbconnection.php');

// Debug: Print the session value
echo "Student ID from session: " . $_SESSION['sturecmsaid'];

$student_id = $_SESSION['sturecmsaid'];

if (strlen($student_id) == 0) {
    header('location:logout.php');
} else {
    $sql = "SELECT title, drive_link, creation_date FROM recordings WHERE student_id = :student_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
    $query->execute();
    
    // Debug: Check the number of recordings found
    echo "Number of recordings found: " . $query->rowCount();

    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        echo '<table border="1" cellspacing="0" cellpadding="10">';
        echo '<tr><th>Title</th><th>Drive Link</th><th>Creation Date</th></tr>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row->title) . '</td>';
            echo '<td><a href="' . htmlspecialchars($row->drive_link) . '" target="_blank">View</a></td>';
            echo '<td>' . htmlspecialchars($row->creation_date) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No recordings found.</p>';
    }
}
?>
