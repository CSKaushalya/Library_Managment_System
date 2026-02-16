<?php
    require("functions.php");
    session_start();
    
    // Connection & Security
    $conn = new mysqli("localhost", "root", "", "lms");
    if(!isset($_SESSION['email'])) { header("Location: admin_login.php"); exit(); }

    // Fetch current book data securely
    $book_no_get = $_GET['bn'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE book_no = ?");
    $stmt->bind_param("i", $book_no_get);
    $stmt->execute();
    $res = $stmt->get_result();
    $book = $res->fetch_assoc();

    // Handle Update
    if(isset($_POST['update'])){
        $update_stmt = $conn->prepare("UPDATE books SET book_name=?, author_id=?, cat_id=?, book_price=? WHERE book_no=?");
        $update_stmt->bind_param("siidi", $_POST['book_name'], $_POST['author_id'], $_POST['cat_id'], $_POST['book_price'], $book_no_get);
        if($update_stmt->execute()){
            header("location:manage_book.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Edit Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary-dark: #1e293b; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background: var(--primary-dark); color: #fff; }
        #content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        
        .form-card { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); background: #fff; }
        .form-label { font-weight: 600; font-size: 0.8rem; color: #64748b; text-transform: uppercase; }
        .form-control, .form-select { padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .input-readonly { background-color: #f1f5f9 !important; cursor: not-allowed; }
        .btn-update { background: #3b82f6; color: white; border: none; padding: 12px 25px; border-radius: 10px; font-weight: 600; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="p-4 text-center fw-bold border-bottom border-secondary">📚 LMS ADMIN</div>
        <div class="p-3 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white-50" href="admin_dashboard.php">📊 Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="manage_book.php">📖 Manage Books</a></li>
            </ul>
        </div>
    </nav>

    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="manage_book.php" class="text-decoration-none">Inventory</a></li>
                    <li class="breadcrumb-item active">Edit Book</li>
                </ol>
            </nav>
        </div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card form-card">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="fw-bold mb-4">Edit Book Details</h3>
                            
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Book Number (ID)</label>
                                        <input type="text" class="form-control input-readonly" value="<?php echo $book['book_no'];?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Book Name</label>
                                        <input type="text" name="book_name" value="<?php echo htmlspecialchars($book['book_name']);?>" class="form-control" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Author</label>
                                        <select name="author_id" class="form-select" required>
                                            <?php
                                                $auth_res = mysqli_query($conn, "SELECT * FROM authors");
                                                while($auth = mysqli_fetch_assoc($auth_res)){
                                                    $selected = ($auth['author_id'] == $book['author_id']) ? "selected" : "";
                                                    echo "<option value='".$auth['author_id']."' $selected>".$auth['author_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="cat_id" class="form-select" required>
                                            <?php
                                                $cat_res = mysqli_query($conn, "SELECT * FROM category");
                                                while($cat = mysqli_fetch_assoc($cat_res)){
                                                    $selected = ($cat['cat_id'] == $book['cat_id']) ? "selected" : "";
                                                    echo "<option value='".$cat['cat_id']."' $selected>".$cat['cat_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label">Book Price ($)</label>
                                        <input type="text" name="book_price" value="<?php echo $book['book_price'];?>" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2 mt-2">
                                    <button type="submit" name="update" class="btn btn-update w-100 shadow-sm">Update Inventory</button>
                                    <a href="manage_book.php" class="btn btn-light border w-50">Cancel</a>
                                </div>
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