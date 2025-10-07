<?php
include_once("config.php");

if(isset($_POST['submit'])) {
 
  $title = $_POST['title'];
  $description = $_POST['description'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];

  if(empty($title) || empty($description) || empty($quantity) || empty($price)) 
  {	
    echo "  You  need to fill all fields.";
  } 
  else 
  {
     $sql= "SELECT tittle FROM products WHERE title=:title";
     
     $tempsql = $conn->prepare($sql);
     $tempsql->bindParam(':title', $title);
        $tempsql->execute();

        if($tempsql->rowCount() > 0)
         {
          echo "Tittle exists!";
          header("refresgh:2;url=addProduct.php");
        } 
        else 
        {
          $sql = "INSERT INTO products(title, description, quantity, price) VALUES(:title, :description, :quantity, :price)";
          $insertProduct = $conn->prepare($sql);

          $insertSql->bindParam(':title', $title);
          $insertSql->bindParam(':description', $description);  
            $insertSql->bindParam(':quantity', $quantity);
            $newprice=$price*100;
            $insertSql->bindParam(':price', $newprice);

          $insertSql->execute();
          
          echo "Data saved successfully..."; 
          header("refresh:2;url=productDashboard.php");
        }
    }
}

    