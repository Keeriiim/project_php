<?php

session_start(); /* Starts the session, meaning that the session is active and can store data, the session  will be usable for all pages that are included in the session */

if(isset($_POST['add_to_cart'])){ /* this will check if the user clicked the add to cart button */
 // echo "<script>alert('You pressed the button')</script>";
  
  

  if(isset($_POST['cart'])){ /* if the product is already in the cart */
    echo "<script>alert('This item is now in the cart')</script>";
    $product_arrays_ids = array_column($_SESSION['cart'], 'product_id'); /* returns all product id from the session */
    
    if(!in_array($_POST['product_id'],$products_array_ids)){ /* if the product is not in the cart, add it */
      

      $product_array = array(
        'product_id' => $_POST['product_id'],
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_image' => $_POST['product_image'],
        'product_quantity' => $_POST['product_quantity']);

      $_SESSION['cart']['product_id'] = $product_array; /* store the array in the session */

      // Product has alreadybeen added to the cart
    }else{
      echo "<script>alert('Product is already added to the cart')</script>";

    }
  }
  else{ /* if this is the first product getting added */
      
      

      $product_id = $_POST['product_id'];
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_POST['product_image'];
      $product_quantity = $_POST['product_quantity'];

      $product_array = array('product_id' => $product_id, 'product_name' => $product_name, 'product_price' => $product_price, 'product_image' => $product_image, 'product_quantity' => $product_quantity);

      $_SESSION['cart'][$product_id] = $product_array; /* store the array in the session */
      
    }

    subTotal(); /* call the subTotal function */
    

  
}
else if(isset($_POST['remove_product'])){ /* if the user clicked the remove button */
  $product_id = $_POST['product_id'];     /* get the product id */
  unset($_SESSION['cart'][$product_id]);  /* remove the product from the cart */

  subTotal(); /* call the subTotal function */

}


else if(isset($_POST['edit_quantity'])){ /* if the user clicked the edit button */
  $product_id = $_POST['product_id']; /* get the product id */
  $product_quantity = $_POST['product_quantity']; /* get the new quantity */

  $product_array= $_SESSION['cart'][$product_id]; /* get the product array, meaning the product that the user wants to edit which is stored in the session */
  $product_array['product_quantity'] = $product_quantity; /* update the quantit */

  $_SESSION['cart'][$product_id] = $product_array; /* store the updated array in the session */

  subTotal(); /* call the subTotal function */

}
else{ /* if u go directly to the cart page via ex icon */
   // echo "<script>alert('no product is in the cart')</script>";
   // echo "<script>window.location = 'home.php'</script>";
  }


  
  function subTotal(){
    $total = 0;
    foreach($_SESSION['cart'] as $key => $value){ /* loop through the cart, by getting the key and value */
      /* $total = $total + ($value['product_quantity'] * $value['product_price']);       better code */

      $product = $_SESSION['cart'][$key]; /* get the product */
      $price = $product['product_price']; /* get the price */
      $quantity = $product['product_quantity']; /* get the quantity */

      $total = $total + ($price * $quantity); /* calculate the total */
    }
    $_SESSION['total'] = $total; /* store the total in the session */
    
  }

?>














<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <!-- Js bundle can be placed here aswell using "defer" attribute to load it after the page has loaded 
    <script defer src....>-->

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary py-3 fixed-top"> <!-- py is padding top/bot, fixed to fix the nav -->
        <div class="container">
          <img class="logo" src="assets/imgs/sitelogo.png"/>
          <h2 class="brand">E-Shop</h2>

        
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navbar links, added nav-buttons to custom the whole div -->
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                <!-- Nav items -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="shop.php">Shop</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.html">Contact us</a>
                </li>


                <li class="nav-item">
                  <a href="cart.php"><i class="fas fa-cart-shopping"></i></a>
                  <a href="account.php"><i class="fas fa-user"></i></a>
                </li>

            </ul>
          </div>
        </div>
      </nav>


      <!-- Cart 
      <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-wight-bold">Your cart</h2>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/featured1.png"/>
                        <div>
                            <p>Black Mamba Shoes</p>
                            <small><span>$</span>155</small>
                            <br>
                            <a class="remove-btn" href="#">Remove</a>
      
                        </div>
                    </div>
                </td>
                
                <td>
                    <input type="number" value="1" min="1" max="10"/>
                    <a class="edit-btn" href="#">Edit</a>
                </td>
                <td>
                    <span>$</span>
                    <span class="product-price">155</span>
                </td>
            </tr>
        </table>
        -->

        <!-- Cart -->
        <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-wight-bold">Your cart</h2>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>

            <?php foreach($_SESSION['cart'] as $key => $value){ ?>

              <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/<?php echo $value['product_image']; ?>"/>
                        <div>
                            <p><?php echo $value['product_name'] ?></p>
                            <small><span>$</span> <?php echo $value['product_price']; ?> </small>
                            <br>


                            <form method="POST" action="cart.php">
                              <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                              <input type="hidden" name="product_name" value="<?php echo $value['product_name']; ?>"/>
                              <input type="hidden" name="product_price" value="<?php echo $value['product_price']; ?>"/>
                              <input type="hidden" name="product_image" value="<?php echo $value['product_image']; ?>"/>
                              <input type="submit" name="remove_product" value="remove" class="remove-btn"/>                        
                            </form>
                            
      
                        </div>
                    </div>
                </td>
                
                <td>
                    
                    <form method="POST" action="cart.php">
                      <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                      <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" /> 
                      <input type="submit" name="edit_quantity" value="edit" class="edit-btn"/>
                    </form>
                    
                </td>
                <td>
                    <span>$</span>
                    <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price'] ?></span>
                </td>
            </tr>

            <?php } ?>
            
        </table>


        <!-- Total -->
        <div class="cart-total">  
          <table>
            <tr>
              <td>Total</td>
              <td>$ <?php echo $_SESSION['total'] ?></td>
          </table>
        </div>

        

        <!-- Checkout -->
        <div class="checkout-container">
          <form method="POST" action="checkout.php">
            <input type="hidden" name="total" value="<?php echo $_SESSION['total'] ?>"/>
            <input type="submit" class="checkout-btn" name="checkout" value="Checkout"/>
            
          </form>
          
        </div>

      </section>



      <!-- Footer -->
      <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <img class="logo logo-b" src="/assets/imgs/sitelogo.png"/>
            <p class="pt-3">Our store is the best place to get the best products for the best prices</p>
          </div>

          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-3">Featured</h5>
            <ul class="text-uppercase">
              <li><a href="#">men</a></li>
              <li><a href="#">boys</a></li>
              <li><a href="#">shoes</a></li>
              <li><a href="#">bags</a></li>
              <li><a href="#">watches</a></li>
            </ul>
          </div>

          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2" id="contactUs" >Contact Us</h5>
            <div>
              <h6 class="text-uppercase">Adress</h6>
              <p>1234 Street Name</p>
            </div>
            <div>
              <h6 class="text-uppercase">Phones</h6>
              <p>123-123-123-123</p>
            </div>
            <div>
              <h6 class="text-uppercase">Email</h6>
              <p>example_info@gmail.com</p>
            </div>
          </div>


          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Instagram</h5>
            <div class="row">
              <img class="img-fluid w-25 h-100 m-2" src="/assets/imgs/featured1.png"/>
              <img class="img-fluid w-25 h-100 m-2" src="/assets/imgs/featured2.png"/>
              <img class="img-fluid w-25 h-100 m-2" src="/assets/imgs/featured3.png"/>
              <img class="img-fluid w-25 h-100 m-2" src="/assets/imgs/featured4.png"/>
            </div>
          </div>
        </div>

        <div class="copyright mt-5">
          <div class="row container mx-auto">
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <img src="assets/imgs/payment.png">
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4 text-nowrap mb-2">
              <p>© 2021 Eshop. All rights reserved</p>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
              <a href="#"><i class="fab fa-facebook"></i> </a> 
              <a href="#"><i class="fab fa-instagram"></i> </a>
              <a href="#"><i class="fab fa-twitter"></i> </a>
            </div>
          </div>
        </div>

      </footer>




    <!-- Js bundle for Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>