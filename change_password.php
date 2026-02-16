<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Student Security</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --student-blue: #2563eb; }
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #334155; }
        
        /* Sidebar Styling */
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: #fff; border-right: 1px solid #e2e8f0; z-index: 1000; }
        .sidebar-header { padding: 25px; border-bottom: 1px solid #f1f5f9; font-weight: 700; color: var(--student-blue); }
        .nav-link { color: #64748b !important; padding: 12px 25px !important; border-radius: 8px; margin: 4px 15px; transition: 0.2s; }
        .nav-link:hover { background: #f8fafc; color: var(--student-blue) !important; }
        .nav-link.active { background: #eff6ff; color: var(--student-blue) !important; font-weight: 600; }

        /* Content Area */
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        .notification-bar { background: #dbeafe; color: #1e40af; padding: 10px; font-size: 0.85rem; font-weight: 500; border-bottom: 1px solid #bfdbfe; }
        
        .security-card { border: none; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); background: #fff; max-width: 480px; margin: 60px auto; overflow: hidden; }
        .card-accent { height: 6px; background: var(--student-blue); }
        
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #cbd5e1; }
        .btn-update { background: var(--student-blue); border: none; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header">📖 Student LMS</div>
        <div class="mt-3">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="user_dashboard.php">🏠 My Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="issued_books.php">📚 My Issued Books</a></li>
                <li class="nav-item"><a class="nav-link" href="view_profile.php">👤 View Profile</a></li>
                <li class="nav-item"><a class="nav-link active" href="change_password.php">🔐 Change Password</a></li>
                <li class="nav-item mt-4"><a class="nav-link text-danger" href="../logout.php">🚪 Logout</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="notification-bar text-center">
            🕒 Today's Hours: 8:00 AM — 8:00 PM | Please return overdue books to avoid fines.
        </div>

        <div class="container py-4">
            <div class="security-card">
                <div class="card-accent"></div>
                <div class="p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Security Settings</h3>
                        <p class="text-muted small">Update your student account password below.</p>
                    </div>

                    <form action="update_password.php" method="post">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">CURRENT PASSWORD</label>
                            <input type="password" class="form-control" name="old_password" placeholder="••••••••" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold">NEW PASSWORD</label>
                            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                        </div>

                        <button type="submit" name="update" class="btn btn-primary btn-update shadow-sm">
                            Update My Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>