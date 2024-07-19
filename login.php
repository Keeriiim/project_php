<?php 
session_start();

include('server/connection.php');

if(isset($_SESSION['logged_in'])){
  header('location: account.php');
  exit;
}

if(isset($_POST['login_btn'])){

  $email = $_POST['email'];
  $password = $_POST['password'];


  $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ?"); // prepare the query 
  $stmt->bind_param("ss", $email, md5($password)); // bind the parameters




  if($stmt->execute()){ // execute the query
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password); // bind the result (email and password
    $stmt->store_result(); // store the result

    if($stmt->num_rows() ==1 ){
      $stmt->fetch(); // fetch the result

      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_email'] = $user_email;
      $_SESSION['user_name'] = $user_name;
      $_SESSION['logged_in'] = true;

      header('location: account.php?login_message=Login successfull');
    }else {
      header('location: login.php?error=Wrong password or Account does not exist');
    }



  }else {
    header('location: login.php?error=Something went wrong');
  }
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

    <!-- Login -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto"> <!-- create a center line under Login -->
        </div>

        <div class="mx-auto container">

            <form id="login-form" method="POST" action="login.php">
                <div class="form-group">
                          <?php if(isset($_GET['error'])){ ?>
                            <div class="alert alert-danger" role="alert">
                              <?php echo $_GET['error']; ?>
                            </div>

                            <?php } ?>
                    <label>Email</label>
                    <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" value="Login" name="login_btn"/>
                </div>
                <div class="form-group">
                    <a href="register.php" id="register-url" class="btn">Don't have account? Click here!</a>
                    </div>
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