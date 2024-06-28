<?php 
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='shoes' LIMIT 4"); /* After connection, we prepare the SQL statement which will fetch the first 4 products from the database */

$stmt->execute(); /* Execute the statement */

$featured_prod_result = $stmt->get_result(); /* Get the result */

?>