<?php
require_once __DIR__ . '/auth.php';
require_admin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$st = $pdo->prepare("UPDATE articles SET approved=1 WHERE id=?");
$st->execute([$id]);
header("Location: index.php"); exit;