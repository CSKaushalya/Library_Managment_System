<?php
    session_start();
    // Security Check
    if(!isset($_SESSION['email'])) { header("Location: index.php"); exit(); }

    $connection = mysqli_connect("localhost","root","", "lms");

    if(isset($_POST['issue_book'])) {
        // Prepare data
        $book_no = $_POST['book_no'];
        $book_name = $_POST['book_name'];
        $book_author = $_POST['book_author'];
        $student_id = $_POST['student_id'];
        $issue_date = $_POST['issue_date'];

        // Logic: Insert into issued_books (assuming '1' is the status for 'Issued')
        $query = "INSERT INTO issued_books (book_no, book_name, book_author, student_id, status, issue_date) 
                  VALUES (?, ?, ?, ?, 1, ?)";
        
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "issis", $book_no, $book_name, $book_author, $student_id, $issue_date);
        
        if(mysqli_stmt_execute($stmt)) {
            echo "<script type='text/javascript'>
                    alert('Book issued successfully!');
                    window.location.href = 'admin_dashboard.php';
                  </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Issue Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link.active { background: rgba(255,255,255,0.1); color: #fff !important; font-weight: 600; border-radius: 8px; }

        .issue-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; max-width: 600px; margin: 40px auto; }
        .form-control, .form-select { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .btn-issue { background: #3b82f6; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; transition: 0.2s; }
        .btn-issue:hover { background: #2563eb; transform: translateY(-1px); }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="issue_book.php">✍️ Issue Book</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_book.php">📖 Manage Books</a></li>
                <li class="nav-item mt-4"><a class="nav-link text-danger" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white shadow-sm d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Circulation Desk</h5>
            <span class="text-muted small">Admin: <?php echo $_SESSION['name']; ?></span>
        </div>

        <div class="container py-4">
            <div class="issue-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">New Book Issue</h3>
                    <p class="text-muted small">Assign a library asset to a student record.</p>
                </div>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label small fw-bold text-muted">BOOK NAME</label>
                            <input type="text" name="book_name" class="form-control" placeholder="Search or type book name..." required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label small fw-bold text-muted">AUTHOR NAME</label>
                            <select class="form-select" name="book_author" required>
                                <option value="">- Select Author -</option>
                                <?php  
                                    $auth_query = "SELECT author_name FROM authors ORDER BY author_name ASC";
                                    $auth_run = mysqli_query($connection, $auth_query);
                                    while($row = mysqli_fetch_assoc($auth_run)){
                                        echo "<option value='".$row['author_name']."'>".$row['author_name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">BOOK NUMBER</label>
                            <input type="number" name="book_no" class="form-control" placeholder="e.g. 101" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">STUDENT ID</label>
                            <input type="text" name="student_id" class="form-control" placeholder="e.g. S-990" required>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label small fw-bold text-muted">ISSUE DATE</label>
                            <input type="date" name="issue_date" class="form-control" value="<?php echo date("Y-m-d");?>" required>
                        </div>
                    </div>

                    <button type="submit" name="issue_book" class="btn btn-issue shadow-sm">
                        Confirm & Issue Book
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>