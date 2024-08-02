<?php 

session_start(); // start the session

include 'connection.php';
//if(isset($_GET['place_order'])){
  //  echo 'place order';  }


if(!isset($_SESSION['logged_in'])) {
    header('location: ../checkout.php?message=Please login first');
    exit; // Either use exit or place the code below in else!
}


if(isset($_POST['place_order'])) {

    // get user info
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city']; 
    $address = $_POST['adress'];     


    echo "$name + <br>";
    echo $email;
    echo $phone;
    echo $city;
    echo $address;

    $order_cost = $_SESSION['total'];
    $order_status = 'pending';
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)  VALUES (?, ?, ?, ?, ?, ?, ?); "); // prepare the query


    // email is omitted cuz we forgot to add it to DB
    $stmt->bind_param("isiisss", $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date); // bind the parameters

    $stmt_status = $stmt->execute(); // execute the query
    if(!$stmt_status){
        header('location: ../index.php');
        exit;
    }

    $order_id= $stmt->insert_id; // 2. get the id of the last inserted record
   

   

    //3.get products from cart (session)

    $cart = $_SESSION['cart'];
    foreach($_SESSION['cart'] as $key => $value) {
        $product = $_SESSION['cart'][$key]; // get the product from the cart as an array
        $product_id = $product['product_id']; // get the product id
        $product_name = $product['product_name']; // get the name
        $product_image = $product['product_image']; // get the image
        $product_price = $product['product_price']; // get the price
        $product_quantity = $product['product_quantity']; // get the quantity

        //4. store each single item in _order_items
        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?); "); // prepare the query
        $stmt1->bind_param("iissiiis", $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date); // bind the parameters
        $stmt1->execute(); // execute the query
    }
    

    // 5. remove all from cart
    $_SESSION['order_id'] = $order_id;

    // 6. inform user wether everything went well or not
    header('location: ../payment.php?order_status=Placed');

    
}

else {
 
echo "error";
}

?>