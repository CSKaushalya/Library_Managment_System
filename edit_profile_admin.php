<?php
    require("functions.php");
    session_start();

    // Security Check: Ensure admin is logged in
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }

    # Fetch fresh data from database to ensure the form is up to date
    $connection = mysqli_connect("localhost", "root", "", "lms");
    $email_session = $_SESSION['email'];
    
    // Using a prepared statement for security
    $query = "SELECT * FROM admins WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $email_session);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $name = "";
    $email = "";
    $mobile = "";
    
    while ($row = mysqli_fetch_assoc($result)){
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Edit Admin Profile</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link.active { background: rgba(255,255,255,0.05); color: #fff !important; font-weight: 600; }

        .form-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; max-width: 600px; margin: 50px auto; }
        .form-control { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; background: #fcfdfe; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        
        .btn-update { background: #3b82f6; color: white; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; transition: 0.2s; }
        .btn-update:hover { background: #2563eb; transform: translateY(-1px); }
        .btn-cancel { background: #f1f5f9; color: #475569; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="view_profile_admin.php">👤 View Profile</a></li>
                <li class="nav-item"><a class="nav-link active" href="edit_profile_admin.php">✏️ Edit Profile</a></li>
                <li class="nav-item"><a class="nav-link text-danger mt-4" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white shadow-sm d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Account Settings</h5>
            <span class="text-muted small">Logged in as: <?php echo htmlspecialchars($email_session); ?></span>
        </div>

        <div class="container">
            <div class="card form-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="display-6 mb-2">⚙️</div>
                        <h3 class="fw-bold">Update Profile</h3>
                        <p class="text-muted">Edit your personal administrative details below.</p>
                    </div>

                    <form action="update.php" method="post">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">FULL NAME</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">MOBILE NUMBER</label>
                            <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($mobile); ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="update" class="btn btn-update flex-grow-1 shadow-sm">
                                Save Changes
                            </button>
                            <a href="view_profile_admin.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>