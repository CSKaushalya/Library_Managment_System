<?php
    require("functions.php");
    session_start();
    
    // Security: Kick unauthorized users back to login
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "lms");
    $success = false;

    // Logic: Process Category Addition
    if(isset($_POST['add_cat'])) {
        $cat_name = $_POST['cat_name'];
        // Using Prepared Statements to prevent SQL Injection
        $stmt = $conn->prepare("INSERT INTO category (cat_name) VALUES (?)");
        $stmt->bind_param("s", $cat_name);
        if($stmt->execute()) {
            $success = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Add Category</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        /* Consistent Sidebar */
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        .sidebar-header { padding: 20px; background: rgba(0,0,0,0.1); font-weight: 700; text-align: center; }
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link.active { background: rgba(255,255,255,0.05); color: #fff !important; font-weight: 600; }

        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

        /* Form Visuals */
        .form-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; }
        .form-control { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .btn-submit { background: #3b82f6; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-submit:hover { background: #2563eb; transform: translateY(-1px); }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="admin_dashboard.php">📊 Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">📖 Books</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_book.php">Add New Book</a>
                        <a class="dropdown-item" href="manage_book.php">Manage Book</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">📁 Categories</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_cat.php">Add Category</a>
                        <a class="dropdown-item" href="manage_cat.php">Manage List</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">📖 Authors</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_author.php">Add New Author</a>
                        <a class="dropdown-item" href="manage_author.php">Manage Authors</a>
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
            <h5 class="mb-0 fw-bold text-secondary">Add New Category</h5>
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
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    
                    <?php if($success): ?>
                        <div class="alert alert-success border-0 shadow-sm mb-4 fade show" role="alert">
                            <strong>Success!</strong> New category created. <a href="manage_cat.php" class="alert-link">View all</a>
                        </div>
                    <?php endif; ?>

                    <div class="card form-card">
                        <div class="card-body p-4 p-lg-5 text-center">
                            <div class="mb-4">
                                <span class="display-5">📂</span>
                                <h3 class="fw-bold mt-3">Add Category</h3>
                                <p class="text-muted">Create a new classification for your books.</p>
                            </div>

                            <form action="" method="post">
                                <div class="mb-4 text-start">
                                    <label class="form-label small fw-bold text-muted">CATEGORY NAME</label>
                                    <input type="text" class="form-control" name="cat_name" 
                                           placeholder="e.g., Computer Science, Fiction" required>
                                </div>
                                <button type="submit" name="add_cat" class="btn btn-submit shadow-sm">
                                    Add to System
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>