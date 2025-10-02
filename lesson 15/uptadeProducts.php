<?php

include_once('config.php');

if(isset($_POST['update']))
{
	$id = $_POST['id'];
	$tittle = $_POST['username'];
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];

	$sql = "UPDATE users SET tittle=:tittle, decription=:decription, quantity=:quantity, price=:price WHERE id=:id";
	$prep = $conn->prepare($sql);
	$prep->bindParam(':id', $id);
	$prep->bindParam(':tittle', $tittle);
	$prep->bindParam(':decription', $description);
	$prep->bindParam(':quantity', $quantity);
	$prep->bindParam(':price', $price);

	$prep->execute();

	header("Location:dashboard.php");
}


?>
