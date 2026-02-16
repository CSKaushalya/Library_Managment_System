<?php
    require("functions.php");
    session_start();
    
    // 1. Connection & Security
    $conn = new mysqli("localhost", "root", "", "lms");
    if(!isset($_SESSION['email'])) { header("Location: admin_login.php"); exit(); }

    // 2. Fetch Data Securely
    $author_id = $_GET['aid'];
    $stmt = $conn->prepare("SELECT author_name FROM authors WHERE author_id = ?");
    $stmt->bind_param("i", $author_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $author_name = $row['author_name'] ?? '';

    // 3. Handle Update
    if(isset($_POST['update_author'])){
        $new_name = $_POST['author_name'];
        $update_stmt = $conn->prepare("UPDATE authors SET author_name = ? WHERE author_id = ?");
        $update_stmt->bind_param("si", $new_name, $author_id);
        $update_stmt->execute();
        header("location:manage_author.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Edit Author</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; z-index: 1000; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        
        .nav-link { color: #94a3b8 !important; padding: 12px 20px !important; }
        .nav-link.active { background: rgba(255,255,255,0.05); color: #fff !important; font-weight: 600; }

        .form-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; max-width: 550px; margin: 50px auto; }
        .form-control { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .btn-update { background: #3b82f6; color: white; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; transition: 0.2s; }
        .btn-cancel { background: #f1f5f9; color: #475569; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage_author.php">✍️ Manage Authors</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white shadow-sm d-flex justify-content-between">
            <h5 class="mb-0 fw-bold">Edit Records</h5>
            <span class="text-muted small">Admin Session: <?php echo $_SESSION['email']; ?></span>
        </div>

        <div class="container py-5">
            <div class="card form-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h3 class="fw-bold mb-1">Update Author</h3>
                        <p class="text-muted small">ID Reference: #<?php echo $author_id; ?></p>
                    </div>

                    <form action="" method="post">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Author Name</label>
                            <input type="text" class="form-control" name="author_name" 
                                   value="<?php echo htmlspecialchars($author_name); ?>" required>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_author" class="btn btn-update shadow-sm">
                                Save Changes
                            </button>
                            <a href="manage_author.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>