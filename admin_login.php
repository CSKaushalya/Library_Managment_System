<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | Admin Portal</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --admin-primary: #0f172a; /* Deep Slate for a professional Admin feel */
            --accent-gold: #fbbf24;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), 
                        url("https://img.freepik.com/free-photo/abundant-collection-antique-books-wooden-shelves-generated-by-ai_188544-29660.jpg") center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #f8fafc;
        }

        .navbar {
            backdrop-filter: blur(12px);
            background: rgba(15, 23, 42, 0.9) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .admin-card {
            background: rgba(255, 255, 255, 1);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            color: #1e293b;
        }

        /* Sidebar Info */
        .sidebar-brand {
            background: var(--admin-primary);
            color: white;
            padding: 50px;
            width: 40%;
        }

        /* Form Area */
        .login-form-area {
            padding: 50px;
            width: 60%;
            background: #ffffff;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        }

        .btn-admin {
            background: var(--admin-primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: transform 0.2s ease;
        }

        .btn-admin:hover {
            background: #1e293b;
            color: white;
            transform: translateY(-1px);
        }

        .badge-timing {
            background: rgba(251, 191, 36, 0.2);
            color: #b45309;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .admin-card { flex-direction: column; }
            .sidebar-brand, .login-form-area { width: 100%; padding: 30px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <span style="color: var(--accent-gold)">LMS</span> Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">User Login</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="admin_login.php">Admin Portal</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-warning btn-sm px-4" href="signup.php">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="admin-card">
            <div class="sidebar-brand d-none d-md-block">
                <div class="mb-5">
                    <h2 class="fw-700">LMS Admin</h2>
                    <p class="text-white-50">Control Center & Oversight</p>
                </div>
                
                <div class="mb-4">
                    <small class="text-uppercase tracking-wider text-white-50 fw-bold">Library Hours</small>
                    <div class="mt-2">
                        <span class="badge-timing">09:00 AM - 12:00 PM</span>
                    </div>
                </div>

                <div class="mt-5">
                    <small class="text-uppercase text-white-50 fw-bold">Admin Amenities</small>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2">⚡ System Analytics</li>
                        <li class="mb-2">⚡ User Management</li>
                        <li class="mb-2">⚡ Inventory Control</li>
                    </ul>
                </div>
            </div>

            <div class="login-form-area">
                <div class="text-center mb-5">
                    <h3 class="fw-bold">Administrator Login</h3>
                    <p class="text-muted">Enter your secure credentials below</p>
                </div>

                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ADMIN EMAIL</label>
                        <input type="email" name="email" class="form-control" placeholder="admin@lms.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">SECURE PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn btn-admin shadow">
                        Access Dashboard
                    </button>
                </form>
            <?php 
                if(isset($_POST['login'])){
                    $connection = mysqli_connect("localhost","root","");
                    $db = mysqli_select_db($connection,"lms");
                    $query = "select * from admins where email = '$_POST[email]'";
                    $query_run = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        if($row['email'] == $_POST['email']){
                            if($row['password'] == $_POST['password']){
                                $_SESSION['name'] =  $row['name'];
                                $_SESSION['email'] =  $row['email'];
                                echo "<script>window.location.href='admin_dashboard.php';</script>";
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