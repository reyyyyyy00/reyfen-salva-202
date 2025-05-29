<?php
include '../inc/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');
    $terms = isset($_POST['terms']);

    if ($username === '' || $password === '' || $password_confirm === '') {
        $error = 'Semua field harus diisi';
    } elseif ($password !== $password_confirm) {
        $error = 'Password dan konfirmasi password tidak sama';
    } elseif (!$terms) {
        $error = 'Anda harus menyetujui syarat dan ketentuan';
    } else {
        require_once '../inc/functions.php';
        if (user_exists($conn, $username)) {
            $error = 'Username sudah terdaftar';
        } else {
            if (create_user($conn, $username, $password)) {
                $success = 'Registrasi berhasil. Silakan login.';
            } else {
                $error = 'Gagal mendaftar. Silakan coba lagi.';
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
<title>Register User - Edu Energi</title>
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
.alert-success {
    background-color: #a3d977;
    color: #2f7a0a;
    font-weight: 600;
    text-align: center;
    margin-bottom: 20px;
}
.alert-danger {
    background-color: #ffb703;
    color: #2f7a0a;
    font-weight: 600;
    text-align: center;
    margin-bottom: 20px;
}
</style>
</head>
<body>
<div class="card">
    <h3><i class="bi bi-person-plus-fill me-2"></i>Daftar User Baru</h3>
    <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required value="<?php echo htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-4">
            <label for="password_confirm" class="form-label">Konfirmasi Password:</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="terms" name="terms">
            <label class="form-check-label" for="terms">Saya setuju dengan <a href="#" class="text-warning">syarat dan ketentuan</a></label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Daftar <i class="bi bi-check-lg ms-1"></i></button>
    </form>
    <p class="mt-3 text-center">Sudah punya akun? <a href="login.php" class="text-warning text-decoration-none">Login di sini</a></p>
</div>
</body>
</html>