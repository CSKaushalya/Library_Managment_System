<?php
    session_start();
    // 1. Security Check: Redirect if not logged in
    if(!isset($_SESSION['name'])) {
        header("Location: admin_login.php");
        exit();
    }

    // 2. Database Connection
    $connection = mysqli_connect("localhost", "root", "", "lms");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // 3. Optimized Query with LEFT JOIN to get Author Names
    $query = "SELECT books.book_name, books.book_no, books.book_price, authors.author_name 
              FROM books 
              LEFT JOIN authors ON books.author_id = authors.author_id";
    $query_run = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMS | Master Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --glass-bg: rgba(255, 255, 255, 0.9); }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: #212529 !important; }
        .table-card { 
            background: var(--glass-bg); 
            border-radius: 15px; 
            border: none; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        }
        .search-box { border-radius: 20px; padding-left: 45px; }
        .search-icon { position: absolute; left: 15px; top: 10px; color: #6c757d; z-index: 10; }
        .badge-id { background: #e9ecef; color: #495057; font-family: monospace; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="admin_dashboard.php">📚 LMS PRO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item text-light me-3 small">
                        Logged in as: <span class="text-warning"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Profile</a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="view_profile.php">My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card table-card p-4">
                    
                    <div class="d-md-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fw-bold mb-0">Master Book Inventory</h3>
                            <p class="text-muted small">Manage and search all registered books in the system.</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary px-3 py-2">Total: <?php echo mysqli_num_rows($query_run); ?> Books</span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-5 position-relative">
                            <i class="search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </i>
                            <input type="text" id="searchInput" class="form-control search-box" placeholder="Start typing to filter books...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="inventoryTable">
                            <thead class="table-dark">
                                <tr>
                                    <th class="border-0 ps-3">Book Name</th>
                                    <th class="border-0">Author</th>
                                    <th class="border-0 text-center">Price</th>
                                    <th class="border-0 text-center">Book No.</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php
                                    if(mysqli_num_rows($query_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($query_run)){
                                            ?>
                                            <tr>
                                                <td class="ps-3 fw-bold"><?php echo htmlspecialchars($row['book_name']); ?></td>
                                                <td class="text-secondary"><?php echo htmlspecialchars($row['author_name'] ?? 'Unassigned'); ?></td>
                                                <td class="text-center text-success fw-semibold">
                                                    $<?php echo number_format($row['book_price'], 2); ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-id border px-3"><?php echo $row['book_no']; ?></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center py-5'>No records found.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>