<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../functions/helpers.php';
include __DIR__ . '/../partials/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = fetchOne($pdo, "SELECT p.*, c.name AS category_name FROM posts p
  LEFT JOIN categories c ON c.id = p.category_id
  WHERE p.id = :id AND status = 'published'", [':id' => $id]);

if(!$post) {
  echo '<div class="alert alert-danger">Postimi nuk u gjet.</div>';
  include __DIR__ . '/../partials/footer.php';
  exit;
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
$comments = fetchAll($pdo, "SELECT * FROM comments WHERE post_id=:pid ORDER BY id DESC", [':pid'=>$post['id']]);
?>

<hr>
<h5>Komente</h5>
<?php if(!$comments): ?>
  <div class="text-muted">Ende s’ka komente.</div>
<?php else: foreach($comments as $cm): ?>
  <div class="border rounded p-2 mb-2">
    <strong><?= esc($cm['name']) ?></strong>
    <div><?= nl2br(esc($cm['comment'])) ?></div>
    <small class="text-muted"><?= esc($cm['created_at']) ?></small>
  </div>
<?php endforeach; endif; ?>

<hr>
<h5>Lësho një koment</h5>
<form method="post" action="save_comment.php">
  <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
  <div class="mb-3">
    <label class="form-label">Emri</label>
    <input class="form-control" name="name" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Komenti</label>
    <textarea class="form-control" name="comment" rows="4" required></textarea>
  </div>
  <button class="btn btn-primary">Dërgo</button>
</form>
<?php include __DIR__ . '/../footer.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>