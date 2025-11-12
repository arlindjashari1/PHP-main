<?php
$host = '127.0.0.1';
$port = 3306;
$db   = 'vegzamedia';
$user = 'root';
$pass = '';

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $user, $pass, [
    define('UPLOAD',  '/uploads');                 // rrugë në disk
define('UPLOAD_URL', '/php_mysql_media_starter/uploads');   // URL në faqe

    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ]);
} catch (PDOException $e) {
  exit('Lidhja me DB dështoi: ' . $e->getMessage());
}
