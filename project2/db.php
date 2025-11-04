<?php
$host ='localhost';
$dbname = 'vegzamedia';
$username = 'root';
$password = '';

try{
$pdo = new PDO ("mysql:$host;dbname=$dbname;charset=urf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Lidhja me databazen deshtoi:" .  $e->getMessage());

}
echo "db.php u gjet me sukses!";