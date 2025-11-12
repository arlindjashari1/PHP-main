<?php
require_once __DIR__ . '/auth.php';
$u = current_user();
?>
<!doctype html>
<html lang="sq">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vegza Media</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>.container{max-width:1000px}.nav-link.active{font-weight:700;color:#0d6efd!important}</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-3">
  <div class="container">
    <a class="navbar-brand" href="/php_mysql_media_starter/index.php">🌐 Vegza Media</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link<?= basename($_SERVER['PHP_SELF'])==='index.php'?' active':'' ?>" href="/php_mysql_media_starter/index.php">Kreu</a>
        </li>
        <?php if($u): ?>
          <li class="nav-item"><a class="nav-link" href="/php_mysql_media_starter/admin/posts/index.php">Postimet</a></li>
          <?php if($u['role']==='admin' || $u['role']==='editor'): ?>
            <li class="nav-item"><a class="nav-link" href="/php_mysql_media_starter/admin/posts/create.php">Shto postim</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if($u): ?>
          <li class="nav-item"><span class="nav-link">👤 <?= esc($u['name']) ?> (<?= esc($u['role']) ?>)</span></li>
          <li class="nav-item"><a class="nav-link text-danger" href="/php_mysql_media_starter/logout.php">Dil</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link text-primary" href="/php_mysql_media_starter/login.php">Hyr</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
