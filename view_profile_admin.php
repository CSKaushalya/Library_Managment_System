<?php
    require("functions.php");
    session_start();
    
    // Security Check: Redirect to login if session is not set
    if(!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    $connection = mysqli_connect("localhost", "root", "", "lms");
    
    $name = "";
    $email = "";
    $mobile = "";

    // Fetching the current admin's details
    $query = "SELECT * FROM admins WHERE email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Profile | LMS</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            <div class="text-white">
                <span><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="profile-card">
                    <h4 class="text-center mb-4 text-primary">Admin Profile Details</h4>
                    <form>
                        <div class="form-group">
                            <label class="font-weight-bold">Full Name:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($name); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Email Address:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($email); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Mobile Number:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($mobile); ?>" disabled>
                        </div>
                        <div class="text-center mt-4">
                            <a href="edit_profile.php" class="btn btn-warning">Edit Profile</a>
                            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>