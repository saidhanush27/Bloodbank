<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get blood type from URL, ensure to handle encoding
$bloodType = isset($_GET['bloodType']) ? $_GET['bloodType'] : '';

// Prepare and execute the query
$sql = "SELECT * FROM donors WHERE blood_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bloodType);
$stmt->execute();
$result = $stmt->get_result();

// HTML header
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Donors with Blood Type $bloodType</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
</head>
<body>";

if ($result->num_rows > 0) {
    echo "<h1>Donors with Blood Type: " . htmlspecialchars($bloodType) . "</h1>";
    echo "<div class='donor-container'>";

    // Output data of each donor
    while ($row = $result->fetch_assoc()) {
        echo "<div class='donor-box'>";
        echo "<div class='icon'><i class='fa fa-heartbeat'></i></div>";
        echo "<strong>Name:</strong> " . htmlspecialchars($row['full_name']) . "<br>";
        echo "<strong>Date of Birth:</strong> " . htmlspecialchars($row['date_of_birth']) . "<br>";
        echo "<strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "<br>";
        echo "<strong>Contact Number:</strong> " . htmlspecialchars($row['contact_number']) . "<br>";
        echo "<strong>Email:</strong> " . htmlspecialchars($row['email']) . "<br>";
        echo "<strong>Address:</strong> " . htmlspecialchars($row['address']) . "<br>";
        echo "<strong>Last Donation:</strong> " . htmlspecialchars($row['last_donation']) . "<br>";
        echo "<strong>Diabetic:</strong> " . htmlspecialchars($row['diabetic']) . "<br>";
        echo "<strong>Medical Conditions:</strong> " . htmlspecialchars($row['medical_conditions']) . "<br>";
        echo "<strong>Consent:</strong> " . ($row['consent'] ? 'Yes' : 'No') . "<br>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<h2>No donors found for this blood type.</h2>";
}

// CSS for styling
echo "

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #ffe6e6;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #333;
}

h1 {
    color: #b30000;
    font-size: 2.5em;
    text-align: center;
    margin-bottom: 20px;
}

h2 {
    color: #800000;
}

.donor-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.donor-box {
    background-color: #ffcccc;
    border: 1px solid #b30000;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(179, 0, 0, 0.2);
    width: 280px;
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
    color: #333;
    animation: fadeIn 1s ease-in-out;
}

.donor-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(179, 0, 0, 0.3);
    background-color: #ff9999;
}

strong {
    color: #b30000;
}

.donor-box br {
    margin: 8px 0;
}

.donor-box::before {
    content: '💉';
    font-size: 3em;
    color: rgba(255, 255, 255, 0.2);
    position: absolute;
    top: 10px;
    right: 10px;
    transform: rotate(-20deg);
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}

</style>
";

// Close connections
$stmt->close();
$conn->close();

echo "</body></html>";
?>
