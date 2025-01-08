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
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$age = isset($_POST['age']) ? trim($_POST['age']) : '';
$city = isset($_POST['cityName']) ? trim($_POST['cityName']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$blood_type = isset($_POST['bloodType']) ? trim($_POST['bloodType']) : '';
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';

// Validate required fields
if (empty($first_name) || empty($last_name) || empty($age) || empty($city) || empty($email) || empty($phone) || empty($address) || empty($username) || empty($password) || empty($blood_type) || empty($gender)) {
    die("All fields are required.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, age, city, email, phone, address, username, password, gender, blood_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissssssss", $first_name, $last_name, $age, $city, $email, $phone, $address, $username, $hashed_password, $gender, $blood_type);

// Execute
if ($stmt->execute()) {
    echo "Signed up successfully..!";
} else {
    echo "Error: " . $stmt->error;
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <center>
        <br><br><br><br><br><br><br><br>
        <div class="btn-group">
        <a href="login.html" class="btn btn-primary">Log-in</a>
</div>
    </center>
</body>
</html>