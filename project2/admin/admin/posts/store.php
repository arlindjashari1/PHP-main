<?php
require __DIR__ . '/../../helpers.php';
require __DIR__ . '/../../auth.php';
require_login();
require_role(['admin','editor']);

$title = trim($_POST['title'] ?? '');
$slug  = trim($_POST['slug'] ?? '');
$content = $_POST['content'] ?? '';
$image = trim($_POST['image'] ?? '');
$category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
$status = in_array($_POST['status'] ?? 'draft', ['draft','published'], true) ? $_POST['status'] : 'draft';
$user = current_user();

if ($title === '') { redirect('create.php'); }

if ($slug === '') {
  $slug = strtolower(preg_replace('/[^a-z0-9]+/i','-', $title));
}

execStmt($pdo, "INSERT INTO posts (title, slug, content, image, category_id, user_id, status)
VALUES (:title,:slug,:content,:image,:category_id,:user_id,:status)", [
  ':title'=>$title, ':slug'=>$slug, ':content'=>$content, ':image'=>$image,
  ':category_id'=>$category_id, ':user_id'=>$user['id'], ':status'=>$status
]);

redirect('index.php');
