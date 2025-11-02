<?php
// config/db.php
// Ndrysho DB_NAME, DB_USER, DB_PASS sipas nevojës (XAMPP default: root / bosh).
const DB_HOST = 'localhost';
const DB_NAME = 'vegzamedia';
const DB_USER = 'root';
const DB_PASS = '';

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
  die('DB connection failed: ' . $e->getMessage());
}