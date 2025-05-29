<?php
include '../inc/config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once '../inc/functions.php';

$msg = '';
$edit_article = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_article'])) {
        $title = trim($_POST['title']) ?? '';
        $author = trim($_POST['author']) ?? '';
        $content = trim($_POST['content']) ?? '';
        $image = trim($_POST['image']) ?? '';

        if (empty($title) || empty($author) || empty($content)) {
            $msg = 'Semua field wajib diisi.';
        } else {
            if (create_article($conn, $title, $author, $content, $image)) {
                $msg = 'Artikel berhasil ditambahkan.';
            } else {
                $msg = 'Gagal menambahkan artikel.';
            }
        }
    } elseif (isset($_POST['update_article'])) {
        $id = intval($_POST['id']);
        $title = trim($_POST['title']) ?? '';
        $author = trim($_POST['author']) ?? '';
        $content = trim($_POST['content']) ?? '';
        $image = trim($_POST['image']) ?? '';

        if (empty($title) || empty($author) || empty($content)) {
            $msg = 'Semua field wajib diisi.';
        } else {
            $existing_article = get_article_by_id($conn, $id);
            if (!$existing_article) {
                $msg = 'Artikel tidak ditemukan.';
            } else {
                if (update_article($conn, $id, $title, $author, $content, $image)) {
                    $msg = 'Artikel berhasil diperbarui.';
                } else {
                    $msg = 'Gagal memperbarui artikel.';
                }
            }
        }
    } elseif (isset($_POST['delete_article'])) {
        $id = intval($_POST['delete_article']);
        $article_to_delete = get_article_by_id($conn, $id);

        if ($article_to_delete) {
            if ($article_to_delete['image']) {
                $img_path = '../uploads/' . $article_to_delete['image'];
                if (file_exists($img_path)) {
                    unlink($img_path);
                }
            }
            if (delete_article($conn, $id)) {
                $msg = 'Artikel berhasil dihapus.';
            } else {
                $msg = 'Gagal menghapus artikel.';
            }
        } else {
            $msg = 'Artikel tidak ditemukan.';
        }
    }
}

// For editing, get article data to prefill the form
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_article = get_article_by_id($conn, intval($_GET['edit']));
}

$articles = get_articles($conn);
include '../inc/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard Admin - Edu Energi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
body {
    background-color: #f7fbf2;
    color: #2e4600;
}
.navbar {
    background: linear-gradient(90deg, #2f7a0a, #9fdf8c);
}
.navbar-brand, .nav-link, .btn-link {
    color: #f0f4f2 !important;
}
.navbar-brand:hover, .nav-link:hover {
    color: #ffb703 !important;
}
.table thead {
    background-color: #9fdf8c;
    color: #2f7a0a;
}
.img-thumbnail {
    max-width: 120px;
    height: auto;
    object-fit: cover;
    border-radius: 4px;
}
</style>
</head>
<body>

<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>

    <!-- Form for Add/Edit Article -->
<?php if (isset($_GET['edit'])): ?>
<div class="container mt-4">
    <h2><?php echo $edit_article ? 'Edit Artikel' : 'Tambah Artikel'; ?></h2>
    <form method="post" action="dashboard.php">
        <?php if ($edit_article): ?>
            <input type="hidden" name="id" value="<?php echo intval($edit_article['id']); ?>" />
        <?php endif; ?>
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title" class="form-control" required value="<?php echo $edit_article ? htmlspecialchars($edit_article['title']) : ''; ?>" />
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Penulis</label>
            <input type="text" name="author" id="author" class="form-control" required value="<?php echo $edit_article ? htmlspecialchars($edit_article['author']) : ''; ?>" />
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Isi Artikel</label>
            <textarea name="content" id="content" rows="6" class="form-control" required><?php echo $edit_article ? htmlspecialchars($edit_article['content']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Artikel (masukkan nama file yang sudah diupload)</label>
            <input type="text" name="image" id="image" class="form-control" value="<?php echo $edit_article ? htmlspecialchars($edit_article['image']) : ''; ?>" />
            <small class="form-text text-muted">Masukkan nama file gambar yang sudah diupload ke folder uploads.</small>
        </div>
        <?php if ($edit_article): ?>
            <button type="submit" name="update_article" class="btn btn-success me-2">Update Artikel</button>
        <?php else: ?>
            <button type="submit" name="create_article" class="btn btn-success me-2">Tambah Artikel</button>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php endif; ?>

    <?php if ($msg): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($msg); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <br>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Artikel</h3>
        <a href="?edit=new" class="btn btn-primary">
            <i class="bi bi-plus-lg btn-success"></i> Tambah Artikel
        </a>
    </div>

    <?php if (empty($articles)): ?>
    <p>Belum ada artikel yang tersedia.</p>
    <?php else: ?>
    <div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tanggal Dibuat</th>
                <th style="width: 130px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($articles as $art): ?>
            <tr>
                <td>
                    <?php if ($art['image']): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($art['image']); ?>" alt="Gambar Artikel" class="img-thumbnail" />
                    <?php else: ?>
                        <span class="text-muted fst-italic">Tidak ada</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($art['title']); ?></td>
                <td><?php echo htmlspecialchars($art['author']); ?></td>
                <td><?php echo date('d M Y', strtotime($art['created_at'])); ?></td>
                <td>
                    <a href="?edit=<?php echo intval($art['id']); ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form method="post" action="" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                        <button type="submit" name="delete_article" value="<?php echo intval($art['id']); ?>" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
