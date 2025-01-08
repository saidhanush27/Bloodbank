<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO donors (full_name, date_of_birth, gender, blood_type, contact_number, email, address, last_donation, diabetic, medical_conditions, consent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssi", $fullName, $dob, $gender, $bloodType, $contactNumber, $email, $address, $lastDonation, $diabetic, $medicalConditions, $consent);

// Get form data
$fullName = $_POST['fullName'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$bloodType = $_POST['bloodType'];
$contactNumber = $_POST['contactNumber'];
$email = $_POST['email'];
$address = $_POST['address'];
$lastDonation = $_POST['lastDonation'];
$diabetic = $_POST['diabetic'];
$medicalConditions = $_POST['medicalConditions'];
$consent = isset($_POST['consent']) ? 1 : 0;

// Execute the statement
if ($stmt->execute()) {
    header("Location: contact.html");

    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>