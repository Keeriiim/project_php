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
      <?php include('layout/header.php')?>

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
      <?php include('layout/footer.php')?>




<!-- Js bundle for Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>