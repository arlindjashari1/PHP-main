<?php
require_once __DIR__ . '/db.php';  

function esc($str) {
  return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
  header('Location: ' . $path);
  exit;
}

function fetchAll($pdo, $sql, $params = []) {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  return $stmt->fetchAll(); 
}

function fetchOne($pdo, $sql, $params = []) {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  return $stmt->fetch();
}

function execStmt($pdo, $sql, $params = []) {
  $stmt = $pdo->prepare($sql);
  return $stmt->execute($params);
}
