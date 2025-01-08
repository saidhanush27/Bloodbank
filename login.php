<?php
$servername = "localhost";
$db_username = "root"; // Database username
$db_password = ""; // Database password
$dbname = "blood_bank"; // Database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$login_username = isset($_POST['username']) ? trim($_POST['username']) : '';
$login_password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validate required fields
if (empty($login_username) || empty($login_password)) {
    die("Username and password are required.");
}

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $login_username);

// Execute
$stmt->execute();
$stmt->store_result();

// Check if username exists
if ($stmt->num_rows == 1) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($login_password, $hashed_password)) {
        session_start();
        $_SESSION['username'] = $login_username;
        header("Location:profile.php"); // Redirect to a dashboard or home page
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No account found with that username.";
}

// Close connection
$stmt->close();
$conn->close();
?>
