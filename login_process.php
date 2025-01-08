<?php
// Start the session
session_start();

// Database connection (replace with your own credentials)
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "blood_bank"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$form_username = $_POST['username'];
$form_password = $_POST['pass'];

// Sanitize input
$form_username = $conn->real_escape_string($form_username);
$form_password = $conn->real_escape_string($form_password);

// Validate input
if (empty($form_username) || empty($form_password)) {
    echo "Username and password are required.";
    exit;
}

// Query to find user
$sql = "SELECT id, username, password FROM users WHERE username='$form_username' OR email='$form_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($form_password, $row['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        // Redirect to a logged-in page
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username or email.";
}

// Close the database connection
$conn->close();
?>

