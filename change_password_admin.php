<?php
    require("functions.php");
    session_start();
    
    // Security check
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Change Password</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        .sidebar-header { padding: 20px; background: rgba(0,0,0,0.1); font-weight: 700; text-align: center; }
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

        /* Security Card Visuals */
        .security-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; max-width: 500px; margin: 40px auto; }
        .form-control { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; background: #fcfdfe; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        .btn-update { background: #0f172a; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-update:hover { background: #1e293b; transform: translateY(-1px); }
        
        .alert-notice { background: #fff7ed; border-left: 4px solid #f97316; color: #9a3412; padding: 15px; border-radius: 8px; font-size: 0.9rem; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="view_profile.php">👤 View Profile</a></li>
                <li class="nav-item"><a class="nav-link active text-white fw-bold" href="change_password.php">🔒 Security</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Account Settings</h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown">Admin ▼</button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="container py-4">
            <div class="security-card p-4 p-lg-5">
                <div class="text-center mb-4">
                    <div class="mb-3 text-primary"><span style="font-size: 2.5rem;">🔐</span></div>
                    <h3 class="fw-bold">Update Password</h3>
                    <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger border-0 small py-2"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>

                <form action="update_password.php" method="post">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">CURRENT PASSWORD</label>
                        <input type="password" class="form-control" name="old_password" required>
                    </div>
                    
                    <hr class="my-4 opacity-50">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NEW SECURE PASSWORD</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Min. 8 characters" required>
                    </div>

                    <div class="alert-notice mb-4">
                        <strong>Pro Tip:</strong> Use a combination of uppercase letters, numbers, and symbols.
                    </div>

                    <button type="submit" name="update" class="btn btn-update shadow-sm">
                        Confirm Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>