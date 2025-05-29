<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}


function current_page() {
    return basename($_SERVER['SCRIPT_NAME']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edu Energi Ramah Lingkungan</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&amp;display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    :root {
      --green-primary: #2f7a0a;
      --green-light: #9fdf8c;
      --yellow-primary: #ffe066;
      --yellow-dark: #ffb703;
      --text-dark: #2e4600;
      --bg-light: #f7fbf2;
      --shadow-color: rgba(139, 195, 74, 0.4);
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg-light);
      color: var(--text-dark);
      scroll-behavior: smooth;
    }
    /* Navbar */
    nav.navbar {
      background: linear-gradient(90deg, var(--green-primary), var(--green-light));
      box-shadow: 0 2px 6px var(--shadow-color);
      font-weight: 500;
    }
    nav.navbar a.nav-link {
      color: #f0f4f2;
      transition: color 0.3s ease;
    }
    nav.navbar a.nav-link:hover,
    nav.navbar a.nav-link.active {
      color: var(--yellow-dark);
      font-weight: 700;
    }
    nav.navbar .navbar-brand {
      font-weight: 700;
      font-size: 1.6rem;
      color: #f0f4f2;
      letter-spacing: 1.5px;
      text-shadow: 0 0 6px var(--yellow-primary);
    }
    nav.navbar .navbar-toggler {
      border-color: rgba(255,255,255,0.4);
    }
    nav.navbar .navbar-toggler-icon {
      color: #f0f4f2;
    }
    /* Footer */
    footer.footer {
      background: var(--green-primary);
      color: #e6f2e6;
      padding: 1.5rem 0;
      font-size: 0.9rem;
      text-align: center;
    }
    footer.footer a {
      color: var(--yellow-primary);
      margin: 0 0.5rem;
      transition: color 0.3s ease;
    }
    footer.footer a:hover {
      color: var(--yellow-dark);
      text-decoration: none;
    }
    /* Button primary */
    .btn-primary {
      background: var(--green-primary);
      border-color: var(--green-primary);
      font-weight: 600;
      box-shadow: 0 2px 8px var(--shadow-color);
      transition: background 0.3s ease;
    }
    .btn-primary:hover, .btn-primary:focus {
      background: var(--yellow-dark);
      border-color: var(--yellow-dark);
      color: var(--green-primary);
      box-shadow: 0 2px 15px var(--yellow-dark);
    }
    a.btn-secondary {
      background: var(--yellow-primary);
      border: none;
      color: var(--green-primary);
      font-weight: 600;
      transition: background 0.3s ease;
    }
    a.btn-secondary:hover {
      background: var(--yellow-dark);
      color: #fff;
    }
    main.container {
      margin-bottom: 4rem;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="bi bi-leaf-fill"></i> Edu Energi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" 
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php if(current_page()=='index.php') echo 'active'; ?>" href="/edu-energy/index.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if(current_page()=='articles.php') echo 'active'; ?>" href="/edu-energy/articles.php">Artikel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if(current_page()=='about.php') echo 'active'; ?>" href="/edu-energy/about.php">Tentang</a>
        </li>
        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $currentPage === 'admin' ? 'active fw-bold' : ''; ?>" href="/edu-energy/admin/dashboard.php">Admin</a>
                            </li>
          <li class="nav-item">
            <a class="nav-link" href="admin/logout.php">Logout</a>
          </li>
        <?php elseif (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
          <li class="nav-item">
            <a class="nav-link" href="admin/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?php if(current_page()=='login.php' || current_page()=='register.php') echo 'active'; ?>" href="admin/login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
