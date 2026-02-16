<?php
    session_start();
    // Redirect if admin is not logged in
    if(!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    $connection = mysqli_connect("localhost", "root", "", "lms");
    
    // Optimized query to fetch active issued books (status = 1)
    $query = "SELECT issued_books.book_name, issued_books.book_author, issued_books.book_no, users.name 
              FROM issued_books 
              LEFT JOIN users ON issued_books.student_id = users.id 
              WHERE issued_books.status = 1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Issued Books Detail</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .table-card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; }
        .marquee-strip { background: #343a40; color: white; padding: 5px 0; font-size: 0.9rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">LMS Admin</a>
            <div class="text-white small">
                <strong>Welcome: <?php echo $_SESSION['name'];?></strong> (<?php echo $_SESSION['email'];?>)
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Profile</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="view_profile_admin.php">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="marquee-strip">
        <marquee>Library Hours: 8:00 AM to 8:00 PM | Current System Status: Operational</marquee>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-card">
                    <h4 class="text-center text-secondary mb-4">Currently Issued Books</h4>
                    <table class="table table-hover table-striped text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Book Name</th>
                                <th>Author</th>
                                <th>Book ID</th>
                                <th>Issued To (Student)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query_run = mysqli_query($connection, $query);
                                if(mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        ?>
                                        <tr>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['book_name']);?></td>
                                            <td><?php echo htmlspecialchars($row['book_author']);?></td>
                                            <td><span class="badge badge-secondary"><?php echo $row['book_no'];?></span></td>
                                            <td><u class="text-primary"><?php echo htmlspecialchars($row['name']);?></u></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-muted'>No books are currently issued.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>
</html>