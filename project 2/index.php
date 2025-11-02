<?php

<link rel="stylesheet" href="C:\xampp\htdocs\xampp\PHP-main\project 2\index.php">
require __DIR__ . '/config/db.php';
require __DIR__ . '/functions/helpers.php';
include __DIR__ . '/partials/header.php';

$search = $_GET['q'] ?? '';
$categoryId = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

$slides = fetchAll($pdo, "SELECT * FROM slides ORDER BY id DESC LIMIT 5");
$categories = fetchAll($pdo, "SELECT * FROM categories ORDER BY name ASC");

$where = " WHERE status = 'published' ";
$params = [];
if($categoryId > 0) { $where .= " AND category_id = :cat "; $params[':cat'] = $categoryId; }
if($search !== '') { $where .= " AND (title LIKE :q OR content LIKE :q) "; $params[':q'] = '%'.$search.'%'; }

$posts = fetchAll($pdo, "SELECT p.*, c.name AS category_name FROM posts p
  LEFT JOIN categories c ON c.id = p.category_id
  {$where}
  ORDER BY p.id DESC LIMIT 12", $params);
?>
<div class="row mb-3">
  <div class="col-md-8">
    <h4>Slider</h4>
    <?php if ($slides): ?>
      <?php foreach($slides as $s): ?>
        <div class="slide-card">
          <strong><?= esc($s['caption']) ?></strong><br>
          <small><?= esc($s['image_url']) ?></small>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning">S'ka slajde. Shto disa në panelin admin.</div>
    <?php endif; ?>
  </div>
  <div class="col-md-4">
    <form class="mb-3" method="get">
      <div class="input-group">
        <input name="q" value="<?= esc($search) ?>" class="form-control" placeholder="Kërko...">
        <button class="btn btn-primary">Kërko</button>
      </div>
    </form>
    <div class="list-group">
      <a class="list-group-item<?= $categoryId===0?' active':'' ?>" href="?">Të gjitha</a>
      <?php foreach($categories as $c): ?>
        <a class="list-group-item<?= $categoryId===$c['id']?' active':'' ?>" href="?cat=<?= (int)$c['id'] ?>"><?= esc($c['name']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<h4>Postimet e fundit</h4>
<?php if(!$posts): ?>
  <div class="alert alert-info">Asnjë postim i publikuar ende.</div>
<?php else: ?>
  <?php foreach($posts as $p): ?>
    <div class="post-card">
      <h5><?= esc($p['title']) ?></h5>
      <small class="text-muted"><?= esc($p['category_name']) ?></small>
      <?php if(!empty($p['image'])): ?>
        <img src="<?= esc($p['image']) ?>" alt="" class="img-fluid my-2">
      <?php endif; ?>
      <p><?= nl2br(esc(mb_strimwidth($p['content'], 0, 300, '...'))) ?></p>
      <a class="btn btn-sm btn-outline-primary" href="public/post.php?id=<?= (int)$p['id'] ?>">Lexo më shumë</a>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>