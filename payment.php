<?php

session_start();

if(!isset($_SESSION['logged_in'])){ 
    header('location: login.php?error=Please Log in to continue');
}else if(isset($_SESSION['user_id'])){

    if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
        if(count($cart) <= 0){
            header('location: account.php?error=You need items in cart to acces payment');
    }
    
}else if($_POST['order_pay_btn']){
    $order_total_price = $_POST['order_total_price'];
    $order_status =$_POST['order_status'];
    
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

       

    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include('layout/header.php')?>
    

<!-- Account -->
<div class="container mt-5">
        <h2 class="text-center">Session Data</h2>
        <ul class="list-group">
            <?php foreach($_SESSION as $key => $value) { ?>
                <li class="list-group-item"><?php echo ucfirst($key) . ': ' . $value; ?></li>
            <?php } ?>
        </ul>
    </div>



<!-- Payment -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto"> <!-- create a center line under Login -->
    </div>

    <div class="mx-auto container text-center">
        <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
        <input class="btn btn-primary" type="submit" value="Pay Now">
    </div>
</section>



   
    <!-- Footer -->
    <?php include('layout/footer.php')?>


    <!-- Js bundle for Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>
