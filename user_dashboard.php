<?php
    session_start();
    // Redirect to login if session is not active
    if(!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit();
    }

    /**
     * Fetches the count of books currently issued to the logged-in student.
     */
    function get_user_issue_book_count() {
        $connection = mysqli_connect("localhost", "root", "", "lms");
        $user_id = $_SESSION['id'];
        
        $query = "SELECT COUNT(*) AS total FROM issued_books WHERE student_id = $user_id";
        $query_run = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($query_run);
        
        $count = $row['total'];
        mysqli_close($connection); // Best practice: close connection
        return $count;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard | LMS</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.8)), 
                        url("https://img.freepik.com/free-photo/abundant-collection-antique-books-wooden-shelves-generated-by-ai_188544-29660.jpg");
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .stats-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .stats-card:hover { transform: translateY(-5px); }
        .welcome-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; border-left: 5px solid #007bff; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="user_dashboard.php">📚 Student Portal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="profileDropdown" data-toggle="dropdown">
                            Hi, <?php echo htmlspecialchars($_SESSION['name']); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="view_profile.php">View Profile</a>
                            <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                            <a class="dropdown-item" href="change_password.php">Security</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="welcome-section shadow-sm">
            <h4>User Workspace</h4>
            <p class="text-muted mb-0">Email: <?php echo $_SESSION['email']; ?></p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-header bg-primary text-white font-weight-bold">Books Issued</div>
                    <div class="card-body text-center">
                        <h2 class="display-4 text-primary"><?php echo get_user_issue_book_count(); ?></h2>
                        <p class="card-text text-muted">Books currently in your possession</p>
                        <a href="view_issued_book.php" class="btn btn-outline-primary btn-block">View Details</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-header bg-success text-white font-weight-bold">Search Library</div>
                    <div class="card-body text-center">
                        <h2 class="display-4 text-success">🔍</h2>
                        <p class="card-text text-muted">Find your next favorite read</p>
                        <a href="search_books.php" class="btn btn-outline-success btn-block">Search Catalog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>