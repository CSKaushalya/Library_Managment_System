<?php
    require("functions.php");
    session_start();
    
    // Security Check: Redirect if not logged in
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
    }

    $conn = new mysqli("localhost", "root", "", "lms");
    
    // Logic for adding author
    $success_message = false;
    if(isset($_POST['add_author'])) {
        $stmt = $conn->prepare("INSERT INTO authors (author_name) VALUES (?)");
        $stmt->bind_param("s", $_POST['author_name']);
        if($stmt->execute()) {
            $success_message = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Add Author</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        /* Sidebar Styles (Consistent with Dashboard) */
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        .sidebar-header { padding: 20px; background: rgba(0,0,0,0.1); font-weight: 700; text-align: center; }
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.05); color: #fff !important; }

        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

        /* Form Card Styling */
        .form-card {
            background: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 50px auto;
        }
        .form-control { padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .btn-add { background: #3b82f6; color: white; border-radius: 8px; padding: 10px 25px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-add:hover { background: #2563eb; transform: translateY(-1px); }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header"><span class="text-info">📚</span> LMS ADMIN</div>
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="admin_dashboard.php" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Author</li>
                </ol>
            </nav>
            <div class="dropdown">
                <button class="btn btn-light rounded-circle" data-bs-toggle="dropdown">👤</button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="container-fluid p-4">
            <?php if($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <strong>Success!</strong> Author has been added to the database.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card form-card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="display-6 mb-2">✍️</div>
                        <h3 class="fw-bold">Add New Author</h3>
                        <p class="text-muted">Enter the full name of the author to register them.</p>
                    </div>

                    <form action="" method="post">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Full Name of Author</label>
                            <input type="text" class="form-control form-control-lg" 
                                   name="author_name" 
                                   placeholder="e.g. J.K. Rowling" 
                                   required autocomplete="off">
                        </div>
                        <button type="submit" name="add_author" class="btn btn-add shadow-sm">
                            Create Author Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>