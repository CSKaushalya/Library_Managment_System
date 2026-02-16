<?php
    session_start();
    // Redirect if not logged in
    if(!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit();
    }

    $connection = mysqli_connect("localhost", "root", "", "lms");
    
    // Safety: use the session ID to filter books for the current user only
    $student_id = $_SESSION['id'];
    $query = "SELECT book_name, book_author, book_no FROM issued_books WHERE student_id = $student_id AND status = 1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Issued Books</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <style>
        .table-container { margin-top: 50px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .marquee-text { background: #ffc107; color: #000; padding: 5px; font-weight: 500; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">LMS | Student Portal</a>
            <div class="text-white small">
                <strong>User: <?php echo $_SESSION['name'];?></strong>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Settings</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="view_profile.php">My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="marquee-text">
        <marquee>Reminder: Please return your books on time to avoid fines. Library closes at 8:00 PM.</marquee>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-container">
                    <h4 class="text-center mb-4">Books Currently Issued to You</h4>
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>Book Name</th>
                                <th>Author</th>
                                <th>Book Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query_run = mysqli_query($connection, $query);
                                if(mysqli_num_rows($query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_run)){
                                        ?>
                                        <tr>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['book_name']);?></td>
                                            <td><?php echo htmlspecialchars($row['book_author']);?></td>
                                            <td><span class="badge badge-info"><?php echo htmlspecialchars($row['book_no']);?></span></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-muted py-4'>You have no books currently issued.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="user_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>