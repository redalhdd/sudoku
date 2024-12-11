<?php
include 'db_connect.php';

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $username = trim($_POST['new_username']);
    $password = trim($_POST['new_password']);

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
    $stmt = $con->prepare('INSERT INTO accounts (username, password, score) VALUES (?, ?,0)');
    $stmt->bind_param('ss', $username, $hashed_password);

    if ($stmt->execute()) {
        // Registration successful
        // Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['new_username'];
        $_SESSION['score'] = $_POST['score'];
		$_SESSION['id'] = $id;
		header('Location: test.html');
    } else {
        // Error occurred during insertion
        echo 'Error: Could not register. Please try again later.';
    }
    $stmt->close();
}

$con->close();
?>
