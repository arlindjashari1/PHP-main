<?php
$host = "localhost";
$dbname = "news.db";  
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Gabim në lidhje: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}