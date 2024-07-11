<?php 

session_start(); // start the session

include 'connection.php';
//if(isset($_GET['place_order'])){
  //  echo 'place order';  }


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
    $user_id = '1';
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)  VALUES (?, ?, ?, ?, ?, ?, ?); "); // prepare the query


    // email is omitted cuz we forgot to add it to DB
    $stmt->bind_param("isiisss", $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date); // bind the parameters

    $stmt->execute(); // execute the query

    $order_id= $stmt->insert_id; // get the id of the last inserted record
   

   

    //get products from cart (session)

    $cart = $_SESSION['cart'];
    foreach($_SESSION['cart'] as $key => $value) {
        $product = $_SESSION['cart'][$key]; // get the product from the cart as an array
        $product_id = $product['product_id']; // get the product id
        $product_name = $product['product_name']; // get the name
        $product_image = $product['product_image']; // get the image
        $product_price = $product['product_price']; // get the price
        $product_quantity = $product['product_quantity']; // get the quantity

        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?); "); // prepare the query
        $stmt1->bind_param("iissiiis", $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date); // bind the parameters
        $stmt1->execute(); // execute the query
    }

    //store order info in db

    //store each single item in _order_itmes

    // remove from cart

    // inform user wether everything went well or not
}

else {
 
echo "error";
}

?>