<?php require_once __DIR__.'/../functions/auth.php'; $u = current_user(); ?>
<!doctype html>
<html lang="sq">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vegza Media - Starter</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    .container { max-width: 980px; }
    .slide-card { border: 1px dashed #ccc; padding: 8px; border-radius: 8px; margin-bottom: 10px; }
    .post-card { border: 1px solid #eee; padding: 12px; border-radius: 10px; margin-bottom: 12px; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light mb-3">
  <div class="container">
    <a class="navbar-brand" href="/php_mysql_media_starter/index.php">Vegza Media</a>
    <div class="navbar-nav">
      <a class="nav-link" href="/php_mysql_media_starter/index.php">Kreu</a>
      <a class="nav-link" href="/php_mysql_media_starter/admin/dashboard.php">Dashboard</a>
    </div>
    <div class="ms-auto navbar-nav">
      <?php if($u): ?>
        <span class="nav-link">👤 <?= esc($u['name']) ?> (<?= esc($u['role']) ?>)</span>
        <a class="nav-link" href="/php_mysql_media_starter/logout.php">Dil</a>
      <?php else: ?>
        <a class="nav-link" href="/php_mysql_media_starter/login.php">Hyr</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">