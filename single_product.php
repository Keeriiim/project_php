<?php 

include('server/connection.php'); /* Include the connection file */

if(isset($_GET['id'])){ /* If the product_id is set in the URL */

  $product_id=$_GET['id']; /* Get the product_id from the URL */

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? LIMIT 1"); /* This will  */
  $stmt->bind_param("i", $product_id); /* Bind the product_id to the statement */

  $stmt->execute(); /* Execute the statement */

  $product = $stmt->get_result(); /* Get the result */
    
}
else {
    
    header("Location: index.php"); 
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
                    <a class="nav-link active" aria-current="page" href="shop.html">Shop</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="login.html">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.html">Contact us</a>
                </li>


                <li class="nav-item">
                  <a href="cart.php"><i class="fas fa-cart-shopping"></i></a>
                  <a href="account.html"><i class="fas fa-user"></i></a>
                </li>

            </ul>
          </div>
        </div>
      </nav>

      
     

      <!-- Product -->
    <section class="container single-prod my-5 pt-5">
        <div class="row mt-5">
          
          <?php 
              while($row = $product->fetch_assoc()){ /* Fetch the product from the database */
          ?> 

          

            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>" id="mainImg"/>
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img">
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img">
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img">
                    </div>
                    <div class="small-img-col">
                      <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img">
                    </div>
                </div>
            </div>

           
        


            <div class="col-lg-6 col-md-12 col-12">
                <h6>Men/Shoes</h6>
                <h3 class="py-4"><?php echo $row["product_name"]?></h3>
                <h2>$<?php echo $row["product_price"]?></h2>

                <form action="cart.php" method="POST"> <!-- This form will be used to add the product to the cart -->
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/> <!-- This will be used to get the product_id when the form is submitted -->
                  <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"> <!-- This will be used to get the product_image when the form is submitted -->
                  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"> <!-- This will be used to get the product_name when the form is submitted -->
                  <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"> <!-- This will be used to get the product_price when the form is submitted -->
                  <input type="number" name ="product_quantity" value="1"/>  <!-- This will be used to get the product_quantity when the form is submitted -->
                  <button class="buy-btn" type="submit" name="add_to_cart">Add to cart</button>
                  
                </form>  
                
                <h4 class="mt-5 mb-5">Product details</h4>
                <span><?php echo $row["product_description"]?></span>
            </div> 
          
        </div>
    </section>

    <?php } ?>



   <!--
     Related Products 
    <section id="related-prod" class="my-5 pb5">
      <div class="container  mt-5 py-5">
        <h3>Related Products</h3>
        <hr class="mx-auto">
        <hr>
      </div>
      <div class="row mx-auto container-fluid">
         Product 1
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="/assets/imgs/featured1.png"/>
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name">Sports Shoes</h5>
          <h4 class="p-price">$</h4>
          <button class="buy-btn">Buy Now</button>
        </div>

      </div>


    </section>
              -->


              <section id="featured" class="my-5 pb5">
          <div class="container text-center mt-5 py-5">
            <h3>FEATURED PRODUCTS</h3>
            <hr>
            <h1>Summer Sale</h1>
            <p>Get the best products for the best prices</p>
          </div>
          <div class="row mx-auto container-fluid">

            <?php include('server/get_featured_prod.php')?>

            <?php while($row = $featured_prod_result->fetch_assoc()){ ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <a href="single_product.php?id=<?php echo $row['product_id']; ?>"><img class="img-fluid mb-3" src="/assets/imgs/<?php echo $row['product_image']; ?>"/></a>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
              <h4 class="p-price">$ <?php echo $row['product_price']; ?></h4>
              <a href="single_product.php?id=<?php echo $row['product_id']; ?>"> <button class="buy-btn">Buy Now</button></a>
              
            </div>

            <?php } ?>

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
            <h5 class="pb-2" id="contactUs">Contact Us</h5>
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

<script>
  var mainImg = document.getElementById('mainImg');
  var smallImgs = document.getElementsByClassName('small-img');

  /* Testing
  smallImgs[0].onclick = function() {
    mainImg.src = smallImgs[0].src;
  }
  */

  for(let i=0; i<4; i++) {
      smallImgs[i].onclick = function() 
      /* This is an event listener that will change the main image when a small image is clicked */
      {
      mainImg.src = smallImgs[i].src; /* This will change the main image to the small image that was clicked */
    }
  }
  
  
</script>

</body>
</html>