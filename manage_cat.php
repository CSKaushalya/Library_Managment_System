<?php
    require("functions.php");
    session_start();
    
    // Security Check: Ensure admin is logged in
    if(!isset($_SESSION['email'])) {
        header("Location: admin_login.php");
        exit();
    }

    $connection = mysqli_connect("localhost", "root", "", "lms");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Manage Categories</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link.active { background: rgba(255,255,255,0.05); color: #fff !important; font-weight: 600; border-radius: 8px; margin: 0 10px; }

        .table-card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: #fff; overflow: hidden; }
        .table thead { background-color: #f1f5f9; }
        .table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; color: #64748b; padding: 15px; }
        .table td { vertical-align: middle; padding: 15px; border-color: #f1f5f9; }
        
        .btn-action { padding: 6px 16px; border-radius: 8px; font-weight: 500; font-size: 0.85rem; text-decoration: none; transition: 0.2s; display: inline-block; }
        .btn-edit { background: #eff6ff; color: #2563eb; }
        .btn-edit:hover { background: #2563eb; color: #fff; }
        .btn-delete { background: #fef2f2; color: #dc2626; margin-left: 5px; }
        .btn-delete:hover { background: #dc2626; color: #fff; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_book.php">📖 Manage Books</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage_cat.php">📂 Categories</a></li>
                <li class="nav-item mt-4"><a class="nav-link text-danger" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white shadow-sm d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Classification Management</h5>
            <a href="add_cat.php" class="btn btn-primary btn-sm rounded-pill px-3">+ Add New Category</a>
        </div>

        <div class="container-fluid p-4">
            <div class="card table-card">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM category ORDER BY cat_name ASC";
                                $query_run = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($query_run)){
                                    ?>
                                    <tr>
                                        <td class="fw-medium text-dark">
                                            <span class="me-2">📁</span>
                                            <?php echo htmlspecialchars($row['cat_name']); ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="edit_cat.php?cid=<?php echo $row['cat_id']; ?>" class="btn-action btn-edit">Edit</a>
                                            <a href="delete_cat.php?cid=<?php echo $row['cat_id']; ?>" 
                                               class="btn-action btn-delete" 
                                               onclick="return confirm('Are you sure you want to delete this category? This might affect books assigned to it.')">Delete</a>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>