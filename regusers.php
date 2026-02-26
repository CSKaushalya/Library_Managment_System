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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="adminNavbar">
                <div class="navbar-nav ms-auto align-items-lg-center">
                    <span class="nav-item text-white me-3 small">
                        <strong>Admin:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?>
                    </span>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="view_profile_admin.php">View Profile</a></li>
                            <li><a class="dropdown-item" href="edit_profile_admin.php">Edit Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="change_password_admin.php">Change Password</a></li>
                        </ul>
                    </div>
                    <a class="nav-link btn btn-outline-danger btn-sm ms-lg-3 text-white" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary fw-bold">Registered Student Details</h5>
                            <span class="badge bg-secondary">Total Users: <?php echo mysqli_num_rows(mysqli_query($connection, $query)); ?></span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th class="pe-4">Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query_run = mysqli_query($connection, $query);
                                        if(mysqli_num_rows($query_run) > 0) {
                                            while ($row = mysqli_fetch_assoc($query_run)){
                                                ?>
                                                <tr>
                                                    <td class="ps-4 fw-semibold text-dark"><?php echo htmlspecialchars($row['name']);?></td>
                                                    <td><?php echo htmlspecialchars($row['email']);?></td>
                                                    <td><?php echo htmlspecialchars($row['mobile']);?></td>
                                                    <td class="pe-4 text-muted small"><?php echo htmlspecialchars($row['address']);?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='4' class='text-center py-4'>No users found.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>