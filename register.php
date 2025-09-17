<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: tasks.php");
    exit();
}

include 'src/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $statement->execute([$username, $email]);
    $existingUser = $statement->fetch();

    if ($existingUser) {
        if ($existingUser['username'] === $username) {
            $error = "Username already taken. Please choose another.";
        } else {
            $error = "An account with this email already exists.";
        }
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $insertStatement = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $insertStatement->execute([$username, $email, $hashedPassword]);

        header("Location: login.php?status=success&message=" . urlencode("Registration successful! Please log in."));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="public/styles.css">
</head>
<body class="bg-light">

<div class="auth-container">
    <div class="card shadow-sm">
        <div class="card-body p-5">
            <h2 class="card-title text-center mb-4">Register</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn button-blues w-100 mt-3">Register</button>
                
                <p class="text-center mt-3 mb-0">
                    Already have an account? <a href="login.php">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>