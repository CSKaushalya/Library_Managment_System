<?php
    session_start();
    // Verification: Ensure the admin is actually logged in
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }

    $connection = mysqli_connect("localhost","root","","lms");
    $query = "SELECT cat_name FROM category ORDER BY cat_name ASC";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Book Categories</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        .marquee-container { background: #f8f9fa; padding: 5px 0; border-bottom: 1px solid #dee2e6; }
        .main-card { border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            <div class="text-white">
                <small>Admin: <strong><?php echo $_SESSION['name'];?></strong></small>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Account</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="view_profile.php">My Profile</a>
                        <a class="dropdown-item" href="change_password.php">Security</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="marquee-container">
        <marquee behavior="scroll" direction="left">Welcome to the LMS Admin Portal. Operational Hours: 08:00 AM - 08:00 PM.</marquee>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card main-card">
                    <div class="card-header bg-white">
                        <h4 class="text-center text-primary mb-0 py-2">Registered Book Categories</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered text-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="15%">#</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query_run = mysqli_query($connection, $query);
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($query_run)){
                                        ?>
                                        <tr>
                                            <td><span class="badge badge-secondary"><?php echo $count++; ?></span></td>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['cat_name']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>
</html>