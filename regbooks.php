<?php
    session_start();
    // Redirect if not logged in
    if(!isset($_SESSION['name'])) {
        header("Location: admin_login.php");
    }

    $connection = mysqli_connect("localhost","root","","lms");
    
    // Optimized Query: Fetches book details and the linked author name
    $query = "SELECT books.book_name, books.book_no, books.book_price, authors.author_name 
              FROM books 
              LEFT JOIN authors ON books.author_id = authors.author_id";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | All Registered Books</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .table-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            <div class="text-white small">
                <strong>Welcome: <?php echo $_SESSION['name'];?></strong> | <?php echo $_SESSION['email'];?>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 table-container">
                <h4 class="text-center mb-4">Master Inventory: Registered Books</h4>
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Price (USD)</th>
                            <th>Book ID / No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query_run = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_assoc($query_run)){
                                ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo htmlspecialchars($row['book_name']);?></td>
                                    <td><?php echo htmlspecialchars($row['author_name'] ?? 'N/A');?></td>
                                    <td class="text-success">$<?php echo number_format($row['book_price'], 2);?></td>
                                    <td><span class="badge badge-info"><?php echo $row['book_no'];?></span></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>
</html>