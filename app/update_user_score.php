<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

// Include database connection
include 'db_connect.php'; // Adjust this path to your actual connection file

// Validate the score sent via POST
if (!isset($_POST['score']) || !is_numeric($_POST['score'])) {
    echo json_encode(["success" => false, "message" => "Invalid score value."]);
    exit;
}

$score = intval($_POST['score']);
$username = $_SESSION['name'];

try {
    // Update the score in the database by adding the new score to the existing one
    $stmt = $con->prepare('UPDATE accounts SET score = score + ? WHERE username = ?');
    $stmt->bind_param('is', $score, $username);

    if ($stmt->execute()) {
        // Fetch the updated score from the database
        $stmt = $con->prepare('SELECT score FROM accounts WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($updatedScore);
        $stmt->fetch();

        // Update the session variable for the score
        $_SESSION['score'] = $updatedScore;
        echo json_encode(["success" => true, "message" => "Score updated successfully.", "updatedScore" => $updatedScore]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update the score."]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "An error occurred: " . $e->getMessage()]);
}

$con->close();
?>
