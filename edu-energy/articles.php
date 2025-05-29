<?php
include 'inc/header.php';
require_once 'inc/functions.php';

$articles = get_articles($conn);
?>
<h2 class="mb-4 fw-bold">Daftar Artikel Energi Ramah Lingkungan</h2>

<?php if(empty($articles)): ?>
  <p>Tidak ada artikel yang tersedia saat ini.</p>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach($articles as $article):
      $img_src = $article['image'] ? 'uploads/' . htmlspecialchars($article['image']) : 'https://source.unsplash.com/400x250/?solar,wind,water,nature,energy';
      $excerpt = substr(strip_tags($article['content'] ?? ''), 0, 120);
      if(strlen($article['content']) > 120) $excerpt .= '...';
    ?>
      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <img src="<?php echo $img_src; ?>" class="card-img-top" alt="thumbnail" loading="lazy" />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
            <p class="text-muted small mb-1">Oleh <?php echo htmlspecialchars($article['author']); ?> | <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($excerpt); ?></p>
            <a href="article_detail.php?id=<?php echo $article['id']; ?>" class="btn btn-primary mt-auto">Baca Lebih Lanjut</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php
include 'inc/footer.php';
?>