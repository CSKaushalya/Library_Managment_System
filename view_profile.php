<?php
    session_start();
    # Security: Redirect if user is not logged in
    if(!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    # Fetch data from database
    $connection = mysqli_connect("localhost","root","","lms");
    
    $name = "";
    $email = "";
    $mobile = "";
    $address = "";

    # Using Prepared Statements or sanitizing session data is safer
    $user_email = mysqli_real_escape_string($connection, $_SESSION['email']);
    $query = "select * from users where email = '$user_email'";
    $query_run = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_assoc($query_run)){
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $address = $row['address'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile | LMS</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        .profile-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .navbar-brand { font-weight: bold; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">LMS Portal</a>
            <div class="text-white small">
                <strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']);?></strong>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-3"></div>
            <div class="col-md-6 profile-container">
                <h4 class="text-center text-primary mb-4">Personal Account Details</h4>
                <form>
                    <div class="form-group">
                        <label class="font-weight-bold">Full Name:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($name);?>" disabled>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email Address:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($email);?>" disabled>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Mobile Number:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($mobile);?>" disabled>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Permanent Address:</label>
                        <textarea class="form-control" rows="3" disabled><?php echo htmlspecialchars($address);?></textarea>
                    </div>
                    <div class="text-center mt-4">
                        <a href="edit_profile.php" class="btn btn-warning">Edit Profile Information</a>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>