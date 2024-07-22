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
</head>
<body>

    <!-- Navbar -->
     <?php include('layout/header.php')?>


        <!-- Home -->
        <section id="home">
          <div class="container"> <!-- Container to center the content -->
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Prices </span>This Season</h1>
            <p>Eshop offers the best products for the most affordable prices</p>
            <button>Shop Now</button>
          </div>

        </section>

        <!-- Brands-->
        <section id="brand">
          <div class="row">
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand1.png"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand2.png"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand3.png"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand4.png"/>
          </div>
        </section>


        <!-- New -->
        <section id="new" class="w-100"> 
          <div class="row p-0 m-0">
           
            <!-- Watch -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
              <img class="img-fluid" src="assets/imgs/new1.png"/>
              <div class="details">
                <h2>Watches</h2>
                <button class="text-uppercase">Shop Now</button>
              </div>
            </div>

          
            <!-- Shoe -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
              <img class="img-fluid" src="assets/imgs/new2.png"/>
              <div class="details">
                  <h2>Shoes</h2>
                  <button class="text-uppercase">Shop Now</button>
              </div>
            </div>
            

            <!-- Bag -->  
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/new3.png"/>
                <div class="details">
                  <h2>Bags  </h2>
                  <button class="text-uppercase">Shop Now</button>
                </div>
            </div>
          </div>
        </section>

      

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


        <!-- Banner -->
        <section id="banner" class="my-5 py-5">
          <div class="container">
            <h4>Season Sale</h4>
            <h1>Autum Collection <br> Up to 30% OFF</h1>           
            <button class="text-uppercase">shop now</button>
          </div>
        </section>





    <!-- Footer -->
      <!-- Navbar -->
      <?php include('layout/footer.php')?>


    <!-- Js bundle for Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


 <!-- HARDCODED
        <section id="featured" class="my-5 pb5">
          <div class="container text-center mt-5 py-5">
            <h3>FEATURED PRODUCTS</h3>
            <hr>
            <h1>Summer Sale</h1>
            <p>Get the best products for the best prices</p>
          </div>
          <div class="row mx-auto container-fluid">

            
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
              <h4 class="p-price">$199.8</h4>
              <button class="buy-btn">Buy Now</button>
            </div>

           
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
              <img class="img-fluid mb-3" src="/assets/imgs/featured2.png"/>
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

            <div class="product text-center col-lg-3 col-md-4 col-sm-16">
              <img class="img-fluid mb-3" src="/assets/imgs/featured3.png"/>
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

            
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
              <img class="img-fluid mb-3" src="/assets/imgs/featured4.png"/>
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
        </section>

        -->