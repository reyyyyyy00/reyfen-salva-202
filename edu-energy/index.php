<?php
include 'inc/header.php';
require_once 'inc/functions.php';

$latest_articles = array_slice(get_articles($conn), 0, 3);
?>

<!-- Hero section -->
<section class="position-relative text-white text-center" 
         style="background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1400&q=80') no-repeat center center/cover; height: 60vh;">
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(47,122,10,0.6);"></div>
  <div class="d-flex flex-column justify-content-center align-items-center h-100 position-relative px-3">
    <h1 class="display-4 fw-bold mb-3" style="text-shadow: 2px 2px 6px #000;">Energi Ramah Lingkungan untuk Masa Depan Cerah</h1>
    <p class="lead mb-4 fw-semibold" style="max-width: 700px; text-shadow: 1px 1px 4px #000;">
      Edukasi masyarakat tentang teknologi dan gaya hidup ramah lingkungan yang bisa membawa perubahan positif bagi bumi kita.
    </p>
    <a href="articles.php" class="btn btn-lg btn-primary px-4 py-2 shadow">Lihat Artikel</a>
  </div>
</section>

<!-- Features -->
<section class="my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Kenapa Energi Ramah Lingkungan?</h2>
    <p class="text-muted fs-5">Mengapa kita harus beralih ke teknologi hijau yang ramah lingkungan?</p>
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100 text-center p-4">
        <i class="bi bi-sun fs-1 mb-3 text-warning"></i>
        <h5 class="fw-bold mb-2">Energi Matahari</h5>
        <p>Memanfaatkan cahaya matahari sebagai sumber energi bersih dan tak terbatas.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100 text-center p-4">
        <i class="bi bi-droplet-half fs-1 mb-3 text-info"></i>
        <h5 class="fw-bold mb-2">Energi Air</h5>
        <p>Pemanfaatan air untuk pembangkit listrik ramah lingkungan yang berkelanjutan.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100 text-center p-4">
        <i class="bi bi-wind fs-1 mb-3 text-primary"></i>
        <h5 class="fw-bold mb-2">Energi Angin</h5>
        <p>Memanfaatkan kekuatan angin untuk menghasilkan listrik tanpa polusi.</p>
      </div>
    </div>
  </div>
</section>

<!-- Latest Articles Highlight -->
<section class="my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold">Artikel Terbaru</h2>
    <p class="text-muted fs-5">Ikuti artikel dan pembaruan terbaru tentang energi ramah lingkungan.</p>
  </div>

  <div class="row g-4">
    <?php foreach($latest_articles as $article): 
      $img_src = $article['image'] ? 'uploads/' . htmlspecialchars($article['image']) : 'https://source.unsplash.com/400x250/?nature,energy,environment';
    ?>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <img src="<?php echo $img_src; ?>" class="card-img-top" alt="thumbnail" loading="lazy" />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
            <p class="card-text text-muted small mb-2">Oleh <?php echo htmlspecialchars($article['author']); ?> - <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
            <a href="article_detail.php?id=<?php echo $article['id']; ?>" class="btn btn-primary mt-auto align-self-start">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php
include 'inc/footer.php';
?>