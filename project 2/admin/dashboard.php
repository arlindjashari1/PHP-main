<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../functions/helpers.php';
require __DIR__ . '/../functions/auth.php';
require_login();
include __DIR__ . '/../partials/header.php';

$counts = [
  'posts'      => fetchOne($pdo, "SELECT COUNT(*) AS c FROM posts")['c'] ?? 0,
  'published'  => fetchOne($pdo, "SELECT COUNT(*) AS c FROM posts WHERE status='published'")['c'] ?? 0,
  'categories' => fetchOne($pdo, "SELECT COUNT(*) AS c FROM categories")['c'] ?? 0,
  'events'     => fetchOne($pdo, "SELECT COUNT(*) AS c FROM events")['c'] ?? 0,
  'slides'     => fetchOne($pdo, "SELECT COUNT(*) AS c FROM slides")['c'] ?? 0,
];
?>
<h3>Dashboard</h3>
<div class="row">
  <?php foreach($counts as $label => $val): ?>
    <div class="col-md-3 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?= esc(ucfirst($label)) ?></h5>
          <p class="display-6"><?= (int)$val ?></p>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<div class="mt-3">
  <a class="btn btn-primary" href="posts.php">Menaxho Postimet</a>
  <a class="btn btn-secondary" href="categories.php">Kategoritë</a>
  <a class="btn btn-info" href="events.php">Evenimentet</a>
  <a class="btn btn-warning" href="slider.php">Slider</a>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>