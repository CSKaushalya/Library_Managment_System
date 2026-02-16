<?php
    require("functions.php");
    session_start();
    
    // Connection & Security
    $conn = new mysqli("localhost", "root", "", "lms");
    if(!isset($_SESSION['email'])) { header("Location: admin_login.php"); exit(); }

    // Fetch Category Data Securely
    $cid = $_GET['cid'];
    $stmt = $conn->prepare("SELECT cat_name FROM category WHERE cat_id = ?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    $cat = $result->fetch_assoc();
    $cat_name = $cat['cat_name'] ?? '';

    // Handle Update Logic
    if(isset($_POST['update_cat'])){
        $new_cat_name = $_POST['cat_name'];
        $update_stmt = $conn->prepare("UPDATE category SET cat_name = ? WHERE cat_id = ?");
        $update_stmt->bind_param("si", $new_cat_name, $cid);
        if($update_stmt->execute()){
            header("location:manage_cat.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Edit Category</title>
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

        .form-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; max-width: 500px; margin: 60px auto; }
        .form-control { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .btn-update { background: #3b82f6; color: white; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; flex-grow: 1; }
        .btn-cancel { background: #f1f5f9; color: #475569; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; text-decoration: none; text-align: center; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage_cat.php">📁 Manage Categories</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="p-4 bg-white shadow-sm d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Classification Editor</h5>
            <span class="badge bg-primary rounded-pill">Category ID: <?php echo $cid; ?></span>
        </div>

        <div class="container">
            <div class="card form-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="display-6 mb-2">📂</div>
                        <h3 class="fw-bold">Edit Category</h3>
                        <p class="text-muted small">Update the name of this book classification.</p>
                    </div>

                    <form action="" method="post">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">CATEGORY NAME</label>
                            <input type="text" class="form-control" name="cat_name" 
                                   value="<?php echo htmlspecialchars($cat_name); ?>" required>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_cat" class="btn btn-update shadow-sm">
                                Save Changes
                            </button>
                            <a href="manage_cat.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>