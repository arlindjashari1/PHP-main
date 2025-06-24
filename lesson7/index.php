<?php
$host = 'localhost';
$username = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host", $USER, $pass);
    echo "Connected";
}
 catch(Exception $e) {
    echo "  Not Connection  ;
 }
?>
