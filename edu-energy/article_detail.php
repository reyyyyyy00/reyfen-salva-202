<?php
include 'inc/header.php';
require_once 'inc/functions.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger">ID artikel tidak valid.</div>';
    include 'inc/footer.php';
    exit;
}
$id = intval($_GET['id']);
$article = get_article_by_id($conn, $id);
if (!$article) {
    echo '<div class="alert alert-warning">Artikel tidak ditemukan.</div>';
    include 'inc/footer.php';
    exit;
}
$img_src = $article['image'] ? 'uploads/' . htmlspecialchars($article['image']) : 'https://source.unsplash.com/850x350/?environment,renewable,energy,nature';
?>
<article class="mx-auto" style="max-width: 850px;">
  <h2 class="fw-bold mb-2"><?php echo htmlspecialchars($article['title']); ?></h2>
  <p class="text-muted fst-italic mb-4">Ditulis oleh <?php echo htmlspecialchars($article['author']); ?> pada <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
  <img src="<?php echo $img_src; ?>" class="img-fluid rounded mb-4 shadow-sm" alt="article image" loading="lazy" />
  <div class="lh-lg fs-5" style="white-space: pre-line;"><?php echo nl2br(htmlspecialchars($article['content'])); ?></div>
  <a href="articles.php" class="btn btn-secondary mt-4">Kembali ke Daftar Artikel</a>
</article>
<?php
include 'inc/footer.php';
?>