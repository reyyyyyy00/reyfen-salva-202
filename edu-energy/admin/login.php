<?php
include '../inc/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi';
    } else {
        require_once '../inc/functions.php';

        // Cek apakah username adalah admin / user
        if (admin_exists($conn, $username)) {
            // Verifikasi admin
            $admin_id = verify_admin($conn, $username, $password);
            if ($admin_id) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                header('Location: dashboard.php'); 
                exit;
            } else {
                $error = 'Username atau password salah';
            }
        } else {
            
            $user_id = verify_user($conn, $username, $password);
            if ($user_id) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_username'] = $username;
                header('Location: ../index.php'); 
                exit;
            } else {
                $error = 'Username atau password salah';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login User - Edu Energi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
body {
    background: linear-gradient(135deg, #2f7a0a, #9fdf8c);
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f0f4f2;
}
.card {
    background-color: rgba(47, 122, 10, 0.9);
    border-radius: 1rem;
    padding: 2rem;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 0 20px rgba(255, 183, 3, 0.7);
}
.card h3 {
    margin-bottom: 1.5rem;
    text-align: center;
    font-weight: 700;
    letter-spacing: 1px;
}
.form-control {
    background-color: #d1e7b3;
    border: none;
    color: #2e4600;
}
.form-control:focus {
    box-shadow: 0 0 5px #ffb703;
    border-color: #ffb703;
}
.btn-primary {
    background-color: #ffb703;
    border: none;
    color: #2f7a0a;
    font-weight: 600;
    transition: background-color 0.3s ease;
}
.btn-primary:hover {
    background-color: #2f7a0a;
    color: #ffb703;
}
.alert {
    background-color: #ffb703;
    color: #2f7a0a;
    font-weight: 600;
    text-align: center;
}
</style>
</head>
<body>
<div class="card">
    <h3><i class="bi bi-shield-lock-fill me-2"></i>Login User</h3>
    <?php if ($error): ?>
    <div class="alert mb-3"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required value="<?php echo htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk <i class="bi bi-box-arrow-in-right ms-1"></i></button>
    </form>
    <p class="mt-3 text-center">Belum punya akun? <a href="register.php" class="text-warning text-decoration-none">Daftar di sini</a></p>
</div>
</body>
</html>