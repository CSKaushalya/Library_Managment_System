<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library Management System</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url("https://img.freepik.com/free-photo/abundant-collection-antique-books-wooden-shelves-generated-by-ai_188544-29660.jpg") center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(33, 37, 41, 0.9) !important;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .info-section {
            background: #212529;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section {
            padding: 40px;
            background: white;
        }

        .btn-primary {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 5px;
        }

        .quote-text {
            font-style: italic;
            color: #ffc107;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">📚 LMS PRO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">User Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_login.php">Admin Login</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light btn-sm ms-lg-3" href="signup.php">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <div class="glass-card">
            <div class="row g-0">
                <div class="col-lg-5 info-section d-none d-lg-flex">
                    <h4 class="mb-4 text-warning">Library Highlights</h4>
                    <p class="quote-text mb-2">“There is more treasure in books than in all the pirate's loot on Treasure Island”</p>
                    <p class="small text-secondary mb-4">— Walt Disney</p>
                    
                    <hr class="border-secondary">
                    
                    <div class="mb-3">
                        <h6 class="text-uppercase small fw-bold">Hours</h6>
                        <p class="mb-0">9:00 AM — 12:00 PM</p>
                    </div>

                    <div>
                        <h6 class="text-uppercase small fw-bold">Amenities</h6>
                        <ul class="list-unstyled small">
                            <li>✓ AC Rooms & Wi-fi</li>
                            <li>✓ Quiet Learning Zones</li>
                            <li>✓ Discussion Rooms</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-7 form-section">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Welcome Back</h2>
                        <p class="text-muted">Please enter your credentials to log in.</p>
                    </div>

                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary shadow-sm mb-3">Sign In</button>
                        
                        <div class="text-center">
                            <span class="text-muted small">Don't have an account?</span> 
                            <a href="signup.php" class="text-decoration-none small fw-bold">Create Account</a>
                        </div>
                    </form>
            <?php 
                if(isset($_POST['login'])){
                    $connection = mysqli_connect("localhost","root","");
                    $db = mysqli_select_db($connection,"lms");
                    $query = "select * from users where email = '$_POST[email]'";
                    $query_run = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        if($row['email'] == $_POST['email']){
                            if($row['password'] == $_POST['password']){
                                $_SESSION['name'] =  $row['name'];
                                $_SESSION['email'] =  $row['email'];
                                $_SESSION['id'] =  $row['id'];
                                echo "<script>window.location.href='user_dashboard.php';</script>";
                            }
                            else{
                                ?>
                                <br><br><center><span class="alert-danger">Wrong Password !!</span></center>
                                <?php
                            }
                        }
                    }
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>