<?php
require __DIR__ . '/../helpers.php';
include __DIR__ . '/../header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = fetchOne($pdo, "SELECT p.*, c.name AS category_name
  FROM posts p LEFT JOIN categories c ON c.id = p.category_id
  WHERE p.id = :id AND status = 'published'", [':id'=>$id]);

if(!$post){
  echo '<div class="alert alert-danger">Postimi nuk u gjet.</div>';
  include __DIR__ . '/../footer.php'; exit;
}
?>
<article>
  <h2><?= esc($post['title']) ?></h2>
  <small class="text-muted"><?= esc($post['category_name']) ?></small>
  <?php if(!empty($post['image'])): ?>
    <img src="<?= esc($post['image']) ?>" alt="" class="img-fluid my-3">
  <?php endif; ?>
  <div class="mt-3"><?= nl2br(esc($post['content'])) ?></div>
</article>
<?php include __DIR__ . '/../footer.php'; ?>
