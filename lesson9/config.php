<?php
session_start();


$user="root";
$pass="";
$server="localhost";
$dpname="dp";


try {
    $conn = new PDO("mysql:host=$server;dpname=$dpname",$user,$pass);


} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}


?>