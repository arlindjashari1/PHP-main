<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }

function is_logged_in(): bool { return isset($_SESSION['user']); }
function current_user(): ?array { return $_SESSION['user'] ?? null; }

function require_login(): void {
  if (!is_logged_in()) { header('Location: /php_mysql_media_starter/login.php'); exit; }
}

function login(array $user): void {
  $_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'] ?? 'author'
  ];
}

function logout(): void {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
  }
  session_destroy();
}

function require_role(array $roles): void {
  $u = current_user();
  if (!$u || !in_array($u['role'], $roles, true)) {
    http_response_code(403);
    echo '<div class="container"><div class="alert alert-danger mt-3">Nuk keni të drejta.</div></div>';
    exit;
  }
}