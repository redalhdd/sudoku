<?php
include 'db_connect.php';

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $username = trim($_POST['new_username']);
    $password = trim($_POST['new_password']);
    $score = isset($_POST['score']) ? (int)$_POST['score'] : 0;  // Default score to 0 if not set

    // Check if the username is already taken
    $stmt = $con->prepare('SELECT id FROM accounts WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->bind_result($id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username already exists
        header('Location: index.html?error=username_taken');
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $con->prepare('INSERT INTO accounts (username, password, score) VALUES (?, ?, ?)');
    $stmt->bind_param('ssi', $username, $hashed_password, $score);

    if ($stmt->execute()) {
        // Registration successful
        // Create sessions to track logged-in user
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $username;
        $_SESSION['score'] = $score;  // Store score in session
        $_SESSION['id'] = $con->insert_id;  // Store user ID

        header('Location: test.php?username=' . urlencode($_SESSION['name']));
    } else {
        // Error occurred during insertion
        echo 'Error: Could not register. Please try again later.';
    }
    $stmt->close();
}

$con->close();
?>
