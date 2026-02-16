<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    // Database connection using improved mysqli initialization
    $connection = mysqli_connect("localhost", "root", "", "lms");
    
    // Fetch fresh user data using Prepared Statements for security
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $name = $email = $mobile = $address = "";
    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $address = $row['address'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Edit My Profile</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --student-blue: #2563eb; }
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #334155; }
        
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e2e8f0; z-index: 1000; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        .nav-link { color: #64748b !important; padding: 12px 25px !important; border-radius: 8px; margin: 4px 15px; }
        .nav-link.active { background: #eff6ff; color: var(--student-blue) !important; font-weight: 600; }

        .profile-card { border: none; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); background: #fff; max-width: 650px; margin: 40px auto; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #cbd5e1; }
        .btn-update { background: var(--student-blue); color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 600; }
        .btn-update:hover { background: #1e40af; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 fw-bold border-bottom text-primary">📖 Student LMS</div>
        <div class="mt-3">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="user_dashboard.php">🏠 My Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="view_profile.php">👤 View Profile</a></li>
                <li class="nav-item"><a class="nav-link active" href="edit_profile.php">✏️ Edit Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="change_password.php">🔐 Change Password</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white border-bottom d-flex justify-content-between">
            <h5 class="mb-0 fw-bold">Profile Management</h5>
            <span class="text-muted small">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
        </div>

        <div class="container py-4">
            <div class="profile-card p-4 p-md-5">
                <div class="mb-4 text-center">
                    <h3 class="fw-bold">Update My Information</h3>
                    <p class="text-muted small">Keep your contact details up to date for library notifications.</p>
                </div>

                <form action="update.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">FULL NAME</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name);?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email);?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label small fw-bold">MOBILE NUMBER</label>
                            <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($mobile);?>" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label small fw-bold">POSTAL ADDRESS</label>
                            <textarea name="address" rows="3" class="form-control" required><?php echo htmlspecialchars($address);?></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="update" class="btn btn-update shadow-sm">Update Profile</button>
                        <a href="view_profile.php" class="btn btn-light border px-4 rounded-3 text-muted">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>