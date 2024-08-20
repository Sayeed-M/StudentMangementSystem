<?php
// Include database connection or other necessary files
$connectionFile = '../../db_connection.php'; // Adjust the path as needed
if (file_exists($connectionFile)) {
    include($connectionFile);
} else {
    die('Database connection file not found.');
}

// Function to fetch the record (replace this with your actual code to fetch the record)
function getRecord($recordId) {
    // Example code to fetch a record from the database using PDO
    global $pdo; // Assuming $pdo is your PDO connection object
    $stmt = $pdo->prepare("SELECT * FROM records WHERE id = :id");
    $stmt->execute(['id' => $recordId]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Get the record ID from the request (e.g., from a query parameter)
$recordId = isset($_GET['id']) ? $_GET['id'] : null;

if ($recordId) {
    $record = getRecord($recordId);

    // Check if the properties exist and are not null before accessing them
    $id = isset($record->id) ? htmlentities($record->id) : '';
    $student_id = isset($record->student_id) ? htmlentities($record->student_id) : '';
    $title = isset($record->title) ? htmlentities($record->title) : '';
    $drive_link = isset($record->drive_link) ? htmlentities($record->drive_link) : '';
    $creation_date = isset($record->creation_date) ? htmlentities($record->creation_date) : '';
} else {
    // Handle the case where the record ID is not provided
    $id = $student_id = $title = $drive_link = $creation_date = '';
    echo 'Record ID not provided.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
</head>
<body>
    <h1>Record Details</h1>
    <p><strong>ID:</strong> <?php echo $id; ?></p>
    <p><strong>Student ID:</strong> <?php echo $student_id; ?></p>
    <p><strong>Title:</strong> <?php echo $title; ?></p>
    <p><strong>Drive Link:</strong> <a href="<?php echo $drive_link; ?>"><?php echo $drive_link; ?></a></p>
    <p><strong>Creation Date:</strong> <?php echo $creation_date; ?></p>
</body>
</html>
