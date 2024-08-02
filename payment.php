<?php

session_start();
$order_total_price ="";
$order_status ="";
$order_id ="";

if(!isset($_SESSION['logged_in'])){ 
    header('location: login.php?error=Please Log in to continue');
}else if(isset($_SESSION['user_id'])){
    $amount = 0;
    
    if(isset($_POST['order_status']) && $_POST['order_status'] == 'pending'){
        $amount = $_POST['order_total_price'];
        $order_id = $_POST['order_id'];
    }else if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];

        if(count($cart) <= 0){
            header('location: account.php?error=You need items in cart to access payment');
        }else{

            if(isset($_SESSION['total']) && $_SESSION['total'] != 0 ){
                $amount = $_SESSION['total'];
                $order_id = $_SESSION['order_id'];
            } 
        }

    }

    $paypal_amount = strval($amount);
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
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

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
    




<!-- Payment -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto"> <!-- create a center line under Login -->
    </div>

    <div class="mx-auto container text-center" style="display: flex; flex-direction: column; min-height: 400px;">    
    <p style="display: block;">Total payment: $<?php echo $amount ?></p>
        <!--input class="btn btn-primary" type="submit" value="Pay Now"-->

        <!-- PayPal button -->
        <div id="paypal-button-container"></div>
        <p id="result-message"></p>

        
    </div>
    

    
</section>


   
    <!-- Footer -->
    <?php include('layout/footer.php')?>


    <!-- Js bundle for Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    

    <!-- Replace the "test" client-id value with your client-id -->
    <script src="https://www.paypal.com/sdk/js?client-id=AVXrxIMRHebZ4htTzfEo0F2tQiGNUc0ursY1uYp01fKTIgBqPKJbejdV5fRKzGKIP1bGyj5jhsY6LZBK&components=buttons&enable-funding=paylater,venmo,card" data-sdk-integration-source="integrationbuilder_sc"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $paypal_amount; ?>'
                        }
                    }]
                });
            },
    
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                
                var transaction = orderData.purchase_units[0].payments.captures[0];
                var trans = String(transaction.id);
                var order_1 = '<?php echo $order_id; ?>';
                //alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                window.location.href = 'server/complete_payment.php?transaction_id=' + trans + '&order_id='+order_1;
    
                //when rdy to go live, remove the alert and replace with redirect to success page
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            });
        }
        }).render('#paypal-button-container');
    
      </script>

</body>

</html>

<?php /* TEST kod

<section class="my-5 py-5">
<div class="container mt-5 pt-5">
        <h2 class="text-center">Session Data</h2>
        <ul class="list-group">
            <?php 
            foreach($_SESSION as $key => $value) { ?>
                <li class="list-group-item"><?php echo ucfirst($key) . ': ' . $value; ?></li> 
                
            <?php } ?>
        </ul>
        <h2 class="text-center">order_details</h2>
        <ul class="list-group">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
             // Retrieve data from the POST request
                 $orderTotalPrice = isset($_POST['order_total_price']) ? $_POST['order_total_price'] : 'No order total price set';
                 $orderStatus = isset($_POST['order_status']) ? $_POST['order_status'] : 'No order status set';
                 $orderPayBtn = isset($_POST['order_pay_btn']) ? $_POST['order_pay_btn'] : 'Pay Now button not clicked';
                ?>
                 
            <h3><?php echo "<h2>Order Details</h2>"; ?> </h3>
            <h3>Order Total Price: <?php echo htmlspecialchars($orderTotalPrice); ?> </h3>
            <h3>Order Status:<?php $orderStatus ?> </h3>
            
    
            <?php } else { ?>
            <h1><?php echo "No data received.";?> </h1>
            <?php } ?>
        </ul>
    </div>
</section>

*/
?>