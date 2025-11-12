<?php
require __DIR__ . '/../../helpers.php';
require __DIR__ . '/../../auth.php';
require_login();
require_role(['admin']); // Fshirja vetëm për admin

$id = (int)($_GET['id'] ?? 0);
if ($id>0) {
  execStmt($pdo, "DELETE FROM posts WHERE id = :id", [':id'=>$id]);
}
redirect('index.php');
$row = fetchOne($pdo, "SELECT image FROM posts WHERE id=:id", [':id'=>$id]);
if ($row && !empty($row['image'])) { safeUnlinkUploaded($row['image']); }
execStmt($pdo, "DELETE FROM posts WHERE id=:id", [':id'=>$id]);
