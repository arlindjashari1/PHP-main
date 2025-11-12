<?php
require_once __DIR__ . '/db.php';

function esc($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

function redirect(string $path) {
  header('Location: ' . $path);
  exit;
}

function fetchAll(PDO $pdo, string $sql, array $params = []) {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  return $stmt->fetchAll();
}

function fetchOne(PDO $pdo, string $sql, array $params = []) {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  return $stmt->fetch();
}

function execStmt(PDO $pdo, string $sql, array $params = []) {
  $stmt = $pdo->prepare($sql);
  return $stmt->execute($params);
}
function ensureUploadDir(): void {
  if (!is_dir(UPLOAD_DIR)) { mkdir(UPLOAD_DIR, 0755, true); }
}

function sanitizeFileName(string $name): string {
  $name = preg_replace('/[^A-Za-z0-9_\.-]+/', '-', $name);
  return mb_substr($name, 0, 120);
}

/** Kthen: ['ok'=>bool,'url'=>string|null,'error'=>string|null] */
function handleImageUpload(array $file, int $maxSizeBytes = 3000000): array {
  if (empty($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    return ['ok'=>false,'url'=>null,'error'=>'NoFile'];
  }
  if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    return ['ok'=>false,'url'=>null,'error'=>'UploadError'];
  }
  if (($file['size'] ?? 0) <= 0 || $file['size'] > $maxSizeBytes) {
    return ['ok'=>false,'url'=>null,'error'=>'Size'];
  }

  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime  = $finfo->file($file['tmp_name']);
  $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
  if (!isset($allowed[$mime])) { return ['ok'=>false,'url'=>null,'error'=>'Type']; }

  ensureUploadDir();
  $ext = $allowed[$mime];
  $base = pathinfo(sanitizeFileName($file['name'] ?? 'image'), PATHINFO_FILENAME);
  $name = $base . '-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;

  $dest = rtrim(UPLOAD_DIR,'/\\') . DIRECTORY_SEPARATOR . $name;
  if (!move_uploaded_file($file['tmp_name'], $dest)) {
    return ['ok'=>false,'url'=>null,'error'=>'Move'];
  }
  return ['ok'=>true,'url'=>rtrim(UPLOAD_URL,'/').'/'.$name,'error'=>null];
}

/** Fshin skedarin lokal nëse është nga uploads/ (përdoret kur zëvendëson ose fshin postime) */
function safeUnlinkUploaded(?string $imageUrl): void {
  if (!$imageUrl) return;
  $prefix = rtrim(UPLOAD_URL,'/');
  if (strpos($imageUrl, $prefix) !== 0) return; // jo i yni
  $file = substr($imageUrl, strlen($prefix)+1);
  $full = rtrim(UPLOAD_DIR,'/\\') . DIRECTORY_SEPARATOR . $file;
  if (is_file($full) && strpos(realpath($full), realpath(UPLOAD_DIR)) === 0) { @unlink($full); }
}
