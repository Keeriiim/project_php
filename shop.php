<?php
include('server/connection.php');

$products="";

if(isset($_POST['search'])){

$category = $_POST['category'];
$price = $_POST['price'];


  $stmt = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_price <= ?");
  $stmt->bind_param("si", $category, $price);
  $stmt->execute();
  $products = $stmt->get_result();




}
else{

$stms = $conn->prepare("SELECT * FROM products");
$stms->execute();

$products = $stms->get_result();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <style>
        .product img{
            width: 30%;
            height: auto;
            object-fit: border-box;
        }

        #search{
          position: fixed;
          top: -50px;
          left: 0;
          float:left;
         
        }

        body {
            padding-top: 130px; /* Adjust this value based on your navbar height */
        }

        .content{
          min-height: 800px;
        }

        .sbar{
          background-color: #f8f9fa;
          
        }
        
    </style>

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



  

      <section id="search" class="my-5 ms-5 py-5 content sbar">
          <div class="container mt-5 py-5">
            <p>Search Products</p>
          </div>

          <form action="shop.php" method="POST">
          <div class="row mx-auto container">
            <div class="col-lg-12 col-md-12 col-sm-12">

            <p>Category</p>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" value="shoes" id="category_one" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                  Shoes
                </label>
              </div>


              
              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" value="coats" id="category_two">
                <label class="form-check-label" for="flexRadioDefault2">
                  Coats
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" value="watches" id="category_three">
                <label class="form-check-label" for="flexRadioDefault3">
                  Watches
                </label>
              </div>


            </div>
          </div>

          <div class="row mx-auto container mt-5">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <p>Price</p>
              <input type="range" class="form-range w-150" name="price" value="100" min="1" max="1000" id="customRange1">
              <div class="w-50">
                <span style="float: left;">1</span>
                <span style="float: right;">1000</span>
              </div>  
            </div>
          </div>

          <div class="form-group my-3 mx-3">
            <input type="submit" name="search" value="Search" class="btn btn-primary">
          </div>
        </form>

          </section>

    <!-- Featured -->
    <section id="shop" class="my-5 pb-5 content">
          <div class="container mt-1 py-1">
            <h3>Our Products</h3>
            <hr>
            
          </div>
          <div class="row mx-auto container">

            <?php while($row = $products->fetch_assoc()){ ?>
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
              <a class="btn buy-btn" href="single_product.php?id=<?php echo $row['product_id']; ?>">Buy Now</a>
              
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
</body>
</html>

<!-- Featured 
    <section id="featured" class="my-5 pb5">
    
        <div class="container  mt-5 py-5">
          <h3>FEATURED PRODUCTS</h3>
          <hr>
          <h1>Summer Sale</h1>
          <p>Get the best products for the best prices</p>
        </div>
        <div class="row mx-auto container-fluid">
          
        repeat x4 

          <div onclick="window.location.href='single_product.php';" class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="/assets/imgs/featured1.png"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">Sports Shoes</h5>
            <h4 class="p-price">$199.8</h4>
            <button class="buy-btn">Buy Now</button>
          </div>
        </div>
      </section> -->


      <!-- Featured -->