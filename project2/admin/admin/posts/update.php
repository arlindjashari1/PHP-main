<?php
require __DIR__ . '/../../helpers.php';
require __DIR__ . '/../../auth.php';
require_login();
require_role(['admin','editor']);

$id = (int)($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$slug  = trim($_POST['slug'] ?? '');
$content = $_POST['content'] ?? '';
$image = trim($_POST['image'] ?? '');
$category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
$status = in_array($_POST['status'] ?? 'draft', ['draft','published'], true) ? $_POST['status'] : 'draft';
$old = fetchOne($pdo, "SELECT image FROM posts WHERE id=:id", [':id'=>$id]);
$imageUrl = $old['image'] ?? null;

$up = handleImageUpload($_FILES['image_file'] ?? []);
if ($up['ok']) {
  safeUnlinkUploaded($imageUrl);
  $imageUrl = $up['url'];
}

execStmt($pdo, "UPDATE posts SET title=:title, slug=:slug, content=:content, image=:image,
  category_id=:category_id, status=:status WHERE id=:id", [
  ':title'=>$title, ':slug'=>$slug, ':content'=>$content, ':image'=>$imageUrl,
  ':category_id'=>$category_id, ':status'=>$status, ':id'=>$id
]);

if ($id<=0 || $title===''){ redirect('index.php'); }
if ($slug===''){ $slug = strtolower(preg_replace('/[^a-z0-9]+/i','-', $title)); }

execStmt($pdo, "UPDATE posts SET title=:title, slug=:slug, content=:content, image=:image,
  category_id=:category_id, status=:status WHERE id=:id", [
  ':title'=>$title, ':slug'=>$slug, ':content'=>$content, ':image'=>$image,
  ':category_id'=>$category_id, ':status'=>$status, ':id'=>$id
]);

redirect('index.php');
