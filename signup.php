<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS | User Registration</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url("https://img.freepik.com/free-photo/abundant-collection-antique-books-wooden-shelves-generated-by-ai_188544-29660.jpg");
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: #444;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.92);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .sidebar-content {
            border-right: 1px solid #dee2e6;
        }
        .btn-register {
            width: 100%;
            padding: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="index.php">📚 LMS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
                    <li class="nav-item active"><a class="nav-link" href="signup.php">Signup</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/indexad.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row glass-panel">
            <div class="col-md-4 sidebar-content d-none d-md-block">
                <h5 class="text-primary">Library Hours</h5>
                <p class="small text-muted mb-4">Mon - Sat: 09:00 AM - 12:00 PM</p>
                
                <h5 class="text-primary">Why Join Us?</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">✔️ High-speed Wi-Fi</li>
                    <li class="mb-2">✔️ Quiet Study Zones</li>
                    <li class="mb-2">✔️ Collaborative Spaces</li>
                    <li class="mb-2">✔️ Digital Archive Access</li>
                </ul>
                <hr>
                <p class="font-italic small">"There is more treasure in books than in all the pirate's loot on Treasure Island."</p>
            </div>

            <div class="col-md-8">
                <h3 class="text-center mb-4">Create Your Account</h3>
                <form action="register.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" placeholder="+1..." required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Permanent Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-register">REGISTER NOW</button>
                    <p class="text-center mt-3 small">Already have an account? <a href="index.php">Login here</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>