<?php

include ('server/connection.php');
session_start();

$order_details="";
$order_status="";
$order_total_price="";
 //order_details_btn ???
if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){
  $order_id = $_POST['order_id'];
  $order_status = $_POST['order_status'];

  $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
  $stmt->bind_param("i", $order_id);
  $stmt->execute();
  $order_details = $stmt->get_result();

  $order_total_price = subTotalOrder($order_details);

}else{
  header("Location: account.php");
}


function subTotalOrder($order_details){
  $total = 0;
  foreach($order_details as $row){

    $product_price = $row['product_price'];
    $product_quantity = $row['product_quantity'];
    $total = $total + ($product_price * $product_quantity);

  }

  return $total;
  
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<!-- Js bundle can be placed here aswell using "defer" attribute to load it after the page has loaded 
<script defer src....>-->

<!-- Font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
  body{
    height: 100vh;
  }

  .orders{
    min-height: 600px;
  }
    
</style>
</head>
<body>

<!-- Navbar -->
<?php include('layout/header.php')?>
    
  
<div style="height: 150px;"></div>

<!-- Order details -->
<section class="orders container mt-3 pt-1">
      <div class="container mt-1 pt-5">
          <h2 class="font-wight-bold text-center">Order Details</h2>
          <hr class="mx-auto">
      </div>

      <table class="mt-4 pt-4">
          <tr>
              <th>Order id</th>
              <th>Product image</th>
              <th>Product name</th>
              <th>Product Quantity</th>
              <th>Product price</th>
              <th style="padding-right: 60px;">Order Date</th>
              
              
          </tr>
          <?php foreach($order_details as $row){ ?>
            <tr>
            <td>
              <!--<div class="product-info"> -->
              <span><?php echo $row['order_id']; ?></span>
            </td>
            <td>
            <img class="img-fluid w-10 h-20" src="/assets/imgs/<?php echo $row['product_image']?>"/>
             
            </td>
            <td>
              <span><?php echo $row['product_name']?></span>
            </td>
            <td>
              <span><?php echo $row['product_quantity']?></span>
            </td>
            <td>
              <span><?php echo $row['product_price']?></span>
            </td>
            <td >
              <span><?php echo $row['order_date']?></span>
            </td>
            
          </tr>

            <?php } ?>
      </table>

      <?php if($order_status == "pending"){?>
      <form style="float: right;" method="POST" action="payment.php">
        <input type="hidden" name="order_id" value="<?php echo $_POST['order_id']; ?>">
        <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
        <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
        <input class="btn btn-primary" type="submit" name ="order_pay_btn" value="Pay Now">

      </form>
    
     <?php }?>
  

    </section>

 
    
    
  



   
    <!-- Footer -->
    <?php include('layout/footer.php')?>




<!-- Js bundle for Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>