<?php

include ('server/connection.php');
session_start();

if(!isset($_SESSION['logged_in'])){
  header('location: login.php');
  exit; // exit is important for the script to stop running,  if the user is not logged in and the script continues to run, the user will be able to see the account page which is not what we want
}

if(isset($_GET['logout'])){

  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    
    
    // session_destroy(); // destroy the session meaning all variables including cart etc
    header('location: login.php');
    exit;
  }

}



if(isset($_POST['change_password'])){

  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  if($password != $confirmPassword){
    header('location: account.php?error=Missmatching passwords');

  }else{
    $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
    $stmt->bind_param("ss", md5($password), $_SESSION['user_email']);

    if($stmt->execute()){
      header('location: account.php?message=Password changed successfully');
    }else {
      header('location: account.php?error=Could not update password');
    } 
  }

}

$orders = "";
//get orders
if(isset($_SESSION['logged_in'])){
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
  $stmt->bind_param("i", $_SESSION['user_id']);
  $stmt->execute();
  $orders = $stmt->get_result();

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
    <section class="my-5 py-5">
    <div class="row container mx-auto">
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
        <p style="color:#32de84;"><?php if(isset($_GET['login_message'])){ 
              echo $_GET['login_message']; }?></p>
        <p style="color:#32de84;"><?php if(isset($_GET['register'])){ 
              echo $_GET['register']; }?></p>

            <h3 class="font-weight-bold">Account info</h3>
            <hr class="mx-auto">                        
            <div class="account-info">

                <p>Name: <span><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}    ?></span></p>
                <p>Email: <span><?php if(isset($_SESSION['user_email'])){echo $_SESSION['user_email'];}    ?></span></p>


                <p><a href="#" id="order-btn">Your orders</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a> </p>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <form id="account-form" action="account.php" method="POST">
                <h3>Change Password</h3>
                <hr class="mx-auto">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Change Password" class="btn" id="change-pass-btn" name="change_password">
                </div>
            </form>
        </div>
        <?php if(isset($_GET['error'])){ ?>
                            <div class="alert alert-danger" role="alert" style="text-align: center;">
                              <?php echo $_GET['error']; ?>
                            </div>

                            <?php } ?>
                            <?php if(isset($_GET['message'])){ ?>
                            <div class="alert alert-danger" role="alert" style="text-align: center; background-color:#32de84;">
                              <?php echo $_GET['message']; ?>
                            </div>

                            <?php } ?>
                            
                            
    
    </section>

  
    <!-- Orders -->
    <section class="orders container my-5 py-3">
      <div class="container mt-2">
          <h2 class="font-wight-bold text-center">Order History</h2>
          <hr class="mx-auto">
      </div>

      <table class="mt-5 pt-5">
          <tr>
              <th>Order id</th>
              <th>Order cost</th>
              <th>Order status</th>
              <th>Order date</th>
              <th>Order details</th>
              
          </tr>
          <?php while($row = $orders->fetch_assoc()){ ?>
            <tr>
            <td>
              <!--<div class="product-info"> -->
                  <span><?php echo $row['order_id']; ?></span>
      
            </td>
            <td>
              <span><?php echo $row['order_cost']?></span>
            </td>
            <td>
              <span><?php echo $row['order_status']?></span>
            </td>
            <td>
              <span><?php echo $row['order_date']?></span>
            </td>
            <td style="padding-right: 50px;">
              <form action="order_details.php" method="POST">
              <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                <input type="submit" value="Details" class="order-details-btn" name="order_details_btn">
              </form>
            </td>
          </tr>

            <?php } ?>
      </table>

    </section>

   

    <!-- Footer -->
    <?php include('layout/footer.php')?>




<!-- Js bundle for Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>