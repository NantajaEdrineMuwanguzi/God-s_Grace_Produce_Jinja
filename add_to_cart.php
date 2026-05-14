<?php
session_start();
include 'config/db.php';

/*
=========================================
CHECK LOGIN
=========================================
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

/*
=========================================
GET PRODUCT ID
=========================================
*/

if(!isset($_GET['id'])){

    header("Location: shop.php");
    exit();
}

$product_id = intval($_GET['id']);

$user_id = $_SESSION['user_id'];

$customer_name = $_SESSION['fullname'];

/*
=========================================
GET PRODUCT
=========================================
*/

$product_query = mysqli_query($conn,

"SELECT * FROM products
WHERE id='$product_id'");

if(mysqli_num_rows($product_query) == 0){

    die("Product not found!");
}

$product = mysqli_fetch_assoc($product_query);

/*
=========================================
CREATE CART SESSION
=========================================
*/

if(!isset($_SESSION['cart'])){

    $_SESSION['cart'] = [];
}

/*
=========================================
ADD TO SESSION CART
=========================================
*/

$product_exists = false;

foreach($_SESSION['cart'] as &$item){

    if($item['id'] == $product['id']){

        $item['quantity'] += 1;

        $product_exists = true;

        break;
    }
}

if(!$product_exists){

    $_SESSION['cart'][] = [

        'id' => $product['id'],

        'name' => $product['name'],

        'price' => $product['price'],

        'image' => $product['image'],

        'quantity' => 1
    ];
}

/*
=========================================
SAVE ORDER IN DATABASE
=========================================
IMPORTANT:
YOUR orders TABLE SHOULD HAVE:
---------------------------------
id
user_id
customer_name
product_name
price
quantity
status
created_at
=========================================
*/

$product_name = $product['name'];

$price = $product['price'];

$quantity = 1;

$status = "Pending";

/*
=========================================
INSERT ORDER
=========================================
*/

mysqli_query($conn,

"INSERT INTO orders
(user_id, customer_name,
product_name, price,
quantity, status)

VALUES

('$user_id',
'$customer_name',
'$product_name',
'$price',
'$quantity',
'$status')");

/*
=========================================
GO TO CART
=========================================
*/

header("Location: cart.php");

exit();
?>