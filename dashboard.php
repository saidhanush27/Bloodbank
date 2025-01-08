<?php
session_start(); // Start session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

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

// Retrieve the logged-in username from session
$username = $_SESSION['username'];

// Prepare and bind
$stmt = $conn->prepare("SELECT first_name, last_name, age, city, email, phone, address, gender, blood_type FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

// Execute
$stmt->execute();
$result = $stmt->get_result();

// Fetch user details
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif;
        background-color: salmon; }
        .container { width: 80%; margin: 0 auto; padding: 20px; }
        .profile { border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
        .profile h2 { margin-top: 0; }
        .profile p { margin: 5px 0; }
        .logout { margin-top: 20px; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <br><br>
    <h2 style="text-align: center;">DASHBOARD</h2>
    <br>
    <div class="container">
        <div class="profile">
            <h2>User Profile</h2>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
            <p><strong>Blood Type:</strong> <?php echo htmlspecialchars($user['blood_type']); ?></p><br>
            <div class="btn-group">
  <a href="logout.php" class="btn btn-primary active" aria-current="page">Logout</a>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="index.html" class="btn btn-primary">Home</a>
</div>
        </div>
    </div>
</body>
</html>
