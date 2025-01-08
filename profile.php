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
   
</head>
<body>
   
</body>
</html>


<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cabin&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,700,800" rel="stylesheet">

    <link rel="stylesheet" href="./open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="./animate.css">

    <link rel="stylesheet" href="./owl.carousel.min.css">
    <link rel="stylesheet" href="./owl.theme.default.min.css">
    <link rel="stylesheet" href="./magnific-popup.css">

    <link rel="stylesheet" href="./aos.css">

    <link rel="stylesheet" href="./ionicons.min.css">

    <link rel="stylesheet" href="./bootstrap-datepicker.css">
    <link rel="stylesheet" href="./jquery.timepicker.css">


    <link rel="stylesheet" href="./flaticon.css">
    <link rel="stylesheet" href="./icomoon.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./profile_style.css">

    <link rel="icon" type="image/x-icon" href="images/logo.jpg">
    <style>
        body { font-family: Arial, sans-serif;
        background-color: salmon; }
        .container { width: 100%; margin: 0; padding: 20px; }
        .profile { border: 1px solid #ccc; padding: 20px; border-radius: 8px;background-color:white; justify-content:center; }
        .profile h2 { margin-top: 0; }
        .profile p { margin: 5px 0;  }
        .logout { margin-top: 20px; }
        .navbar-dark-dark{background-color: #ff004d1c !important;
        margin:0; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>Profile</title>
    </head>
    <body style="background-image: url(images/platelets4.jpg);height: 700px;width: 100%">
       
           <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">LifeLine<i class="fa fa-heart" aria-hidden="true"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
                   
                    <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="worldblood.html" class="nav-link">Donor Day</a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link"><span>Profile</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
       
       
       
       
       
        <div class="container pt-5 prof mt-5">
        <div class="row d-flex justify-content-center">
        <div class="col-lg-2 col-md-4 col-sm-4 col-6">
           <div class="profile-pic">
            <img class="img-fluid rounded-circle prof-img" src="images/profile3.jpg" >
            </div>
         </div>
        </div>
        
        <!-- <div class="container"> -->
        <!-- <div class="row"> -->
        <!-- <div class="col-md-5 left-side "> -->
                <div class="profile">
                  <center>  <h2>USER PROFILE</h2>
                    <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
                    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
                    <p><strong>Blood Type:</strong> <?php echo htmlspecialchars($user['blood_type']); ?></p><br>
        </center>
                </div>
            </div>
        </div>
       
     </div>
     </div>
      <!--
     <section style="background-image: url(platelets4.jpg);height: 700px;width: 100%">
     </section> -->
     <script>
         var cw = $('.col-md-2').width();
         $('prof-img').css({'height':cw+'px','width':cw+'px'});        
    </script>
     <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    
    </body>
</html>