<?php
include 'connection.php';
session_start();

if(isset($_GET['transaction_id']) && isset($_GET['order_id']) ){
    $transaction_id = $_GET['transaction_id'];
    $order_id = $_GET['order_id'];
    $user_id = $_SESSION['user_id'];

    //change order_status to paid
    $order_status = 'paid';

    //Update order status in DB
    $stmt = $conn ->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param('si', $order_status, $order_id);
    $stmt->execute();


    //Update successful payment in DB
    
    $stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, transaction_id) VALUES (?, ?, ?)"); // prepare the query
    $stmt1->bind_param("iii", $order_id, $user_id, $transaction_id); // bind the parameters
    $stmt1->execute(); // execute the query

    $order_id= $stmt1->insert_id;
    $message = $order_id;
    echo "<script>console.log('".$message."');</script>";




    //go to user acc
    header('Location: ../account.php?message=Payment successful');


}
else{
    header('Location: ../account.php?error=Payment failed');
    
}

exit();




?>