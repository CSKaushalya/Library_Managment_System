<?php
    require("functions.php");
    session_start();
    
    $conn = new mysqli("localhost", "root", "", "lms");

    // Logic for adding book using Prepared Statements
    $success = false;
    if(isset($_POST['add_book'])) {
        $stmt = $conn->prepare("INSERT INTO books (book_name, author_id, cat_id, book_no, book_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiid", $_POST['book_name'], $_POST['author_id'], $_POST['cat_id'], $_POST['book_no'], $_POST['book_price']);
        if($stmt->execute()) { $success = true; }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Add New Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link.active { background: rgba(255,255,255,0.05); color: #fff !important; font-weight: 600; }

        .form-card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control, .form-select { padding: 10px 15px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .btn-primary { background: #3b82f6; border: none; padding: 12px; border-radius: 10px; font-weight: 600; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
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
            <h5 class="mb-0 fw-bold text-secondary">Add New Book</h5>
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

        <div class="container py-5">
            <?php if($success): ?>
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
                    <span class="me-2">✅</span> Book added to inventory successfully!
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card form-card">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="fw-bold mb-4">Register New Book</h3>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Book Title</label>
                                        <input type="text" name="book_name" class="form-control" placeholder="Enter book name" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Author</label>
                                        <select name="author_id" class="form-select" required>
                                            <option value="">Select Author</option>
                                            <?php
                                                $auth_query = "SELECT * FROM authors";
                                                $auth_run = mysqli_query($conn, $auth_query);
                                                while($auth = mysqli_fetch_assoc($auth_run)) {
                                                    echo "<option value='".$auth['author_id']."'>".$auth['author_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="cat_id" class="form-select" required>
                                            <option value="">Select Category</option>
                                            <?php
                                                $cat_query = "SELECT * FROM category";
                                                $cat_run = mysqli_query($conn, $cat_query);
                                                while($cat = mysqli_fetch_assoc($cat_run)) {
                                                    echo "<option value='".$cat['cat_id']."'>".$cat['cat_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">ISBN / Book No.</label>
                                        <input type="number" name="book_no" class="form-control" placeholder="0000" required>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Purchase Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">$</span>
                                            <input type="text" name="book_price" class="form-control" placeholder="0.00" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="add_book" class="btn btn-primary w-100 shadow-sm">
                                    Save to Library Inventory
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