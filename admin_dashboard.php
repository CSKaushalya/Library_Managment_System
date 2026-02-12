<?php
    require("functions.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Admin Dashboard</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-dark: #1e293b;
            --accent-color: #3b82f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Sidebar Design */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--primary-dark);
            color: #fff;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            font-weight: 700;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-link {
            color: #94a3b8 !important;
            padding: 12px 20px !important;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.05);
            color: #fff !important;
        }

        .dropdown-menu {
            background: #334155;
            border: none;
            padding: 0;
        }

        .dropdown-item {
            color: #cbd5e1;
            padding: 10px 25px;
        }

        .dropdown-item:hover {
            background: var(--accent-color);
            color: white;
        }

        /* Main Content Area */
        #content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s;
        }

        .top-navbar {
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Dashboard Stats Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #content { margin-left: 0; width: 100%; }
            #sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header text-center">
            <span class="text-info">📚</span> LMS ADMIN
        </div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="admin_dashboard.php">📊 Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">📖 Books</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_book.php">Add New Book</a>
                        <a class="dropdown-item" href="manage_book.php">Manage Inventory</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">📁 Categories</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_cat.php">Add Category</a>
                        <a class="dropdown-item" href="manage_cat.php">Manage List</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="issue_book.php">🎫 Issue Book</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">System Overview</h5>
            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-md-block">
                    <p class="mb-0 small fw-bold"><?php echo $_SESSION['name'];?></p>
                    <p class="mb-0 x-small text-muted" style="font-size: 11px;"><?php echo $_SESSION['email'];?></p>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light border-0 rounded-circle" data-bs-toggle="dropdown">👤</button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="view_profile_admin.php">View Profile</a></li>
                        <li><a class="dropdown-item" href="edit_profile_admin.php">Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid p-4">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card stat-card p-3 border-start border-danger border-5">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger">👥</div>
                        <h6 class="text-muted small fw-bold">REGISTERED USERS</h6>
                        <h3 class="fw-bold mb-3"><?php echo get_user_count();?></h3>
                        <a href="regusers.php" class="btn btn-sm btn-outline-danger w-100">Manage Users</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card p-3 border-start border-success border-5">
                        <div class="icon-box bg-success bg-opacity-10 text-success">📚</div>
                        <h6 class="text-muted small fw-bold">TOTAL BOOKS</h6>
                        <h3 class="fw-bold mb-3"><?php echo get_book_count();?></h3>
                        <a href="regbooks.php" class="btn btn-sm btn-outline-success w-100">View Library</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card p-3 border-start border-warning border-5">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">🏷️</div>
                        <h6 class="text-muted small fw-bold">CATEGORIES</h6>
                        <h3 class="fw-bold mb-3"><?php echo get_category_count();?></h3>
                        <a href="regcat.php" class="btn btn-sm btn-outline-warning w-100">View Types</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card p-3 border-start border-primary border-5">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">📤</div>
                        <h6 class="text-muted small fw-bold">BOOKS ISSUED</h6>
                        <h3 class="fw-bold mb-3"><?php echo get_issue_book_count();?></h3>
                        <a href="view_issued_book.php" class="btn btn-sm btn-outline-primary w-100">View Logs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>