<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
//$DATABASE_PASS = 'root';
$DATABASE_NAME = 'sudoku';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

header('Content-Type: application/json');

$result = $con->query("SELECT username, score FROM accounts ORDER BY score DESC");
$leaderboard = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
} else {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

echo json_encode($leaderboard);
$con->close();

?>