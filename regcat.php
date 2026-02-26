<?php
    session_start();
    // 1. Security: Strict session check
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }

    // 2. Secure Database Connection (Ideally moved to a config file)
    $connection = mysqli_connect("localhost","root","","lms");
    if (!$connection) { die("Connection failed: " . mysqli_connect_error()); }

    // 3. Optimized Query
    $query = "SELECT cat_name FROM category ORDER BY cat_name ASC";
    $query_run = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS | Book Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.08); }
        .main-card { border: none; border-radius: 12px; transition: transform 0.2s; }
        .table thead { background-color: #f8f9fa; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em; }
        .status-badge { font-weight: 500; padding: 0.5em 1em; border-radius: 6px; }
        .info-bar { background: #e9ecef; font-size: 0.9rem; padding: 8px 0; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="admin_dashboard.php">LMS <span class="text-primary">Pro</span></a>
            
            <div class="d-flex align-items-center">
                <span class="text-light me-3 d-none d-md-block">
                    Hello, <span class="text-primary font-weight-bold"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                </span>
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Account
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="view_profile.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="change_password.php">Security Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../logout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="info-bar text-center">
        <span class="badge bg-primary me-2">Update</span> 
        Operational Hours: <strong>08:00 AM - 08:00 PM</strong> | System is currently stable.
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card main-card shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark">Book Categories</h5>
                            <span class="badge bg-secondary-soft text-dark border"><?php echo mysqli_num_rows($query_run); ?> Total</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4" width="15%">Index</th>
                                        <th>Category Name</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($query_run)){
                                            ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="text-muted fw-bold">#<?php echo $count++; ?></span>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-dark">
                                                        <?php echo htmlspecialchars($row['cat_name']); ?>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <button class="btn btn-sm btn-light border">Edit</button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p class="text-center text-muted mt-4 small">Generated by LMS Administrative Module v2.0</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>