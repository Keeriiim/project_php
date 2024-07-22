<?php
include 'server/connection.php';
session_start(); // start the session


// check if the user is already logged in
if (isset($_SESSION['logged_in'])) {
  header('location: account.php');
  exit;
}

if (isset($_POST['register'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // if password  match
  if ($password != $confirmPassword) {
    echo "<script>alert('Passwords do not match')</script>";
    header('location: register.php?error=Passwords do not match');
  } else {

    

    // check if the user already exists
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email = ?"); // prepare the query, this will count the number of rows that have the same email
    $stmt1->bind_param("s", $email); // bind the parameters
    $stmt1->execute(); // execute the query
    $stmt1->bind_result($num_rows); // this will store the number of rows that the query returned
    $stmt1->store_result(); // store the result
    $stmt1->fetch(); // fetch the result

    if ($num_rows > 0) {
      header('location: register.php?error=User already exists');
      exit;
    } else {
      // create a new user
      $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?,?,?)"); // prepare the query
      $stmt->bind_param("sss", $name, $email, md5($password)); // bind the parameters and hash the password

      // if account was created successfully
      if ($stmt->execute()) { // execute the query
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        header('location: account.php?register=You registered successfully');
        exit;
      } else { // if account was not created
        header('location: register.php?error=could not create account');
        exit;
      }
    }
  }
}



// check if logged in
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
   

  <!-- Register -->
  <section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
      <h2 class="form-weight-bold">Register</h2>
      <hr class="mx-auto"> <!-- create a center line under Login -->
    </div>

    <div class="mx-auto container">
      <form id="register-form" method="POST" action="register.php">
        <p style="color: red;"> <?php if (isset($_GET['error'])) {
                                  echo $_GET['error'];
                                } ?></p>
        <div class="form-group">
          <label>Username</label>
          <input type="text" class="form-control" id="register-name" name="name" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" id="register-email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <label>Confirm password</label>
          <input type="password" class="form-control" id="confirm-password" name="confirmPassword" placeholder="Password" required>
        </div>
        <div class="form-group">
          <input type="submit" class="btn" id="register-btn" name="register" value="Register" />
        </div>
        <div class="form-group">
          <a href="login.php" id="register-url" class="btn">Already have an account? Click here!</a>

      </form>
    </div>
  </section>



 
    <!-- Footer -->
    <?php include('layout/footer.php')?>




  <!-- Js bundle for Bootstrap-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>