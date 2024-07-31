<?php 

session_start();

if (!empty($_SESSION['cart'])) {  /* if cart is not empty and checkout button is pressed */
   
} else {
    header('Location: home.php');
    
    
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
    


    <!-- Checkout -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Checkout</h2>
            <hr class="mx-auto"> <!-- create a center line under Login -->
        </div>

        <div class="mx-auto container">
            <form id="checkout-form" method="POST" action="server/place_order.php">
                <p class="text-center" style="color:red;">
                    <?php 
                        if(isset($_GET['message'])) {
                            echo $_GET['message'];
                        }
                    ?></p>
                <div class="form-group checkout-small-element">
                    <label>Username</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Enter your username" value="test" required>
                </div>
                <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Enter your email" value="test@gmail.com"required>
                </div>
                <div class="form-group checkout-small-element">
                    <label>Phone</label>
                    <input type="number" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" value="123456789"required>
                </div>
                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" value="test" required>
                </div>
                <div class="form-group checkout-large-element">
                    <label>Adress</label>
                    <input type="text" class="form-control" id="checkout-adress" name="adress" placeholder="Adress" value="test" required>
                </div>
                <div class="form-group checkout-btn-container">
                    <p>Total amount: $ <?php echo $_SESSION['total']; ?></p>
                    <input type="submit" class="btn" id="checkout-btn" value="Checkout" name="place_order" />
                </div>
            </form>
        </div>
    </section>

   

   
    <!-- Footer -->
    <?php include('layout/footer.php')?>




<!-- Js bundle for Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>