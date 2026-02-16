<?php
    session_start();
    # Ensure admin is logged in
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }

    $connection = mysqli_connect("localhost","root","","lms");
    $query = "select * from users";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Registered Users</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            <div class="text-white">
                <span class="mr-3"><strong>Admin: <?php echo $_SESSION['name'];?></strong></span>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="view_profile_admin.php">View Profile</a>
                        <a class="dropdown-item" href="edit_profile_admin.php">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="change_password_admin.php">Change Password</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="text-center mb-0">Registered Student Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query_run = mysqli_query($connection, $query);
                                    while ($row = mysqli_fetch_assoc($query_run)){
                                        ?>
                                        <tr>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['name']);?></td>
                                            <td><?php echo htmlspecialchars($row['email']);?></td>
                                            <td><?php echo htmlspecialchars($row['mobile']);?></td>
                                            <td><?php echo htmlspecialchars($row['address']);?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>
</html>