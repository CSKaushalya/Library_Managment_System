<?php
    require("functions.php");
    session_start();
    
    // Security Check
    if(!isset($_SESSION['email'])) { header("Location: admin_login.php"); exit(); }

    $connection = mysqli_connect("localhost", "root", "", "lms");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Manage Books</title>
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
        .table thead { background-color: #f8fafc; border-bottom: 2px solid #f1f5f9; }
        .table th { font-weight: 600; text-transform: uppercase; font-size: 0.7rem; color: #64748b; padding: 15px; }
        .table td { vertical-align: middle; padding: 15px; font-size: 0.9rem; }
        
        .badge-cat { background: #f1f5f9; color: #475569; padding: 5px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 500; }
        .btn-action { padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; font-weight: 500; }
        .btn-edit { color: #2563eb; border: 1px solid #dbeafe; background: #eff6ff; }
        .btn-delete { color: #dc2626; border: 1px solid #fee2e2; background: #fef2f2; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage_book.php">📖 Manage Books</a></li>
                <li class="nav-item"><a class="nav-link" href="issue_book.php">✍️ Issue Book</a></li>
                <li class="nav-item mt-4"><a class="nav-link text-danger" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white shadow-sm d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Book Inventory</h5>
            <a href="add_book.php" class="btn btn-primary btn-sm px-3">+ Add New Asset</a>
        </div>

        <div class="container-fluid p-4">
            <div class="card table-card">
                <div class="table-responsive">
                    <table class="table hover">
                        <thead>
                            <tr>
                                <th>Book Details</th>
                                <th>Category</th>
                                <th>ISBN/No</th>
                                <th>Price</th>
                                <th class="text-end">Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Using JOIN to get names instead of just IDs
                                $query = "SELECT books.*, authors.author_name, category.cat_name 
                                          FROM books 
                                          LEFT JOIN authors ON books.author_id = authors.author_id 
                                          LEFT JOIN category ON books.cat_id = category.cat_id";
                                          
                                $query_run = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($query_run)){
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['book_name']);?></div>
                                            <div class="text-muted small">By: <?php echo htmlspecialchars($row['author_name']);?></div>
                                        </td>
                                        <td><span class="badge-cat"><?php echo htmlspecialchars($row['cat_name']);?></span></td>
                                        <td><code>#<?php echo $row['book_no'];?></code></td>
                                        <td>$<?php echo number_format($row['book_price'], 2);?></td>
                                        <td class="text-end">
                                            <a href="edit_book.php?bn=<?php echo $row['book_no'];?>" class="btn-action btn-edit">Edit</a>
                                            <a href="delete_book.php?bn=<?php echo $row['book_no'];?>" 
                                               class="btn-action btn-delete ms-1"
                                               onclick="return confirm('Remove this book from inventory?')">Delete</a>
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
</body>
</html>